<?php

include_once'INCLUDES/PHP/dbConn.php';
include_once 'INCLUDES/PHP/validator2.php';
include_once 'INCLUDES/PHP/CLASS/messageFlags.class.php';
include_once 'INCLUDES/PHP/Var_Dumps.php';
include_once 'INCLUDES/PHP/children.inc.php';
include_once 'INCLUDES/PHP/feeds.inc.php';
include_once 'INCLUDES/PHP/CLASS/child.class.php';
include_once 'INCLUDES/PHP/CLASS/feedGroup.class.php';

session_start();

$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem', 'Please fix the errors below');
$success = new messageBox();
$success->setBoxType("success", "Success", "");

$childrenArray = getChildren();

$dateStart = new DateTime();
//$dateStart->add(new DateInterval('P1D'));
$dateEnd = new DateTime();
$dateEnd->sub(new DateInterval('P7D'));
$dateStart = $dateStart->format($_GLOBALS['DateTimeFormat']);
$dateEnd = $dateEnd->format($_GLOBALS['DateTimeFormat']);


$feeds = new feedGroup();
//$conditions = array('childID'=>$childrenArray[0]->getID(), 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd);
$feeds->populateFeed($conditions,$conn);

if(array_key_exists('search', $_POST))
{

	var_dump($_POST);
		
}

if($error->flagsExist())
{
	$messageBox = $error->getMessageBox();	
}
elseif($success->flagsExist())
{
	$messageBox = $success->getMessageBox();
}

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Feeds - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">
	<link rel="stylesheet" href="INCLUDES/CSS/feeds.css">

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
	<div id="header">
        <?php include'INCLUDES/PHP/feedNavs.php'; ?>
    </div>
	<div class="container">
	
		
<div>
<div id="messageArea">
                        <?php echo $messageBox; ?>
    </div>
	<div class="col-4">
<form method='post'>
	

		<h3>Child</h3>
		
			<?php 
			if(empty($childrenArray))
			{
				$flag = "No Children Found";
				$error->addFlag($flag);
			}
			else
			{
				echo '<select name="childID" class="form-control form-row col-12">';
				$noChildren = count($childrenArray);
				foreach ($childrenArray as $child)
				{
					echo "<option value='".$child->getID()."'>".$child->getName()."</option>";
				}
				echo '</select>';
			}
				
			?>

	<hr>
	<h3>Feed Types</h3>
	<div class="form-row col-12">
		<div class="col-12">
			<p> Tick all that apply</p>
		
					<?php
					for ($i = 0; $i < count($feedDescriptions); $i++)
					{
						echo "
							<div class='form-check form-check-inline'>
								<input type='checkbox' class='form-check-input' name='feedCheckbox[]' value='".$feedDescriptionsID[$i]."'>
								<label class='form-check-label' for='feedCheckbox'>".$feedDescriptions[$i]."</label>
							</div>

							";
						
					}
					?>
		
			</div>
		</div>
		
	<hr>
	
	<h3>Feed Time</h3>
	<div class="form-row col-12">
                        <div class="col-3">
	
		<label for="feedHour">Start Hour</label>
		<select name="feedHour" class="form-control">
			<?php 
			
				$hour = date('G');
				for($i=0; $i<24; $i++)
				{
					if($i == $hour)
					{
						echo "<option selected='selected' value='".$i."'>".$i."</option>";
					}
					else
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
				
				}
			?>	
		</select>	
		</div>
		<div class="col-3">
		<label for="feedMins">Start Minuite</label>
		<select name="feedMins" class="form-control">
			<?php 
						$interval = 5;
						$max = 60-$interval;
						$currentMin = date('i');
						$currentMin = floor($currentMin/$interval)*$interval;
						
						for($i=0; $i<=$max; $i+=$interval)
						{
							if($i == $currentMin)
							{
								echo "<option selected='selected' value='".$i."'>".$i."</option>";
							}		
							else
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
						
						}
					?>	
		</select>

	</div>
	<div class="form-row col-12">
		<div class="col-6">
				<label for="duration">Duration</label>
				<select name="duration" class="form-control">
					<?php 
						$interval = 5;
						$max = 180;

						for($i=5; $i<$max; $i+=$interval)
						{
						echo "<option value='".$i."'>".$i." mins</option>";
						}
					?>	
				</select>
		</div>
	</div>
