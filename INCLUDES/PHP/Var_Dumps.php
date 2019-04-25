<?php
session_start();

/*********************
*Var _ Dumps
*08/01/2019
* Kenny Montgomery
*
*Decription
*
*Used for debugging - Set debug view to true to see contents of $SESSION $POST, $SERVER, $GET
*
*todo
*
*
*********************/

$debug_view = false; 


if($debug_view){
	

echo "SESSION <br>";
var_dump($_SESSION);

echo "<br>";
echo "<br>";

echo "POST <br>";
var_dump($_POST);
	
echo "<br>";
echo "<br>";

echo "SERVER <br>";
var_dump($_SERVER);
	
	
}
