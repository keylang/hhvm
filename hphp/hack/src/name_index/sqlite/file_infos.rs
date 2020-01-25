// Copyright (c) Facebook, Inc. and its affiliates.
//
// This source code is licensed under the MIT license found in the
// LICENSE file in the "hack" directory of this source tree.

use crate::datatypes::*;
use crate::Names;

use ocamlrep::rc::RcOc;
use oxidized::file_info::FileInfo;
use oxidized::relative_path::RelativePath;
use rusqlite::{params, Connection};

#[derive(Debug)]
pub(crate) struct FileInfoItem {
    path: RcOc<RelativePath>,
    file_info: FileInfo,
}

// TODO: some functions is only used in unit tests for now
#[allow(dead_code)]
impl Names {
    pub(crate) fn create_file_info_table(connection: &Connection) {
        let statement = "
            CREATE TABLE IF NOT EXISTS NAMING_FILE_INFO (
                FILE_INFO_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                PATH_PREFIX_TYPE INTEGER NOT NULL,
                PATH_SUFFIX TEXT NOT NULL,
                TYPE_CHECKER_MODE INTEGER,
                DECL_HASH TEXT,
                CLASSES TEXT,
                CONSTS TEXT,
                FUNS TEXT,
                RECS TEXT,
                TYPEDEFS TEXT
            );";

        connection.execute(&statement, params![]).unwrap();
    }

    fn insert_file_infos(&self, items: &[FileInfoItem]) {
        let insert_statement = "
            INSERT INTO NAMING_FILE_INFO (
                PATH_PREFIX_TYPE,
                PATH_SUFFIX,
                TYPE_CHECKER_MODE,
                DECL_HASH,
                CLASSES,
                CONSTS,
                FUNS,
                RECS,
                TYPEDEFS
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            );";
        let connection = &self.connection;
        let mut insert_statement = connection.prepare(&insert_statement).unwrap();

        for item in items {
            let path_prefix_type = convert::prefix_to_i64(item.path.prefix());
            let path_suffix = item.path.path_str();
            let type_checker_mode = convert::mode_to_i64(item.file_info.file_mode);
            let decl_hash = "TODO: OpaqueDigest is just a stub currently";
            let classes = convert::ids_to_string(&item.file_info.classes);
            let consts = convert::ids_to_string(&item.file_info.consts);
            let funs = convert::ids_to_string(&item.file_info.funs);
            let recs = convert::ids_to_string(&item.file_info.record_defs);
            let typedefs = convert::ids_to_string(&item.file_info.typedefs);

            let result = insert_statement.execute(params![
                path_prefix_type,
                path_suffix,
                type_checker_mode,
                decl_hash,
                classes,
                consts,
                funs,
                recs,
                typedefs
            ]);

            match result {
                Ok(_v) => println!("Inserted row OK"),
                Err(e) => println!("Error: {:?}", e),
            }
        }
    }
}

#[cfg(test)]
mod tests {
    use super::*;
    use ocamlrep::rc::RcOc;
    use oxidized::file_info::{Id, Mode, NameType, Pos};
    use oxidized::relative_path::Prefix;
    use std::path::PathBuf;

    #[test]
    fn test_add_file_info() {
        let names = Names::new("");
        let path = RcOc::new(RelativePath::make(Prefix::Root, PathBuf::from("foo.php")));
        let file_infos = [FileInfoItem {
            path: RcOc::clone(&path),
            file_info: FileInfo {
                hash: None,
                file_mode: Some(Mode::Mstrict),
                classes: vec![Id(Pos::File(NameType::Class, path), "Foo".to_string())],
                consts: vec![],
                funs: vec![],
                record_defs: vec![],
                typedefs: vec![],
                comments: None,
            },
        }];
        names.insert_file_infos(&file_infos);
    }
}
