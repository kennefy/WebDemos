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
*
*********************/

class feedRecord
{
	
	private $feedID;
	private $feedChildID;
	private $feedParentID;
	private $feedTypeString;
	private $feedTypeArray;
	private $feedNotes;
	private $feedHour;
	private $feedMins;
	private $feedDuration;
	private $feedDay;
	private $feedMonth;
	private $feedYear;
	private $feedAdded;
	
	
	public function __construct($row)
	{
		$feedID = $row['fID'];
		$feedChildID = $row['cID'];
		$feedParentID = $row['uID'];
		$feedTypeString = $row['fTypeString'];
		$feedNotes = $row['fNotes'];
		$feedHour = $row['fHour'];
		$feedMins = $row['fMins'];
		$feedDuration = $row['fDuration'];
		$feedDay = $row['fDay'];
		$feedMonth = $row['fMonth'];
		$feedYear = $row['fYear'];
		$feedAdded = $row['fAddedTime'];
		if(getFeedString()!= false)
		{
			makeFeedTypeArray();
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
			$this->feedTypeArray = explode($delimiterString, $feedString);
			
			
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
		if(array_key_exists($GLOBALS['DateFormat']))
		{
			$date = new DateTime($this->feedDay."/".$this->feedMonth."/".$this->feedYear);
			$dateObject = $date->format($GLOBALS['DateFormat']);
		}
		else
		{
			$dateObject = new DateTime($this->feedDay."/".$this->feedMonth."/".$this->feedYear);
		}
		return $dateObject;
	}
}