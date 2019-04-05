<?php

include_once"dbConn.php";
include_once"Countries.php";
include_once"months.php" ;
require_once "CLASS/messageFlags.class.php";
include_once "globals.inc.php";

if(!isset($error->exists))
{
	//Checks to see if an error message box has  not been created  and if not creates one.
	$error = new messageBox();
	$error->setBoxType('error', 'Sorry There Was A Problem', 'Please fix the errors below');
}


//*****STRING CHECKS*****//

function cleanInputString($s){
    // a quick clean function to exchange to html entites 
    // Should only be used for text input and not email address or password
    global $error;
	if(!empty($s)){

        $s = trim($s);
	
	}
    return $s;
}

function checkEmpty($s){
    // logical check to see if value is empty
    if(!isset($s)){
        
        return true;
    }
    else
    {
        return false;
    }
}

function checkEmptyStringReturnMessage($s, $message){
	global $error;
    // checks to see if value is empty and if it is adds error message to the error array
    if(!isset($s)){
        
        
		$error->addFlag($message);
		return true;
		
	}
	else{
		return false;
	}
}

function checkMatchReturnMessage($s1, $s2, $message){
	global $error;
    // checks to see if two string match if false returns message string 
    if($s1 != $s2){
        
        $error->addFlag($message);
		return false;
    }
	else{
		
		return true;
	}
   
}

function checkStrLength($s, $min, $max){
    //checks a string is a certain length
    
    $i = strlen($s);
        
    if($i < $min or $i > $max){
        
        return false;
        
    }
    
}
	function checkStrLengthReturnMessage($s, $min, $max, $message){
    //checks a string is a certain length and adds error message to flags array
    
	global $error;
		
    $i = strlen($s);
        
    if($i < $min){
		
		$message .=" small, it must be at least ".$min." in length";
        
        $error->addFlag($message);
		return false;
        
    }
	elseif($i > $max){

		$message .=" big, it must be at least ".$max." in length";

		$error->addFlag($message);
		return false;

	}
	else{
			
		return true;
	}
    
}

function checkMaxArrayLength($array)
{
	
	$MaxLength = 0;
	$Name;
	
	foreach($array as $item)
	{
		if(strlen($item)>$MaxLength)
		{
			$MaxLength = strlen($item);
			$Name = $item;
		}
	}
	return $MaxLength;
	
}

//*****INT CHECKS*****//
function checkNumber($i){
    // checks if input is numerical, allows decimal, floal, binary, hex
    
    
    if(is_numeric($i)){
        
        return true;
    }
    else
    {
        return false;
    }
}

function checkIfNegative ($i){
    //checks an int is not below 0
    
    if($i < 0 and checkNumber($i)){
        
        return true;
        
    }else
    {
        return false;
    }
}

function checkRange ($i, $min, $max){
    //checks an int is in between a range
    if($i < $min or $i > $max){
        
        return false;
        
    }else
    {
        return true;
    }
    
}
	function checkRangeReturnMessage ($i, $min, $max, $message){
    //checks an int is in between a range and if not creates and error flag with message parameter
		
	global $error;
		
    if($i < $min or $i > $max){
        
        $error->addFlag($message);
        
    }
}

function checkWholeNumber($i){
    
    if(!checkNumber($i)){
        if (!is_int($i)){
            
            return true;
        }
        else
        {
            return false;
        }
    }
}


//***** Password Validation *****//
//Password Validation message to be displayed
$passwordRequirements = '<ul>
								<li> Must be at least 8 characters long </li>
								<li> Must contain </li>
								<ul>
									<li> at least 1 Uppercase Letter </li>
									<li> at least 1 Lowercase Letter </li>
									<li> at least 1 Number </li>
									<li> at least 1 Special Character - @#\-_$%^&+=§!\? </li>
								</ul>
								<li> Does not contain your username or the word password or 1234</li>
							</ul>';


