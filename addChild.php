<?php
include_once('INCLUDES/PHP/dbConn.php');
include_once('INCLUDES/PHP/validator2.php');
include_once('INCLUDES/PHP/CLASS/messageFlags.class.php');

$error = new messageBox();
$error->setBoxType("error", "Sorry there is an Error", "");
$success = new messageBox();
$success->setBoxType("success", "Success", "");
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
function addChild(){
	
	if(array_key_exists('add', $_POST))
	{
		if(checkEmpty($_POST['firstName']) and checkValidDate($_POST['DOB-Day'],$_POST['DOB-Month'],$_POST['DOB-Year']))
		{

			$sql = "INSERT INTO `children` (`parentID1`,`cName`, `cDOBDay`, `cDOBMonth`, `cDOBYear`) VALUES (?,?,?,?,?)";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql))
			{

				$flag="ERROR SQL Statement Failed";
				$error->addFlag($flag);
			}
			else
			{
				mysqli_stmt_bind_param($stmt, "ssiii", $_SESSION['id'], $_POST['firstName'],$_POST['DOB-DAY'],$_POST['DOB-Month'],$_POST['DOB-Year']);
				mysqli_stmt_execute($stmt);
			}
		}
	}
}

?>

<hr class="my-4">
<form method='post'>

                    <div class="form-group col-8">
                        <label for="firstname">Childs Nickname</label>
                        <input class="form-control" type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
                       
                    </div>


                    <div class="form-row col-12">
                        <div class="col-2">
							<formset>
                            <label for="DOB-Day">Day </label>
                            <select class="form-control" name="DOB-Day">
                                <?php
								if(isset($day))
								   {	//checks if value has been set in previous post
									   $selectedDay = $day;
								   }
									
									for($d =1; $d<=31; $d++)
								   {
								 
										if($d === $selectedDay)
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
                            <label for="DOB-Month">Month </label>
                            <select class="form-control" name="DOB-Month">
                                <?php
								if(isset($month))
								   {	//checks if value has been set in previous post
									   $selectedMonth = $month;
								   }                         
								 for($m =1; $m<=12; $m++)
								 {
									 if($m === $selectedMonth)
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
                            <label for="DOB-year">Year </label>
                            <select class="form-control" name="DOB-Year">
                                <?php
        
                            $currentYear = date('Y');
                            $maxYears =60;
                            $minYears = 15;
								
								if(isset($year))
								   {	//checks if value has been set in previous post
									   $selectedYear = intval($year);
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
					</formset>
                        </div>
						<div class="row col-12">
							<div class="col-4">
								<input type="submit" class="btn btn-info mt-2" name="add" value="Add Child">
							</div>
						</div>

</form>