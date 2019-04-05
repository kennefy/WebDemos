<?php
require('feedRecord.class.php');

class feedGroup
{
	
	private $feedsArray = array();
	
	

	public function populateFeed($conditionArray, $conn)
	{
		/*********
		* creates the SQl statments for to pull feeds from the DB as feedRecord objects in an array
		* 
		* !IMPORTANT - Each if statement must have count() to check if statements are not called early
		*
		* parameters - 1. an arry of conditions  2. SQL $connection 
		*
		* $conditions[] - feedID, childID, userID, feedTypes, dateStart, dateEnd, durationStart, 
		* durationEnd, hourStart, hourEnd, feedHour, feedMin
		*
		* returns - false if no results 
		*
		*********/
	
		$stmt = mysqli_stmt_init($conn);
		
		//CASE: Date Range with by child ID
		if(isset($conditionArray['dateStart']) & 
		   isset($conditionArray['dateEnd']) &
		   isset($conditionArray['childID']) &
		   count($conditionArray) === 3
		  )
		{
			   
			$sql = "SELECT * FROM feedRecords WHERE (
					`cID` = ?) 
					AND
					(`fDateComp` 
					BETWEEN  ?  AND  ? 
					)";
			
			if(!mysqli_stmt_prepare($stmt, $sql))
				{	
					echo 'Statement Error';
					return false;
				}
				else
				{
					mysqli_stmt_bind_param($stmt,"iss",$conditionArray['childID'],$conditionArray['dateStart'],$conditionArray['dateEnd'] );
				}				
		}	
		/***********************************/
		//DEFAULT: Last feed added by user
		else
		{
			$sql = "SELECT * FROM feedRecords WHERE (
					`uID` = ?)";

			if(!mysqli_stmt_prepare($stmt, $sql))
				{	
					return false;
				}
				else
				{
					mysqli_stmt_bind_param($stmt,"i",$_SESSION['id']);	
				}		
		}
		/***********************************/
		mysqli_stmt_execute($stmt);
		if(!mysqli_stmt_error($stmt))
		{				
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) == 0)
			{
				return false;
			}
			else
			{
				while($row = mysqli_fetch_assoc($result))
				{			
					$feed = new feedRecord($row);
					array_push($this->feedsArray, $feed);
				}
			}
		}
	}
	
	public function getNoFeedsReturned()
	{
		if(!empty($this->feedsArray))
		{
			$i = count($this->feedsArray);
			return $i;
		}
	}
	
	public function getFeed($i)
	{
		if($i < $this->getNoFeedsReturned())
		{
			return $this->feedsArray[$i];
		}
		
	}
	
	public function getFeedsArray()
	{
		if(isset($this->feedsArray))
		{
			return $this->feedsArray;
		}	
	}
	
	public function containsFeedType($arrayTypes)
	{
		$returnArray = array();
		
		foreach ($this->feedsArray as $record)
		{
			foreach ($arrayTypes as $feed)
			{
				if(in_array($record->feedTypeArray, $feed))
				   {
					   //decide what way this has to be returned
				   }
			}
			
		}
		if(count($this->feedsArray)>0)
		{
			return $returnArray;
		}
		else
		{
			return false;
		}
		
	}
	
	public function sortFeeds($sortBy, $direction)
	{
		if(count($this->feedsArray)<1)
		{
			return false;
		}
		else
		{
			if($direction === "h2l")
			{
				$this->feedsArray = arsort($this->feedsArray->$feedDuration);
			}
		}
		
	}
	
	public function displayResults()
{
	$count = $this->getNoFeedsReturned();

	for($i = 0; $i<$count; $i++)
	{
		$feed = $this->getFeed($i);
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
				<td colspan="3">'.$feed->getFeedNotes().'</td>	
			</tr>
			</table>
			';
	}
}
}