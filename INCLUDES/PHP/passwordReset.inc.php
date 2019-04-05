<?php

include_once'validator2.php';


if(isset($_POST['validator']) and isset($_POST['key']))
{
	
	$password = $_POST['password'];
	$confPassword = $_POST['confPassword'];
	$key = $_POST['key'];
	$validator  = $_POST['validator'];
	
	$sql = "SELECT `pEmail` FROM `passwordResets` WHERE `pValidator` = ? AND `pKey` = ? LIMIT 1";
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql))
	{
			$flag = "SERVER ERROR - SQL STATEMENT FAILURE - PASSING KEYS ";
			$flag .= mysqli_stmt_error($stmt);
			$error->addFlag($flag);
	}
	else
	{
		mysqli_stmt_bind_param($stmt,"ss",$validator, $key);
		mysqli_stmt_execute($stmt);
		
		$result = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($result);
		
		if(is_null($row))
		{
			// NO results returned 
			$flag = "Sorry this key is now invalid - please request a new password reset - ";
					$flag .="<a href='../../signIn.php'> Click Here </a>  ";
			$error->addFlag($flag);
		}
		else
		{
			$email = $row['pEmail'];

			if(CheckNewPassword($password, $confPassword)){

				$encryptPassword = encryptInput($password);

				$sql = "UPDATE`users` SET `uPassword` = ?, `uLastPasswordChange` = ? WHERE `uEmail` = ? LIMIT 1";

				$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql))
			{
					$flag = "SERVER ERROR - SQL STATEMENT FAILURE - RESETTING PASSWORD STATEMENT";
					$flag .= mysqli_stmt_error($stmt);
					$error->addFlag($flag);
			}
			else
			{
				$time = getFormatTime();
				mysqli_stmt_bind_param($stmt,"sss",$encryptPassword,$time,$email);
				mysqli_stmt_execute($stmt);
				if(mysql_stmt_error($stmt) =="")
				{
					signIn($email, $password);

				}
				else
				{
					$flag = "SERVER ERROR - SQL STATEMENT FAILURE - RESETTING PASSWORD ";
					$flag .= mysqli_stmt_error($stmt);
					$error->addFlag($flag);
				}
			}			
		}
	}
}
}
	