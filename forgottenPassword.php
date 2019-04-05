<?php

session_start();
include_once("INCLUDES/PHP/navBarSignIn.inc.php");
include_once'INCLUDES/PHP/globals.inc.php';
include 'INCLUDES/PHP/requestPasswordReset.php';

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Forgotten Password - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    <div id="header">
        <?php include_once'INCLUDES/PHP/navbar.php'; ?>
    </div>
	
	<div class="container">
		
				<div id="messageArea">
					<?php echo $messageBox; ?>
    			</div>
			  <h1 class="display-4">Request a Password Reset</h1>
				<p> Please enter the email address you used to register with us. </p>
				<p>An email will be sent to the address to allow you to reset your password.</p>
		
	
				<form method="post" id="signinForm">
				  <div class="form-group">

					<label for="email">Email</label>
					<input type="text" class="form-control" id="email" placeholder="Enter your Email" name="email">
					</div>
				
					<div class="form-group">
					  <input type="submit"  value="submit" name="submit" class="btn-outline-success">
					</div>
				
				</form>
			</div>
			
				
	<div>

            <?php include_once'INCLUDES/PHP/footer.php'; ?>
        </div>
</body>
</html>