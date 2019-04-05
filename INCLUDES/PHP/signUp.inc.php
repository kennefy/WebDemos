<?php

include"Var_Dumps.php";
require_once'validator2.php';
require_once'CLASS/messageFlags.class.php';


$username;
$email;
$firstName;
$surname;

$passwordRequirements ;

$messageBox="";

$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem', 'Please fix the errors below');


if(array_key_exists("submit",$_POST)){
	
	
	//Clean Input
    $username  = cleanInputString($_POST['username']);
	
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $confirmEmail = filter_var($_POST['confirmEmail'], FILTER_SANITIZE_EMAIL);
	
    $firstName = cleanInputString($_POST['firstName']);
    $surname = cleanInputString($_POST['surname']);
	
	$day = intval(cleanInputString($_POST['DOB-Day']));
	$month = intval(cleanInputString($_POST['DOB-Month']));
	$year = intval(cleanInputString($_POST['DOB-Year']));
	$DOB = $day." ".$month." ".$year;
	
	$country = cleanInputString($_POST['country']);
	
	$password = cleanInputString($_POST['password']);
	$confirmPassword = cleanInputString($_POST['confirmPassword']);
	

	if(!checkEmptyStringReturnMessage($username,'Username is Empty')){
		
		if(checkStrLengthReturnMessage($username,5,30,"Username is too")){
			
			checkUsernameTaken($username);
		}
	}
	
	checkNewEmail($email, $confirmEmail);
	
	
	if(!checkEmptyStringReturnMessage($firstName,'First name is Empty')){
		
		checkStrLengthReturnMessage($firstName,1,30,"First Name is too");	
		
	}
	

	if (!checkEmptyStringReturnMessage($surname,'Surname is Empty')){
		
		checkStrLengthReturnMessage($surname,1,30,"Surname is too");
	}

	if(!checkEmptyStringReturnMessage($day,'Date of Birth is Incomplete')){
		
		if(!checkEmptyStringReturnMessage($month,'Date of Birth is Incomplete')){
			
			if(!checkEmptyStringReturnMessage($year,'Date of Birth is Incomplete'))
			{
				checkValidDate($day, $month, $year);
			}
		}
	}	
	
	if(!checkEmptyStringReturnMessage($country,'Country is Empty')){
		
		if(!checkStrLengthReturnMessage($country,1,50,"Country Name is too")){
			
			checkCountry($country);
		}
	}
	
	checkNewPassword($password, $confirmPassword);
	
		
	
	$error->quickListFlags();
			
	if(!$error->flagsExist()){
		
			$signUpTime = getFormatTime();
			$encryptPassword= encryptInput($password);

				
			$sql = "INSERT INTO `users`(`uUsername`, `uEmail`, `uFirstName`, `uSurname`, `uDOBDay`, `uDOBMonth`,`uDOBYear`,`uPassword`, `uMemberSince`, `uLastPasswordChange`, `uCountry`,`uLastLogOn`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)){

				$message = "SQL SERVER ERROR - SIGN UP ".mysqli_stmt_error($stmt);
				$error->addFlag($message);
			}
			else{

				mysqli_stmt_bind_param($stmt,"ssssssssssss",$username, $email, $firstName,$surname,$day, $month, $year,$encryptPassword,$signUpTime,$signUpTime,$country,$signUpTime);

				mysqli_stmt_execute($stmt);
				
				// once addes sign the user in
				if(signIn($username,$password)){

					header('Location: account.php');

				}
				else{

					$message ="PHP SERVER ERROR - Failed to Sign up";
					$error->addFlag($message);
				}
			}
				
		}
		$messageBox = $error->getMessageBox();
			        
}