function validateNewPassword($password){
	
	global $error, $_POST;
	
	//array of dissallowed password
	$dissallowedWords = array("password", "Password", "PASSWORD", "1234", $_POST['username']);
	
	//check password against array of dissallowed words
	foreach($dissallowedWords as $word){
		if(checkEmpty($password) == false){
			
			if(strpos($password,$word)){
				//create an error flag if password contains any of the dissalowed words
				$message = $password." is not allowed";
				$error->addFlag($message);

			}
		}
	}
    
//Rules must contain 1 character 1 number and 1 lowercase letter 1 uppercase and be betweem 8 and 50 characters
        if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,50}$/', $password)) {

            return false;
        }
        else{
            return true;
        }
  
}
function encryptInput($s){
	// Uses standard PHP Hash and 
	//takes a string parameter
	//returns hashed item. 
	
	//$hash = $s;
	$hash = password_hash($s,PASSWORD_DEFAULT);

	return $hash;
}

function CheckNewPassword($password, $confirmPassword){
	
	
	if(!checkEmptyStringReturnMessage($confirmPassword, "Confirmation Password is Empty") &! 				checkEmptyStringReturnMessage($password, "Password is Empty")){
		
		if(checkMatchReturnMessage($password, $confirmPassword, "Password and Confirmation do not match")){
			
			if(checkStrLengthReturnMessage($password,8,100,"Password is too")){
				
				validateNewPassword($password);
				return true;
			}
		}
	}
	return false;
}

function updatePassword($password){
	
	global $error, $success, $conn;
	//updates password of current session 
	$sql = "UPDATE `users` SET `uPassword` = ?, `uLastPasswordChange` = ?  WHERE `uID` = ? LIMIT 1";
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		
		$message = "SERVER ERROR - SQL STATEMENT FAILURE - Update Password";
		$error->addFlag($message);
	}
	else{
		
		if(array_key_exists('id',$_SESSION)){
			$time = getFormatTime();
			$password = encryptInput($password);
			mysqli_stmt_bind_param($stmt,"ssi", $password, $time, $_SESSION['id']);
			mysqli_stmt_execute($stmt);
			
			if(mysqli_stmt_affected_rows($stmt)>0)
			{
				$flag="Password has been updated";
				$success->addFlag($flag);
			}
		
			else
			{
				$flag = "Error - Password not updated";
				$error->addFlag($flag);
			}
	
		}
		
		
	}
	
}

//*****TIME & DATE*****//

function getFormatTime()
{
	//returns a fromatted date and time stamp to ensure same stanadard is used in db

	global $error, $_GLOBALS;
	
	if(isset($_GLOBALS['DateTimeFormat']))
	{
		$dateObject = new DateTime();
		$date = $dateObject->format($_GLOBALS['DateTimeFormat']);
		return $date;
	}
	else
	{
		$dateObject = new DateTime();
		$date = $dateObject->format('d/m/Y');
		return $date;
	}
}

function formatSQLDate($day, $month, $year, $hour, $min)
{
	global $error, $_GLOBALS;
	
	if(isset($_GLOBALS['DateTimeFormat']))
	{
		$dateObject = new DateTime($year."/".$month."/".$day." ".$hour.":".$min.":00");
		$date = $dateObject->format($_GLOBALS['DateTimeFormat']);
		echo $date;
		return $date;
	}
	else
	{
		$flag = "Error - Date format not set";
		$error->addFlag($flag);
	}
	
}


function checkValidDate($d, $m, $y)
{
   //Checks days submitted is not more than in month
	global $months , $monthLength;
	global $error;
  
	  if($d > $monthLength[$m] )
	  {
		  
		  if ($d == 29 and $m == 2 and checkLeapYear($y)){
		  		// Special case for leap years to use 29th Feb
			  return true;
		  }
		  else
		  {
			  
			  $message = 'Date is not valid';
			  $error->addFlag($message);
			  return false;
		  	}
	  }	return true;
}

