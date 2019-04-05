<?php

include_once("INCLUDES/PHP/navBarSignIn.inc.php");
include'Var_Dumps.php';
include_once'CLASS/messageFlags.class.php';
include_once'validator2.php';


$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem Signing In', 'Please fix the errors below');

$username;
$messageBox;

if(array_key_exists("signin",$_POST))
{
	

    $username  = $_POST['username'];
	$password = $_POST['password'];
	
	
	if(signIn($username,$password)){
	
		header('Location: account.php');
	
		}
		
}

if(array_key_exists("error",$_GET))
{
	
	$flag = "Username or  Password is incorrect -  please try again";
	$error->addFlag($flag);
}

if($error->flagsExist())
{
	$messageBox = $error->getMessageBox();
	
}
