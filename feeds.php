<?php

include_once'INCLUDES/PHP/dbConn.php';
include_once 'INCLUDES/PHP/validator2.php';
include_once 'INCLUDES/PHP/CLASS/messageFlags.class.php';
include_once 'INCLUDES/PHP/Var_Dumps.php';
include_once 'INCLUDES/PHP/children.inc.php';
include_once 'INCLUDES/PHP/CLASS/child.class.php';

session_start();

$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem', 'Please fix the errors below');
$success = new messageBox();
$success->setBoxType("success", "Success", "");

$childrenArray = getChildren();

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



if(array_key_exists('addFeed', $_POST))
{
	
	checkEmptyStringReturnMessage($_POST['childID'],'Child Name is empty');
	checkValidDate($_POST['Day'],$_POST['Month'],$_POST['Year']);
	checkEmptyStringReturnMessage($_POST['feedHour'],'Feed hours is empty');
	checkEmptyStringReturnMessage($_POST['feedMins'],'Feed mins is empty');
	checkEmptyStringReturnMessage($_POST['duration'],'Duration is empty');
	stringFeeds($_POST['feedCheckbox']);
	if(!$error->flagsExist())
	{
		addFeed();
	}
		
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
				echo '<select name="childID" class="form-control">';
				$noChildren = count($childrenArray);
				foreach ($childrenArray as $child)
				{
					echo "<option value='".$child->getID()."'>".$child->getName()." - ".$child->getAge()."</option>";
				}
				echo '</select>';
			}
				
			?>

	<hr>
	<h3>Feed Type</h3>
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

		<textarea name="feedNotes" class="form-control" placeholder="Notes about this feed..."></textarea>

		
	<hr>
	
	<h3>Feed Time</h3>
	<div class="form-row col-12">
                        <div class="col-2">
	
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
		<div class="col-2">
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
		<div class="col-2">
			<formset>
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
	<div class="form-row col-12">
                        <div class="col-2">
                            <label for="Day">Day </label>
                            <select class="form-control" name="Day">
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
                        <div class="col-2">
                            <label for="Month">Month </label>
                            <select class="form-control" name="Month">
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

                        <div class="col-2">
                            <label for="Year">Year </label>
                            <select class="form-control" name="Year">
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
	<input class="btn btn-outline-secondary btn-block  m-2" type="submit" name="addFeed" value="Add Feed">
</form>
</div>
</div>
</div>
<div>

	<?php include'INCLUDES/PHP/footer.php'; ?>
</div>
</body>
</html>