function checkLeapYear($year){
	
    //uses PHP function to check if year was a leap year and returns a bool
   if(date('L', strtotime("$year-01-01"))){
     
	   
	   return true;
   }
  else{
          
	  return false;
  }
}

function checkCountry($country){
	// Checks country is not the separator used in list 
		global $separator;
		global $error;
	
		if($country == $separator){
			
			$message = $country." is not a valid country";
			$error->addFlag($message);
		}
	
}

function checkUsernameExists($username){
	
	global $conn, $error;
	
	$sql = "SELECT `uID` FROM `users` WHERE `uUsername` = ? LIMIT 1";
	
	$stmt = mysqli_stmt_init($conn);
			
			//Prepare the staement and check if it will be accepted
			
			if(!mysqli_stmt_prepare($stmt, $sql)){
					$message = "SERVER ERROR - SQL STATEMENT FAILURE - CHECKING USERNAME";
					$error->addFlag($message);
			}else
			{
				//bind passed parameters to prepared statement (s=string i=int d=double)
				mysqli_stmt_bind_param($stmt,"s",$username);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				//check if anything returned
				if(mysqli_num_rows($result) > 0){
					//username is already taken
					return true;

				}else{

					return false;
				}
			}
}
function checkUsernameExistsRename($username, $id){
	
	global $conn, $error;
	
	$sql = "SELECT `uID` FROM `users` WHERE `uUsername` = ? AND `uID` != ?";
	
	$stmt = mysqli_stmt_init($conn);
			
			//Prepare the staement and check if it will be accepted
			
			if(!mysqli_stmt_prepare($stmt, $sql)){
					$message = "SERVER ERROR - SQL STATEMENT FAILURE - CHECKING USERNAME";
					$error->addFlag($message);
			}else
			{
				//bind passed parameters to prepared statement (s=string i=int d=double)
				mysqli_stmt_bind_param($stmt,"ss",$username, $id);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				//check if anything returned
				if(mysqli_num_rows($result) > 0){
					//username is already taken
					return true;

				}else{

					return false;
				}
			}
}
	
function checkUsernameTaken($username){
	//checks if username is taken and if so creates an error flag
	global $error;
	
	
	if(checkUserNameExists($username)){
		
		$message = "Username ".$username." is already taken";
		$error->addFlag($message);
		return true;
	}
}



//*****EMAIL CHECKS*****//

function checkNewEmail($email, $confirmEmail){

	global $error, $conn;
	
		//checks 2 email fields are not empty.
		if(!checkEmptyStringReturnMessage($email,'Email is Empty') &! checkEmptyStringReturnMessage($confirmEmail,'Confirmation Email is Empty')){
		
		//checks email addresses match
		if(checkMatchReturnMessage($email, $confirmEmail,'Email addresses do not match')){
			
			if(checkStrLengthReturnMessage($email,3,150,"Email is too")){
				
				//checks for valid email format
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$message = "Email Address is not Valid";
					$error->addFlag($message);

				} 
				else{
					//checks if email aleady taken and if so suggests to sign in 
					if(checkEmailExists($email)){
						$message = "Email Address already exists - Please <a class='alert-link' href='../../signIn.php'>Sign In </a>";
						$error->addFlag($message);
					}
					else
					{
						return true;
					}
				}
			}
		}
	}
}

function checkEmailExists($email){
	
	global $conn, $error;
	
	$sql = "SELECT `uID` FROM `users` WHERE `uEmail` = ? LIMIT 1";
	
	$stmt = mysqli_stmt_init($conn);
			
			//Prepare the staement and check if it will be accepted
			
			if(!mysqli_stmt_prepare($stmt, $sql)){
				$message = "SERVER ERROR - SQL STATEMENT FAILURE - CHECKING EMAIL";
				$error->addFlag($message);
			}else
			{
				//bind passed parameters to prepared statement (s=string i=int d=double)
				mysqli_stmt_bind_param($stmt,"s",$email);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
	
					if(mysqli_num_rows($result) > 0){
						//if an email address is found
						return true;

					}else{

						return false;
					}
			}
}

