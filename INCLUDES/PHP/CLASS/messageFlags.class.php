<?php

/**
* class to allow the quick creation of messages to be displayed
* message types have been preset as 
* error - red 
* success - green
* warning - yellow
* info - blue
* Author Kenny Montgomery
* Revised - 10/12/2018
*/


class messageBox {
	
	
	public 	$exists = true;
	private $messageHeader = "Message";
	private $messageSubHeadline = "Messages";
	private $mesageBoxStart;
	private $messageBoxEnd;


	private $count;
	private $messageBoxStyle;
	private $messageArray = array();
	
	
	
	public function setBoxType($boxStyle, $headline, $subline){
	/***
	* Function sets up the html for the message box to be displayed
	*Parameters -  Takes a string which should be set to match the preset types 
	*
	* No Return Values
	* Last Update - Kenny 10/12/2018
	**/
		$this->messageBoxStyle = $boxStyle;
		$this->messageHeader = $headline;
		$this->messageSubHeadline = $subline;
		
		switch ($this->messageBoxStyle){
			case ("error"):
				//Error Message style box
				$this->messageHeader = $headline;
				$this->messageSubHeadline = $subline;
				$this->messageBoxStart = '<div class="alert alert-danger m-2" role="alert">
								<h4 class="alert-heading">'.$this->messageHeader.'</h4> 
								<hr>
								<p> '.$this->messageSubHeadline.' </p>
								<p class="mb-0">';

				$this->messagBoxEnd = '</p>
								</div>';
			break;
				
			case ("success"):
			//Success Message style box
			$this->messageBoxStart = '<div class="alert alert-success m-2" role="alert">
							<h4 class="alert-heading">'.$this->messageHeader.'</h4> 
							<hr>
							<p> '.$this->messageSubHeadline.' </p>
							<p class="mb-0">';

			$this->messagBoxEnd = '</p>
							</div>';
			break;
				
			default:
			//default grey Message style box
			$this->messageBoxStart = '<div class="alert alert-secondary m-2" role="alert">
							<h4 class="alert-heading">'.$this->messageHeader.'</h4> 
							<hr>
							<p> '.$this->messageSubHeadline.' </p>
							<p class="mb-0">';

			$this->messagBoxEnd = '</p>
							</div>';
			break;
		}
				
				
		
	}
		
	public function addFlag($flag){
	/***
	*Function adds the flag into the message array
	*Parameters - Takes a string for message to be added
	*
	*No Return Values
	* Last Update - Kenny 10/12/2018
	**/

		array_push($this->messageArray, $flag);
	}
	
	public function getFlagCount(){
	/***
	*Function gives the user a count of messages in the array
	*Parameters - None
	*
	*Returns an int of the number of messages in the array
	* Last Update - Kenny 10/12/2018
	**/
		$count = sizeof($this->messageArray);
		return $count;
	}
	
	
	public function flagsExist(){
	/***
	*Function checks to see if the array holds values
	*Can be used as logic check to check for errors
	*Parameters - None
	*
	*Returns a bool of true if no flags exist in array
	* Last Update - Kenny 10/12/2018
	**/
		
		if(!empty($this->messageArray)){
			
			return true;
		}
		else{
			
			return false;
		}
	}
			
	public function getBoxType(){
	/***
	*Function checks return what type of error box
	*
	*Parameters - None
	*
	*Returns a string of box type
	* Last Update - Kenny 10/12/2018
	**/
		
		return $this->messageBoxStyle;
	}
	

	public function getMessageBox(){
	/***
	*Function returns the formatted message box with all attahced messages in array
	*if no messages in the array will return no messages displayed in place of message
	*Parameters - None
	*
	*Returns message box string including preformatted html
	* Last Update - Kenny 10/12/2018
	**/
		$messageBox = $this->messageBoxStart;
		
		if(!$this->flagsExist()){
			
			$messageBox .= "<br> No messages to display!";
		}
		else
		{
			foreach ($this->messageArray as $value){

					$messageBox .="<br>".$value;
				}
		}
		$messageBox .=$this->messageBoxEnd;
		
		return $messageBox;
	}
	
	public function quickListFlags(){
	/***
	*Function returns the formatted message box with all attached messages in array used for debugging
	*if no messages in the array will return no messages displayed in place of message
	*Parameters - None
	*
	*Returns message box string with count and box type
	* Last Update - Kenny 10/12/2018
	**/
		$i = $this->getFlagCount();
	
		
		$outputString = $this->getBoxType()."Box <br>".$i." Flags exist";
		
		foreach ($this->messageArray as $flag){
			
		
			$outputString .= "<br>".$flag;
		}
		
		return $outputString;

	}
}
