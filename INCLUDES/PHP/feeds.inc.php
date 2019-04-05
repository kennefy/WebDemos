<?php


/******************
* Feed Types Functions
*
*
/*****************/

$feedDescriptions = array();
$feedDescriptionsID = array();

$sql = 'SELECT * FROM `feedTypes` WHERE `fVisibilty` = 1';
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0)
{
	$flag = "Error No feed types were found";
	$error->addFlag($flag);
}
else
{
	while ($row = mysqli_fetch_assoc($result))
	{
		array_push($feedDescriptions, $row["feedDescription"]);
		array_push($feedDescriptionsID, $row["feedID"]);	
	}		
}

function stringFeeds($array)
{
	global $error;
	$stringFeed = "";
	
		if(empty($array))
		{
		   	$flag="No feeds types selected";
			$error->addFlag($flag);
			return false;
		}
		else
		{
			foreach($array as $feed)
			{
				$stringFeed .= $feed."::";
			}
			return $stringFeed;
		}
	
}

function addFeed()
{
	global $conn, $error, $success;
	
	$sql = 'INSERT INTO `feedRecords`(`cID`, `uID`, `fTypeString`, `fNotes`, `fHour`, `fMin`, `fDuration`, `fDay`, `fMonth`, `fYear`, `fDateComp`,`fAddedTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
	
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql))
	{
		$flag = "ERROR SQL Statement Failed Add Feed";
		$flag .= mysqli_stmt_error($stmt);
		$error->addFlag($flag);
	}
	else
	{
		$feedString = stringFeeds($_POST['feedCheckbox']);
		$dateString = formatSQLDate($_POST['Day'],$_POST['Month'],$_POST['Year'],$_POST['feedHour'],$_POST['feedMins']);
		$timeStamp = getFormatTime();
		
		mysqli_stmt_bind_param($stmt, "iissiiiiiiss", $_POST['childID'],$_SESSION['id'],$feedString,$_POST['feedNotes'],$_POST['feedHour'],$_POST['feedMins'],$_POST['duration'],$_POST['Day'],$_POST['Month'],$_POST['Year'],$dateString,$timeStamp);
		
		mysqli_stmt_execute($stmt);

		
		if(mysqli_stmt_errno($stmt)== 0)
		{
			$flag = " Feed has been added";
			$success->addFlag($flag);
		}
		else{

			$flag = mysqli_stmt_error($stmt);
			$error->addFlag($flag);
		}

	}
	
}


/*
function displayResults($feeds)
{
	$count = $feeds->getNoFeedsReturned();

	for($i = 0; $i<$count; $i++)
	{
		$feed = $feeds->getFeed($i);
		echo '
				<table class="feedTable">
			<tr>
				<td colspan="3"> '.$feed->getChildID().' </td>	
			</tr>
			<tr>
				<td class="feedTableHeader"> Time: </td>
				<td class="feedTableHeader"> Day: </td>
				<td class="feedTableHeader"> Date: </td>
			</tr>
			<tr>
				<td> '.$feed->getFeedHour().':'.$feed->getFeedMins().' </td>
				<td> '.$feed->getFeedDuration().' mins </td>
				<td> '.$feed->getFeedDate().'</td>
			</tr>
				<tr>
				<td class="feedTableHeader"> Duration: </td>
				<td colspan="2" class="feedTableHeader"> Feeds Taken: </td>	
			</tr>
			<tr>
				<td> '.$feed->getFeedDuration().' mins </td>
				<td colspan="2"> Left - Right </td>	
			</tr>
				<tr>
				<td class="feedTableHeader" colspan="3">Notes attached:</td>	
			</tr>
			<tr>
				<td colspan="3">Feed notes go here with everything displayed</td>	
			</tr>
			</table>
			';
	}
}*/