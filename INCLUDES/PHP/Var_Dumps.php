<?php
session_start();

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
//var_dump($_SERVER);
	
	
}
