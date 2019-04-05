<?php

require"dbConn.php";
include_once'CLASS/messageFlags.class.php';



//check if access to page

$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem Resetting Your Password', 'Please fix the errors below');

$success = new messageBox();
$success->setBoxType("success","Please Check your inbox",""); 

require_once"validator2.php";

//if(array_key_exists("submit", $_POST)){
	if(isset($_POST['submit']))
	{		
		if(checkEmail($_POST['email']))
		{
			$email = $_POST['email'];
			//generate key, token and expiry time
			$key = bin2hex(random_bytes(8));
			$token = random_bytes(32);


			if(!$error->flagsExist())
			{
				if(checkEmailExists($email))
				{
				$resetLimit = 30; //amount in Mins 
				$keyExpires = date("U") + ($resetLimit*60);

				//add keys to email address for reset password page
				//$resetUrl = "http//www.boobbah.com/forgottenpassword/resetpassword.php?key=".$key."&validator=".bin2hex($token);
				$resetUrl = "localhost:8888/forgottenPasswordReset.php?key=".$key."&validator=".bin2hex($token);
				//checkEmailExists($email);

				//delete any previous tokens
				$sql =  "DELETE FROM `passwordResets` WHERE pEmail = ? LIMIT 1";

				$stmt = mysqli_stmt_init($conn);


						if(!mysqli_stmt_prepare($stmt, $sql))
						{
								$flag = "SERVER ERROR - SQL STATEMENT FAILURE - CHECKING RESETTING OLD KEY ";
								$flag .= mysqli_stmt_error($stmt);
								$error->addFlag($flag);
						}
						else
						{
							//bind passed parameters to prepared statement (s=string i=int d=double)
							mysqli_stmt_bind_param($stmt,"s",$email);
							mysqli_stmt_execute($stmt);
						}
				//insert new email and keys and expiry

				$sql = "INSERT INTO `passwordResets` (`pEmail`, `pValidator`,`pKey`,`pKeyExpire`,`pRequestDate`, `pUsed`) VALUES (?,?,?,?,?,?)";

				$stmt = mysqli_stmt_init($conn);

					if(!mysqli_stmt_prepare($stmt, $sql))
					{
							$flag = "SERVER ERROR - SQL STATEMENT FAILURE - CHECKING RESETTING PASSWORD ";
							//$flag .= mysqli_stmt_error($stmt);
							$error->addFlag($flag);
					}
					else
					{
						$token = bin2hex($token);
						$hashedToken = encryptInput($token);
						$used = "No";
						$requestTime = getFormatTime();
						//bind passed parameters to prepared statement (s=string i=int d=double)
						mysqli_stmt_bind_param($stmt,"ssssss",$email,$hashedToken,$key,$keyExpires,$requestTime, $used);
						mysqli_stmt_execute($stmt);
						if(mysqli_stmt_error($stmt)==""){


							$flag = "Email will expire after ".$resetLimit." minutes.";
							$success->addFlag($flag);

							$to = $email;
							$subject = "Password Reset Request - ".$GLOBAL['G_SiteName'];

							$message = "<h4>We received a request to reset a forgotten password</h4>";

							$message .="<p> If you requested to reset your password please click the link below.</p>";

							$message .=" <p> If you did <strong>NOT</strong> request a new password please ignore this email. </p>";

							$message .="<p> Your email link is below  - this will expire in ".$resetLimit." minutes.";

							$message .="<a href='".$resetUrl."'>.'$resetUrl.'</a>";

							$headers = 'From: '.$GLOBAL["G_SiteName"].' - <'.$GLOBAL["G_SiteEmailMain"].'>\r\n';
							$headers .= 'Reply-To: '.$GLOBAL["G_SiteEmailReply"].'\r\n';
							$headers .= "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

							//send email

							if(mail($to,$subject,$message,$headers))
							{
								$flag = "Email Sent.";
								$success->addFlag($flag);
							}
							else
							{								
								$flag = "Error Sending Email to Server";
								$error->addFlag($flag);
							}

						} 
						else
						{
							$er = mysqli_stmt_error($stmt);
							$flag = "Error completing database - ".$er;
							$error->addFlag($flag);
						}
					}		
				}
				else
				{
					$flag = "Sorry we can't find that email...";
					$flag.= "<a href='../../signUp.php' class='alert-link'>";
					$flag.= "Click Here";
					$flag .= "</a> to join.";
					
							$error->addFlag($flag);
				}
			}
		}
		
	}

	if($error->flagsExist())
	{
		$messageBox = $error->getMessageBox();
	}
	elseif($success->flagsExist())
	{

		$messageBox = $success->getMessageBox();
		echo "<a href='".$resetUrl."'> Click </a>";
	}
	
	