function checkEmail($email){
	
	global $error;
	
//checks single email fields are valid.

	if(!checkEmptyStringReturnMessage($email,'Email is Empty')){
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$message = "Email Address is not Valid";
			$error->addFlag($message);
			return false;
		}
		else{
			
			return true;
		}
	}
	else{
		
		return false;
	}
	
	
}

function updateLastSignIn(){
	//Updates with last sign in for database
	//no return 
	//uses $_SESSION to get current users id
	global $conn, $error;
	
	$time = getFormatTime();
	
	$sql = "UPDATE `users` SET `uLastLogOn` = ? WHERE `uID` = ? LIMIT 1";
	
	$stmt = mysqli_stmt_init($conn);
			
			//Prepare the staement and check if it will be accepted
			
			if(!mysqli_stmt_prepare($stmt, $sql)){
				$message = "SERVER ERROR - SQL STATEMENT FAILURE - SIGN IN TIME";
							   $error->addFlag($message);
			}else
			{
				//check seesion id is set
				if(array_key_exists('id',$_SESSION)){
					//bind passed parameters to prepared statement (s=string i=int d=double)
				mysqli_stmt_bind_param($stmt, "ss",$time, $_SESSION['id']);
				mysqli_stmt_execute($stmt);
				}else
					$message ="ERROR SESSION ID NOT SET - SIGN IN TIME" ;
							   $error->addFlag($message);
				
			}
	
	
}

function signIn($username,$password){
	
	global $conn, $error;
	
	
	if(!checkEmptyStringReturnMessage($username, "Username is Empty")){
		
		checkStrLengthReturnMessage($username,5,30,"Username is too");
	}
	
	
	if(!checkEmptyStringReturnMessage($password, "Password is Empty")){
		
		checkStrLengthReturnMessage($password,8,100,"Password is too");
	}
	
	
	if($error->flagsExist()){
		
		return false;
		
	}
	else{
			
		

		//template to get user id and password for checking give Username or Email
		$sql = "SELECT `uID`, `uPassword` FROM `users` WHERE `uUsername` = ? OR `uEmail` = ?";

		$stmt = mysqli_stmt_init($conn);

		//Prepare the staement and check if it will be accepted

		if(!mysqli_stmt_prepare($stmt, $sql)){
				$message = "SERVER ERROR - SQL STATEMENT FAILURE - SIGN IN";
				$error->addFlag($message);
		}else
		{
			//bind passed parameters to prepared statement (s=string i=int d=double)
			mysqli_stmt_bind_param($stmt, "ss",$username, $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			//pass $result into assocaitive array
			$row = mysqli_fetch_assoc($result);
			//check encrypted passwords match 
		
			if(password_verify($password, $row['uPassword']))
			{
				//add the user id to the session
				$_SESSION["id"] = $row['uID'];
				updateLastSignIn();
				return true;			
			}
			else
			{
				$message ="Username or Password is incorrect";
				$error->addFlag($message);
				return false;
			}
		}
	}
}
function getAccount($session)
   {

	   global $error, $conn;


   $sql = "SELECT `uUsername`, `uEmail`, `uFirstName`, `uSurname`, `uDOBDay`,`uDOBMonth`,`uDOBYear`, `uLastPasswordChange`, `uPassword` FROM `users` WHERE `uID` = ?";

	$stmt = mysqli_stmt_init($conn);

	  if(!mysqli_stmt_prepare($stmt, $sql)){

			$flag="ERROR SQL Statement Failed getting account";
			$error->addFlag($flag);
		}
		else
		{
			mysqli_stmt_bind_param($stmt, "s", $session);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_assoc($result);
			return $row;

		}




   }
