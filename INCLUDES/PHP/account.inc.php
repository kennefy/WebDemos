<?php
	  
include"INCLUDES/PHP/Var_Dumps.php";
include_once"INCLUDES/PHP/dbConn.php";
include_once "INCLUDES/PHP/validator2.php";
include_once"INCLUDES/PHP/messageFlags.class.php";
include_once"INCLUDES/PHP/children.inc.php";


$error = new messageBox();
$error->setBoxType("error", "Sorry there is an Error", "");
$success = new messageBox();
$success->setBoxType("success", "Success", "");

getAccount($_SESSION['id']);

$childrenArray = getChildren();

  
if(array_key_exists('add', $_POST)){
	
	addChild();
} 

	if(!array_key_exists('id',$_SESSION)){
		
		header('Location: index.php');
	}
	   else
	   {
		   $row = getAccount($_SESSION['id']);
	   }
	$username = $row['uUsername'];
				   $email = $row['uEmail'];
				   $firstName = $row['uFirstName'];
				   $surname = $row['uSurname'];
				   $DOBday = $row['uDOBDay'];
				   $DOBmonth = $row['uDOBMonth'];
				   $DOByear = $row['uDOBYear'];
					$passwordChange = $row['uLastPasswordChange'];
	if(array_key_exists('save', $_POST))
	{
		
	
		//check it is not the same as lase username
		if($username != $_POST['username'])
		{

			if(!checkUsernameExists($_POST['username']))
			{
				
				$sql = "UPDATE `users` SET `uUsername` = ? WHERE `uID` = ? LIMIT 1";
				
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					
					$flag="ERROR SQL Statement Failed Update Username";
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "si", $_POST['username'], $_SESSION['id']);
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_errno($stmt) != 0)
					{
						
						$flag="ERROR - Could not update Username - ";
						$error->addFlag($flag);
						
					}
					elseif(mysqli_stmt_affected_rows($stmt)>0)
					{
						$flag="Username has been updated";
						$success->addFlag($flag);
					}
						
				}
				
				
				

			}
			else
			{
				$flag="Sorry That username is already taken, please pick another.";
				$error->addFlag($flag);
			}
		}
		if($firstName != $_POST['firstName'])
		{
				$sql = "UPDATE `users` SET `uFirstName` = ? WHERE `uID` = ? LIMIT 1";
				
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					
					$flag="ERROR SQL Statement Failed Set Firstname";
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "si", $_POST['firstName'], $_SESSION['id']);
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_errno($stmt) != 0)
					{
						
						$flag="ERROR - Could not update First name - ";
						$error->addFlag($flag);
						
					}
					elseif(mysqli_stmt_affected_rows($stmt)>0)
					{
						$flag="Name has been updated";
						$success->addFlag($flag);
					}
						
				}
		}
		if($surame != $_POST['surname'])
		{
			$sql = "UPDATE `users` SET `uSurname` = ? WHERE `uID` = ? LIMIT 1";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){

				$flag="ERROR SQL Statement Failed set Surname";
				$error->addFlag($flag);
			}
			else
			{
				mysqli_stmt_bind_param($stmt, "si", $_POST['surname'], $_SESSION['id']);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_errno($stmt) != 0)
				{

					$flag="ERROR - Could not update surname - ";
					$error->addFlag($flag);

				}
				elseif(mysqli_stmt_affected_rows($stmt)>0)
				{
					$flag="Name has been updated";
					$success->addFlag($flag);
				}

			}
		}
		if($DOBday != $_POST['DOB-Day'] or $DOBmonth != $_POST['DOB-Month'] or $DOByear != $_POST['DOB-Year'] )
		{
			$sql = "UPDATE `users` SET `uDOBDay` = ?, `uDOBMonth` = ?, `uDOBYear` = ? WHERE `uID` = ? LIMIT 1";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){

				$flag="ERROR SQL Statement Failed Set DOB";
				$error->addFlag($flag);
			}
			else
			{
				mysqli_stmt_bind_param($stmt, "sssi", $_POST['DOB-Day'],$_POST['DOB-Month'],$_POST['DOB-Year'], $_SESSION['id']);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_errno($stmt) != 0)
				{

					$flag="ERROR - Could not update DOB - ";
					$error->addFlag($flag);

				}
				elseif(mysqli_stmt_affected_rows($stmt)>0)
				{
					$flag="DOB has been updated";
				}

			}
		}
		
		if($country != $_POST['country'])
		{
			if(checkCountry($_POST['country']))
			{
				$sql = "UPDATE `users` SET `uCountry` = ? WHERE `uID` = ? LIMIT 1";
				
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					
					$flag="ERROR SQL Statement Failed set Country";
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "si", $_POST['country'], $_SESSION['id']);
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_errno($stmt) != 0)
					{
						
						$flag="ERROR - Could not update Country - ";
						$error->addFlag($flag);
						
					}
					elseif(mysqli_stmt_affected_rows($stmt)>0)
					{
						$flag="Country has been updated";
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
		$row = getAccount($_SESSION['id']);
		$username = $row['uUsername'];
	   $email = $row['uEmail'];
	   $firstName = $row['uFirstName'];
	   $surname = $row['uSurname'];
	   $DOBday = $row['uDOBDay'];
	   $DOBmonth = $row['uDOBMonth'];
	   $DOByear = $row['uDOBYear'];
		
	}