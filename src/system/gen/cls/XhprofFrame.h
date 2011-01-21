/*
   +----------------------------------------------------------------------+
   | HipHop for PHP                                                       |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010 Facebook, Inc. (http://www.facebook.com)          |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
*/
// @generated by HipHop Compiler

#ifndef __GENERATED_cls_XhprofFrame_hed1dc80a__
#define __GENERATED_cls_XhprofFrame_hed1dc80a__

#include <cls/XhprofFrame.fw.h>

namespace HPHP {
///////////////////////////////////////////////////////////////////////////////

/* SRC: classes/xhprof.php line 6 */
FORWARD_DECLARE_CLASS(XhprofFrame);
class c_XhprofFrame : public ExtObjectData {
  public:

  // Properties

  // Class Map
  virtual bool o_instanceof(CStrRef s) const;
  DECLARE_CLASS_COMMON(XhprofFrame, XhprofFrame)
  DECLARE_INVOKE_EX(XhprofFrame, XhprofFrame, ObjectData)

  // DECLARE_STATIC_PROP_OPS
  public:
  #define OMIT_JUMP_TABLE_CLASS_STATIC_GETINIT_XhprofFrame 1
  #define OMIT_JUMP_TABLE_CLASS_STATIC_GET_XhprofFrame 1
  #define OMIT_JUMP_TABLE_CLASS_STATIC_LVAL_XhprofFrame 1
  #define OMIT_JUMP_TABLE_CLASS_CONSTANT_XhprofFrame 1

  // DECLARE_INSTANCE_PROP_OPS
  public:
  #define OMIT_JUMP_TABLE_CLASS_GETARRAY_XhprofFrame 1
  #define OMIT_JUMP_TABLE_CLASS_SETARRAY_XhprofFrame 1
  #define OMIT_JUMP_TABLE_CLASS_realProp_XhprofFrame 1
  #define OMIT_JUMP_TABLE_CLASS_realProp_PRIVATE_XhprofFrame 1

  // DECLARE_INSTANCE_PUBLIC_PROP_OPS
  public:
  #define OMIT_JUMP_TABLE_CLASS_realProp_PUBLIC_XhprofFrame 1

  // DECLARE_COMMON_INVOKE
  static bool os_get_call_info(MethodCallPackage &mcp, int64 hash = -1);
  #define OMIT_JUMP_TABLE_CLASS_STATIC_INVOKE_XhprofFrame 1
  virtual bool o_get_call_info(MethodCallPackage &mcp, int64 hash = -1);

  public:
  DECLARE_INVOKES_FROM_EVAL
  void init();
  public: virtual void destruct();
  public: void t___construct(Variant v_name);
  public: c_XhprofFrame *create(Variant v_name);
  public: ObjectData *dynCreate(CArrRef params, bool init = true);
  public: void dynConstruct(CArrRef params);
  public: void getConstructor(MethodCallPackage &mcp);
  public: void dynConstructFromEval(Eval::VariableEnvironment &env, const Eval::FunctionCallExpression *call);
  public: Variant t___destruct();
  DECLARE_METHOD_INVOKE_HELPERS(__destruct);
  DECLARE_METHOD_INVOKE_HELPERS(__construct);
};
extern struct ObjectStaticCallbacks cw_XhprofFrame;
Object co_XhprofFrame(CArrRef params, bool init = true);
Object coo_XhprofFrame();

///////////////////////////////////////////////////////////////////////////////
}

#endif // __GENERATED_cls_XhprofFrame_hed1dc80a__
