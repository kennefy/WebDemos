<?php
/*********************
*Feeds Class
*08/01/2019
* Kenny Montgomery
*
*Decription
*
*An Object for holding a feed record, it has methods for accessing each value also to get formatted versions of data such as DOB
*
*todo
*
add SQL for feed types to fetch names for array;
*
*********************/

class feedRecord
{
	
	public $feedID;
	public $feedChildID;
	public $feedParentID;
	public $feedTypeString;
	public $feedTypeArrayID;
	public $feedTypeArrayNames;
	public $feedNotes;
	public $feedHour;
	public $feedMins;
	public $feedDuration;
	public $feedDay;
	public $feedMonth;
	public $feedYear;
	public $feedDate;
	public $feedAdded;
	
	
	public function __construct($row)
	{
		$this->feedID = $row['fID'];
		$this->feedChildID = $row['cID'];
		$this->feedParentID = $row['uID'];
		$this->feedTypeString = $row['fTypeString'];
		$this->feedNotes = $row['fNotes'];
		$this->feedHour = $row['fHour'];
		$this->feedMins = $row['fMin'];
		$this->feedDuration = $row['fDuration'];
		$this->feedDay = $row['fDay'];
		$this->feedMonth = $row['fMonth'];
		$this->feedYear = $row['fYear'];
		$this->feedDate = $row['fDateComp'];
		$this->feedAdded = $row['fAddedTime'];
		if($this->getFeedString()!= false)
		{
			$this->makeFeedTypeArray();
		}
	}
	
	public function getFeedID()
	{
		if(!empty($this->feedID))
		{
			return $this->feedID;
		}
		else
		{
			return false;
		}
	}
	
	public function getChildID()
	{
		if(!empty($this->feedChildID))
		{
			return $this->feedChildID;
		}
		else
		{
			return false;
		}
	}
	
	public function getParentID()
	{
		if(!empty($this->feedParentID))
		{
			return $this->feedParentID;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedString()
	{
		if(!empty($this->feedTypeString))
		{
			return $this->feedTypeString;
		}
		else
		{
			return false;
		}
	}
	public function getFeedTypeArray()
	{
		if(!empty($this->feedTypeArray))
		{
			return $this->feedTypeArray;
		}
		else
		{
			return false;
		}
	}
	
	private function makeFeedTypeArray()
	/*
	*explodes the feedType to create an array of feed types used in that feed
	*
	*returns false if the string is empty
	*/
	{
		$feedArray = array();
		$delimiterString = "::";
		
		if(!$this->getFeedString())
		{
			return false;
		}
		else
		{
			$feedString = $this->getFeedString();
			$this->feedTypeArrayID = explode($delimiterString, $feedString);
			
			
		}
	}
	
	public function getFeedNotes()
	{
		if(!empty($this->feedNotes))
		{
			return $this->feedNotes;
		}
		else
		{
			return "";
		}
	}
	
	public function getFeedHour()
	{
		if(!empty($this->feedHour))
		{
			return $this->feedHour;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedMins()
	{
		if(!empty($this->feedMins))
		{
			return $this->feedMins;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedDuration()
	{
		if(!empty($this->feedDuration))
		{
			return $this->feedDuration;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedDay()
	{
		if(!empty($this->feedDay))
		{
			return $this->feedDay;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedMonth()
	{
		if(!empty($this->feedMonth))
		{
			return $this->feedMonth;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedYear()
	{
		if(!empty($this->feedYear))
		{
			return $this->feedYear;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedAddedString()
	{
		if(!empty($this->feedAdded))
		{
			return $this->feedAdded;
		}
		else
		{
			return false;
		}
	}
	
	public function getFeedDate()
		/*******
		*Checks to see if there is a global format to set date to and return if not returns D/M/Y standard
		*
		*returns date object
		********/
	{
		if(array_key_exists('DateFormat',$_GLOBALS))
		{
			$dateObject = new DateTime($this->feedMonth."-".$this->feedDay."-".$this->feedYear);
			$date = $dateObject->format($_GLOBALS['DateFormat']);
			echo $date;
		}
		else
		{
			$dateObject = new DateTime($this->feedMonth."-".$this->feedDay."-".$this->feedYear);
			$date = $dateObject->format('Y-m-d');
			echo $date;
		}
		return $date;
	}
}