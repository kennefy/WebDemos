<?php

session_start();
include_once("INCLUDES/PHP/navBarSignIn.inc.php");
include_once'INCLUDES/PHP/globals.inc.php';
require'INCLUDES/PHP/ForgottenPasswordReset.inc.php';
include_once'INCLUDES/PHP/validator2.php';

$messageBox;

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Reset Password - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    <div id="header">
        <?php include_once'INCLUDES/PHP/navbar.php'; ?>
    </div>
	
	<div class="container m-3">
		<div class="row">
			<div class="col-md">
			  <h1 class="display-4">Password Reset</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md">
				<div id="messageArea">
                        <?php echo $messageBox; ?>
   				 </div>
			</div>
<div class="row">
						<div class="col-md">
							<form method="post" id="signinForm">
								<div class="form-group">

									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" placeholder="Enter a new Password" name="password">

								</div>
								<div class="form-group">

									<label for="confPassword">Confirm Password</label>
									<input type="password" class="form-control" id="confPassword" placeholder="Renter your new Password" name="confPassword">
									<?php echo $passwordRequirements; ?>
								</div>

								<div class="form-group">
									<input type="hidden" class="form-control" name="validator" value="<?php $validator; ?>">
									<input type="hidden" class="form-control" name="key" value="<?php $key; ?>">
									<input type="submit"  value="Reset my Password" name="checkPassword" class="btn-outline-success btn btn-block" >
								</div>
							</form>
						</div>
					</div>	
		</div>
	</div>	

	
	<div>

            <?php include_once'INCLUDES/PHP/footer.php'; ?>
        </div>
</body>
</html>