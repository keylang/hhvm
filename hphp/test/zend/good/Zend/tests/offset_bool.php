<?php
<<__EntryPoint>> function main() {
$bool = TRUE;

var_dump($bool[1]);
var_dump($bool[0.0836]);
var_dump($bool[NULL]);
var_dump($bool["run away"]);

var_dump($bool[TRUE]);
var_dump($bool[FALSE]);

$fp = fopen(__FILE__, "r");
var_dump($bool[$fp]);

$obj = new stdClass;
var_dump($bool[$obj]);

$arr = array(1,2,3);
var_dump($bool[$arr]);

echo "Done\n";
}