</div>
	<hr>
	
	<h3>Feed Date</h3>
	<h6>Start Date</h6>
	<div class="form-row col-12">
		
                        <div class="col-3">
                            <label for="Day">Day </label>
                            <select class="form-control" name="startDay">
                                <?php
									$day = date('j');
									for($d =1; $d<=31; $d++)
								   {
								 
										if($d == $day)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$d.'">'.$d.'</option>';
										}
										else
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}                             
                             		}	
                            ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="Month">Month </label>
                            <select class="form-control" name="startMonth">
                                <?php
								
								$month = date('m');
								
						                     
								 for($m =1; $m<=12; $m++)
								 {
									 if($m == $month)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$m.'">'.$months[$m-1].'</option>';
										}
										else
										{

											echo '<option value="'.$m.'">'.$months[$m-1].'</option>';
										}

								 }
                            ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="Year">Year </label>
                            <select class="form-control" name="startYear">
                                <?php
								
								$year = date('Y');
        
                            $currentYear = date('Y');
                            $maxYears =1;
                            $minYears = 0;
								
								if(isset($year))
								   {	//checks if value has been set in previous post
									   $selectedYear = intval($year);
									echo 'true';
								   }
									

                             for($y =($currentYear-$minYears); $y>=($currentYear-$maxYears); $y--)
							 {
								 if($y === $selectedYear)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$y.'">'.$y.'</option>';
										}
										else
										{

                                 			echo '<option value="'.$y.'">'.$y.'</option>';
										}

                             }
                            ?>
                            </select>

                        </div>


                    </div>
	<h6>End Date</h6>
	<div class="form-row col-12">
		
                        <div class="col-3">
                            <label for="Day">Day </label>
                            <select class="form-control" name="endDay">
                                <?php
									$day = date('j');
									for($d =1; $d<=31; $d++)
								   {
								 
										if($d == $day)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$d.'">'.$d.'</option>';
										}
										else
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}                             
                             		}	
                            ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="Month">Month </label>
                            <select class="form-control" name="endMonth">
                                <?php
								
								$month = date('m');
								
						                     
								 for($m =1; $m<=12; $m++)
								 {
									 if($m == $month)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$m.'">'.$months[$m-1].'</option>';
										}
										else
										{

											echo '<option value="'.$m.'">'.$months[$m-1].'</option>';
										}

								 }
                            ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="Year">Year </label>
                            <select class="form-control" name="endYear">
                                <?php
								
								$year = date('Y');
        
                            $currentYear = date('Y');
                            $maxYears =1;
                            $minYears = 0;
								
								if(isset($year))
								   {	//checks if value has been set in previous post
									   $selectedYear = intval($year);
									echo 'true';
								   }
									

                             for($y =($currentYear-$minYears); $y>=($currentYear-$maxYears); $y--)
							 {
								 if($y === $selectedYear)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$y.'">'.$y.'</option>';
										}
										else
										{

                                 			echo '<option value="'.$y.'">'.$y.'</option>';
										}

                             }
                            ?>
                            </select>

                        </div>


                    </div>
	<input class="btn btn-outline-secondary btn-block  m-2" type="submit" name="search" value="Search">
</form>
</div>
</div>
		<div id="results">
			This is the result area
			<?php 
			
		
				$feeds->displayResults();
			
		
			
			?>
			
			</div>
</div>
</div>
<div>

	<?php include'INCLUDES/PHP/footer.php'; ?>
</div>
</body>
</html>