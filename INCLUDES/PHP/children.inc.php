<?php
include_once ('INCLUDES/PHP/CLASS/child.class.php');

session_start();


$childrenArray = array();	



function getChildren(){
	
	global $conn, $error, $childrenArray;
	
		
		$sql = "SELECT * FROM `children` WHERE `parentID1`= ? OR `parentID2`= ?";
		$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql))
				{	
					$flag="ERROR SQL Statement Failed Fetch Child";
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt,"ii",$_SESSION['id'],$_SESSION['id']);
					mysqli_stmt_execute($stmt);
					
					if(mysqli_stmt_errno($stmt)==0)
					{				
						$result = mysqli_stmt_get_result($stmt);
						if(mysqli_num_rows($result)>0)
						{
							while($row = mysqli_fetch_assoc($result))
							{
								$child = new child($row);
								array_push($childrenArray, $child);
							
							}	
							return $childrenArray;
						}
						else
						{
							$flag = "No Children Found";
							$error->addFlag($flag);
						}
					}
					else
					{
						$flag = mysqli_stmt_error($stmt);
						$error->addFlag($flag);
					}
			   }
	mysqli_stmt_close($stmt);
}

function getNoChildren(){
	
	global $childrenArray;

	
	$i = count($childrenArray);
	
	if($i === 1)
	{
		$s = $i." Child";	
	}
	else
	{
		$s = $i." Children";
	}

	return $s;
}

function addChild(){
	
	global $conn, $error, $success;
	
	if(!checkEmpty($_POST['childName']) and checkValidDate($_POST['CDOB-Day'],$_POST['CDOB-Month'],$_POST['CDOB-Year']))
	{

	$sql = "INSERT INTO `children` (`parentID1`,`cName`, `cDOBDay`, `cDOBMonth`, `cDOBYear`) VALUES (?,?,?,?,?)";
	
	$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql))
				{
					
					$flag="ERROR SQL Statement Failed Add Child";
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "isiii", $_SESSION['id'], $_POST['childName'],$_POST['CDOB-Day'],$_POST['CDOB-Month'],$_POST['CDOB-Year']);
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_errno($stmt)==0)
					{
						$flag = $_POST['childName']." has been added";
						$success->addFlag($flag);
					}
					else{
						
						$flag = mysqli_stmt_error($stmt);
						$error->addFlag($flag);
					}
					
				}
	}
	else
	{
					$flag="Child Not added ".$_POST['childName'];
					$error->addFlag($flag);
	}
}


	  /**
* Check to see if data has been posted
* checks to make sure name has been entered
* checks that DOB is a valid Date
* takes in height and weight data as KG and CM (need to add a toggle?)
* starting height and weight will be taken from this
* Parent ID is taken from current session - will expand to add another parent? email alink to add a child?

* creates error flags if Name is empty or DOB is not valid

* creates a success flag if all added ok 
*/