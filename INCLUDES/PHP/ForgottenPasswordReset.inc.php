<?php

include_once'CLASS/messageFlags.class.php';
include_once'dbConn.php';
include_once'validator2.php';
include 'Var_Dumps.php';
/*
*
check get Variables are set
check get variables match the database
chek key not expired

get post paswwords
check post passwords
insert into db

direct user to account with log in with new details

*/

$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem Resetting Your Password', 'Please fix the errors below');

$success = new messageBox();
$success->setBoxType("success","Please Reset your Password",''); 

if(array_key_exists('validator',$_GET) AND array_key_exists('key',$_GET) )
{
	$validator = $_GET['validator'];
	$key = $_GET['key'];

	if(empty($validator) or empty($key)){
		
		//user has tried to pass empty keys in get
		$flag = "Sorry this key is Empty - please request a new password reset - ";
		$flag .="<a href='../../signIn.php' class='alert-link'> Click Here </a>  ";
		$error->addFlag($flag);
	}
	else
	{
		$sql = "SELECT `pEmail`,`pKeyExpire`,`pValidator` FROM `passwordResets` WHERE `pKey` = ? LIMIT 1";
	
		$stmt = mysqli_stmt_init($conn);
	
		if(!mysqli_stmt_prepare($stmt, $sql))
		{
				// SQL statement failure
				$flag = "SERVER ERROR - SQL STATEMENT FAILURE - PASSING KEYS ";
				$flag .= mysqli_stmt_error($stmt);
				$error->addFlag($flag);
		}
		else
		{
			mysqli_stmt_bind_param($stmt,"s", $key);
			mysqli_stmt_execute($stmt);

			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_array($result);

			if(is_null($row))
			{
				// NO results returned - key and validator do not match database
				$flag = "Sorry this key is now Invalid - please request a new password reset - ";
				$flag .="<a href='../../signIn.php' class='alert-link'> Click Here </a>  ";
				$error->addFlag($flag);
			}
			else
			{
				if(password_verify($validator,$row['pValidator']))
				{
				$email = $row['pEmail'];
				$keyExpire= $row['pKeyExpire'];

				$currentTime = date("U");

				if($currentTime >= $keyExpire)
				{
					//current server time is later than the expire key value
					$flag = "Sorry this key has Expired - please request a new password reset - ";
					$flag .="<a href='../../signIn.php' class='alert-link'> Click Here </a>  ";
					$error->addFlag($flag);
				}
				else
				{
	
					//$flag = "Please pick a new password";
					//$success->addFlag($flag);
					
					if(isset($_POST['checkPassword']))
					{

						$password = $_POST['password'];
						$confPassword = $_POST['confPassword'];
						$email = $row['pEmail'];

						if(CheckNewPassword($password, $confPassword))
						{

							$password = encryptInput($password);

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
								mysqli_stmt_bind_param($stmt,"sss",$password,$time,$email);
								mysqli_stmt_execute($stmt);
								if(mysqli_stmt_error($stmt) =="")
								{
									$flag = "Succces! Password has been changed - ";
									$flag .= '<a href="signIn.php" class="link-success">Click Here to sign in</a>';
									$success->addFlag($flag);
									
									// set key to expire
									$sql = "UPDATE`passwordResets` SET `pKeyExpire` =?, `pUsed` = ? WHERE `pEmail` = ? LIMIT 1";

									$stmt = mysqli_stmt_init($conn);

									if(!mysqli_stmt_prepare($stmt, $sql))
									{
											$flag = "SERVER ERROR - SQL STATEMENT FAILURE - RESETTING PASSWORD STATEMENT";
											$flag .= mysqli_stmt_error($stmt);
											$error->addFlag($flag);
									}
									else
									{
										$used = "Yes";
										mysqli_stmt_bind_param($stmt,"sss",$time,$used,$email);
										mysqli_stmt_execute($stmt);
									}
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
		}
	}
}
}
else
{
	//No key or Validator in GET
	$flag = "INVALID ACCESS";
	$error->addFlag($flag);
}
if($error->flagsExist())
	{
		$messageBox = $error->getMessageBox();
	}
	elseif($success->flagsExist())
	{

		$messageBox = $success->getMessageBox();
		
	}
