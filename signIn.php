<?php

include_once('INCLUDES/PHP/signIn.inc.php') ;

session_start();

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Sign In - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
	<div class="container">
	<div id="messageArea">
                        <?php echo $messageBox; ?>
    </div>
	<div class="m-3">
		<div class="row">
			<div class="col-md">
			  <h1 class="display-4">Sign In!</h1>
			  <div class="form-group">
				<form method="post" id="signinForm">
				<label for="username">Username</label>
				<span class="errMsg" id="usernameErr"></span>
				<input type="username" class="form-control" id="usernameInput" placeholder="Username or Email" name="username" value="<?php echo $username; ?>">

			  </div>
			  <div class="form-group">
				<label for="password">Password</label>
				 <span class="errMsg" id="passwordErr"></span>
				<input type="password" class="form-control" id="passwordInput" placeholder="Password" name="password">
			  </div>
			  <div class="form-group form-check">
				<input type="checkbox" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Keep me signed in</label>
			  </div>
			  <input class="btn btn-outline-secondary m-2" type="submit" id="signinBtn" name="signin" value="Sign In">
				  <hr>
				<a class="pageLink" href="forgottenPassword.php"> Forgotten Your Password?</a>
			</form>
			</div>
		</div>
	</div>
		</div>
	<div>

            <?php include'INCLUDES/PHP/footer.php'; ?>
        </div>
	
	<script type="text/javascript">
		
	
		
		$("#signinForm").submit(function()
		 {
			
			var errCount = 0;
			console.log($("#usernameInput").val());
			console.log($("#usernameInput").val().length);
			
			if($("#passwordInput").val().length < 1)
				{
					$("#passwordInput").addClass("border border-danger");
					errCount +=1;
				}
			else if($("#passwordInput").val().length <= 5)
				{
					$("#passwordErr").text(" - Password is too short");
					$("#passwordErr").addClass("text-danger");
					$("#passwordInput").addClass("border border-danger");
					console.log("Password Error");
					errCount +=1;
				}
			
			
			if($("#usernameInput").val().length < 1)
				{
					
					$("#usernameInput").addClass("border border-danger");
					errCount +=1;
				}
				
			
			if(errCount > 0)
				{
					return false;
				}
			else 
				{
					
					console.log("Valid Input");
					return true;
				}
			
		});
	
	</script>
</body>
</html>