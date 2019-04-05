<?php

include_once("INCLUDES/PHP/validator2.php");

if(array_key_exists("nav-signIn",$_POST))
{
	
	if(checkEmpty($_POST['nav-username']) or checkEmpty($_POST['nav-password']))
	{
		header('Location: signIn.php');
	}
	else
	{
		if(signIn($_POST['nav-username'],$_POST['nav-password']))
		{
			
			header('Location: index.php');
		}
		else
		{	
			
			header('Location: signIn.php?error');
		}
	}		
}