<?php

include_once("INCLUDES/PHP/navBarSignIn.inc.php");
include_once 'INCLUDES/PHP/validator2.php';
include_once 'INCLUDES/PHP/CLASS/messageFlags.class.php';


session_start();

$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem Sending your message', '');

$success = new messageBox();
$success->setBoxType("success","Message Sent","Thank you for taking the time to get in touch"); 

if(array_key_exists("send", $_POST))
{
	$userEmail = $_POST['contactEmail'];
	$userSubject = $_POST['subject'];
	$userMessage = $_POST['userMessage'];
	
	if(checkEmail($userEmail) and !checkEmptyStringReturnMessage($userSubject, "Your Email Subject is empty") and
	  ! checkEmptyStringReturnMessage($userMessage, "Your Message is empty"))
	{
			
		
		   $to = $GLOBAL["G_SiteEmailMain"];
							 

			$message = "<h4>We received a request to reset a forgotten password</h4>";

			$message .="Message From: -".$userEmail;
		
			$message.= "<br>".getFormatTime();
			$message.= "<br>".$userSubject;

			$message .=" <br> ".$userMessage;

			$headers = 'From: '.$userEmail.' - <'.$userEmail.'>\r\n';
			$headers .= 'Reply-To: '.$userEmail.'\r\n';
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			//send email

			if(mail($to,$userSubject,$message,$headers))
			{
				$flag = "Message Sent.";
				$success->addFlag($flag);
			}
			else
			{								
				$flag = "Error Sending message to Server";
				$error->addFlag($flag);
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

?>
<html lang="en">

<head>


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Contact Us - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">
	<style>
		#textArea
		{
			height:400px;
		}
	
	
	</style>

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
	<div id="messageArea">
                        <?php echo $messageBox; ?>
    </div>
	<div class="container m-3">
		
			<div class="col-md">
			  <h1 class="display-4">Get in touch with us!</h1>
			</div>
				<form method="post" id="signinForm">
			  <div class="form-group">
				
				<label for="username">Your Email Address</label>
				<input type="username" class="form-control col-xs-4" id="yourEmail" placeholder="Email" name="contactEmail" value="<?php echo $username; ?>">

			  </div>
				  <div class="form-group">
				<label for="password">Subject</label>
				<input type="text" class="form-control col-xs-4" id="subject" placeholder="Message Subject" name="subject">
			  </div>
			  <div class="form-group">
				<label for="password">Your Message</label>
				  <textarea class="form-control" id="textArea" name="userMessage"></textarea>
			  </div>
			  <div>
			  <input class="btn btn-outline-secondary btn-block m-2" type="submit" id="sendBtn" name="send" value="Send It">
					</div> 
			</form>
		</div>
	
	<div>

            <?php include'INCLUDES/PHP/footer.php'; ?>
        </div>
</body>
</html>