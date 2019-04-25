<?php

$mode = "local";

if ($mode ==="local")
{
$dbUser = 'root';
$dbPassword = 'root';
$dbName = 'BoobBah-393712e2';
$dbHost = 'localhost';
$dbPort = 8889;
	
	
}
else
{


$dbUser = 'BoobBah-393712e2';
$dbPassword = '^Jf&Pt&AtmB*4nJ9Wvy8';
$dbName = 'BoobBah-393712e2';
$dbHost = 'shareddb-k.hosting.stackcp.net';
$dbPort = 8889;
}
$conn = mysqli_connect($dbHost, $dbUser, $dbPassword,$dbName);

if(mysqli_connect_error()){
    
    die( "Error connecting to database");
    echo setErrorBox('Error Database Connections <br> Catastrophic Failure');
}


?>