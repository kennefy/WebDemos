<?php




class child {
	
	private $childID;
	private $childName;
	private $childAge;
	private $parentID = array();
	private $DOBDay;
	private $DOBMonth;
	private $DOBYear;
	private $childDOBString;
	private $currentWeight;
	private $currentHeight;
	private $startWeight;
	private $startHeight;
	
function __construct($rowArray)
{
	$this->childID = $rowArray['cID'];
	$this->childName = $rowArray['cName'];
	$this->DOBDay = $rowArray['cDOBDay'];
	$this->DOBMonth = $rowArray['cDOBMonth'];
	$this->DOBYear = $rowArray['cDOBYear'];
	$this->setDOBString();
	$this->calculateAge();
	$this->currentHeight = $rowArray['cHeight'];
	$this->currentWeight = $rowArray['cWeight'];
	$this->startHeight = $rowArray['cStartHeight'];
	$this->startWeight = $rowArray['cStartWeight'];
	$parentID[0] = $rowArray['parentID1'];
	$parentID[1] = $rowArray['parentID2'];
	
}

public function getID()
{
	$id = $this->childID;
	return $id;
}

public function getName()
{
	$name = $this->childName;
	return $name;
}

public function setName($s)
{
	$this->childName = $i;
	
}

public function getWeightChange()
{
	$weightChange = $this.currentWeight - $this.startWeight;
	return $weightChange;
}

public function getHeightChange()
{
	$heightChange = $this.currentHeight - $this.startHeight;
	return $heightChange;
}
private function setDOBString()
{
	$DOB = $this->DOBDay."/".$this->DOBMonth."/".$this->DOBYear;
	$this->childDOBString = $DOB;
}
private function calculateAge()
{
	$today = new DateTime('now');
	$DOB = new DateTime($this->DOBYear."-".$this->DOBMonth."-".$this->DOBDay);
	$interval = $DOB->diff($today);
	$this->childAge = $interval->format('%y Year %m Months %d Days');
	
}

public function getAge()
{
	
	return $this->childAge;
}
	
	
	
};
	