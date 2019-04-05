<?php

session_start();

include_once('INCLUDES/PHP/validator2.php');
include_once('INCLUDES/PHP/Var_Dumps.php');
include_once('INCLUDES/PHP/dbConn.php');

$error = new messageBox();
$error->setBoxType("error", "Sorry there is an Error", "");
$success = new messageBox();
$success->setBoxType("success", "Success", "");


$row = getAccount($_SESSION['id']);

if(array_key_exists('save',$_POST))
{
	if($_POST['email'] != $row['uEmail'])
	{
		if(checkNewEmail($_POST['email'], $_POST['confEmail']))	{
			
			$sql  = "UPDATE `users` SET `uEmail` = ? WHERE `uID` = ? LIMIT 1";
			
			$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					
					$flag="ERROR SQL Statement Failed";
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "si", $_POST['email'], $_SESSION['id']);
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_errno($stmt) != 0)
					{
						
						$flag="ERROR - Could not update email - ";
						$error->addFlag($flag);
						
					}
					elseif(mysqli_stmt_affected_rows($stmt)>0)
					{
						$flag="Email has been updated";
						$success->addFlag($flag);
					}
						
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
	}

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Account - <?php echo $_GLOBALS['G_SiteName'];?></title>
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

             Change My Email Address</h1>

            <hr class="my-4">
			

            <div id="details">
				
                <form method="POST">
                    <div id="errorArea">
                        <?php echo $messageBox; ?>
                    </div>
                   
                    <div class="form-group col-8">
					
                        <label for="email">Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" value="">
						
						
                    </div>
					     <div class="form-group col-8">
						
                        <label for="email">Confirm Email Address</label>
                        <input class="form-control" type="email" id="confEmail" name="confEmail" value="">
							
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
