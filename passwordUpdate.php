<?php

session_start();

include_once("INCLUDES/PHP/navBarSignIn.inc.php");
include_once('INCLUDES/PHP/validator2.php');
include_once('INCLUDES/PHP/Var_Dumps.php');
include_once('INCLUDES/PHP/dbConn.php');

$error = new messageBox();
$error->setBoxType("error", "Sorry there is an Error", "");

$success = new messageBox();
$success->setBoxType("Success", "Success", "");


$row = getAccount($_SESSION['id']);

if(array_key_exists('save',$_POST))
{
	if(encryptInput($_POST['currentPassword']) === $row['uPassword'])
	{
	
		if(checkNewPassword($_POST['password'], $_POST['confPassword']))	
		{
			updatePassword($_POST['password']);
						
		}
	}
	else
	{
		$flag = " Sorry that is not the right password for your account";
		$error->addFlag($flag);	
	}
	
	
		if($success->flagsExist())
	{
		$messageBox = $success->getMessageBox();
	}
	else
	{
		$messageBox = $error->getMessageBox();
	}
}
	

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Password Reset - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
    <div class="row">
        <div class="col-8">
            <h1 class="text-muted">

             Change My Password</h1>

            <hr class="my-4">
			

            <div id="details">
				
                <form method="POST">
                    <div id="errorArea">
                        <?php echo $messageBox; ?>
                    </div>
                   
					<div class="form-group col-8">
					
                        <label for="email">Current Password</label>
                        <input class="form-control" type="password" id="currentPassword" name="currentPassword" value="">
						
						
                    </div>
					<hr>
                    <div class="form-group col-8">
					
                        <label for="email">New Password</label>
                        <input class="form-control" type="password" id="password" name="password" value="">
						
						
                    </div>
					     <div class="form-group col-8">
						
                        <label for="email">Confirm New Password</label>
                        <input class="form-control" type="password" id="confPassword" name="confPassword" value="">
							
                    </div>
                    
                        
                        </select>
                    <input type="submit" class="btn btn-info mt-2" name="save" value="Save Changes">
                    
                    </div>
					
                    
                </form>
            </div>
        </div>

        <div>

            <?php include'INCLUDES/PHP/footer.php'; ?>
        </div>
    </div>
</body>

</html>
