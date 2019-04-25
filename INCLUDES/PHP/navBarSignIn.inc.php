<?php
/*********************
*Signin Navbar Include
*08/01/2019
* Kenny Montgomery
*
*Decription
*
*PHP for signin using navbar inputs
 Uses Validator2 to check inputs are not empty on server side
 If empty user is directed to signin page with no error message displayed
 
 If not empty it will try and sign in using details, if this is successful user is directed to Index and nave bar will display signed in
 
 If not they are directed to signin page with error message displayed
*
*todo
*
*
*Known Faults
*********************/
include_once("INCLUDES/PHP/validator2.php");

if(array_key_exists("nav-signIn",$_POST))
	//Confirm signin button has been submitted
{
	
	if(checkEmpty($_POST['nav-username']) or checkEmpty($_POST['nav-password']))
	{
		header('Location: signIn.php');
		//username or password is blank
	}
	else
	{
		if(signIn($_POST['nav-username'],$_POST['nav-password']))
		{
			
			header('Location: index.php');
			// username and Password matched in database
		}
		else
		{	
			
			header('Location: signIn.php?error');
			// username and Password not matched in database
		}
	}		
}