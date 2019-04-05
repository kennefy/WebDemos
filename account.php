<?php

session_start();

include_once('INCLUDES/PHP/account.inc.php');

if(!array_key_exists('id', $_SESSION))
{
	header('Location: index.php?invalid');
	
}

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Account - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
	<div id="errorArea">
                        <?php echo $messageBox; ?>
                    </div>
    <div class="row">
        <div class="col-8">
            <h1 class="text-muted">

              My Account Details</h1>

        
			<div id="childrensArea">
								<hr class="my-4">
				<h4 class="text-muted">Children</h4>
				<small> You have <?php $noChildren = getNoChildren(); echo $noChildren; ?>.</small>
				<ul>
				<?php if($noChildren > 0)
					 { 
								
							foreach($childrenArray as $child)
							{
								echo "<li>".$child->getName()." - age - ".$child->getAge()."</li>"; 
							}
					}
					?>
					</ul>
<form method='post'>

                    <div class="form-group col-8">
                        <label for="firstname">First Name</label>
                        <input class="form-control" type="text" id="childName" name="childName">
                       
                    </div>


                    <div class="form-row col-12">
                        <div class="col-2">
							<formset>
                            <label for="DOB-Day">Day </label>
                            <select class="form-control" name="CDOB-Day">
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
                            <select class="form-control" name="CDOB-Month">
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
                            <select class="form-control" name="CDOB-Year">
                                <?php
        
                            $currentYear = date('Y');
                            $maxYears =4;
                            $minYears = 0;
								
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
						<div class="row">
							<div class="col-2">
								<input type="submit" class="btn btn-outline-secondary mt-2" name="add" value="Add Child">
							</div>
  						</div>
</form>
		  
			</div>
				<hr class="my-4">
			<div class="p-2">
			<h4 class="text-muted">Security</h4>
				<a class="pageLink" href="passwordUpdate.php"> Change my Password</a>
				<br>
				<small class="text-muted"> Last time you changed your password - <?php echo $passwordChange ?> </small>
			
			</div>
<hr class="my-4">
            <div id="details">
				<h4 class="text-muted p-2">My Personal Details</h4>
                <form method="POST">
                    <div id="errorArea">
                        <?php echo $messageBoxAdult; ?>
                    </div>
                    <div class="form-group col-8">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" id="username" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group col-8">
						<fieldset disabled>
                        <label for="email">Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" value="<?php echo $email; ?>">
							</fieldset>
						<a class="pageLink" href="emailUpdate.php"> Change my Email Address</a>
                    </div>
                    <hr class="my-4">
                    <div class="form-group col-8">
                        <label for="firstname">First Name</label>
                        <input class="form-control" type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
                        <label for="surname">Surname</label>
                        <input class="form-control" type="text" id="surname" name="surname" value="<?php echo $surname; ?>">

                    </div>


                    <div class="form-row col-12">
                        <div class="col-2">
                            <label for="DOB-Day">Day </label>
                            <select class="form-control" name="DOB-Day">
                                <?php
								if(isset($DOBday))
								   {	//checks if value has been set in previous post
									   $selectedDay = intval($DOBday);
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
								if(isset($DOBmonth))
								   {	//checks if value has been set in previous post
									   $selectedMonth = intval($DOBmonth);	
								   }                         
								 for($m=1; $m<=12; $m++)
								 {
									 if($m === $selectedMonth)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.
												$m.'">'.$months[$m-1].'</option>';
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
								
								if(isset($DOByear))
								   {	//checks if value has been set in previous post
									   $selectedYear = intval($DOByear);
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
                    <!--<small id="DOBHelp" class="form-text text-muted">For security you can not change your DOB after sign up.</small>-->
                    
                    <div class="col-4">
                    <label for="country">Where do you live?</label>
                    <select class="form-control" name="country">
                        <?php
                     
                        if(isset($country))
								   {	//checks if value has been set in previous post
									   $selectedCountry = $country;
								   }
                        foreach($countries as $s)
						{
							 if($s === $selectedCountry)
										{
											// if a previous selected value use this to hold value
											echo '<option selected="selected" value="'.$s.'">'.$s.'</option>';
										}
										else
										{
                            
                            				echo '<option value="'.$s.'">'.$s.'</option>';
										}
                       }
                        ?>
                        
                        
                        </select>
                    <input type="submit" class="btn btn-outline-secondary mt-2" name="save" value="Save Changes">
                    
                    </div>
					
                    
                </form>
            </div>
        </div>
</div>
        <div>

            <?php include'INCLUDES/PHP/footer.php'; ?>
        </div>
    
</body>

</html>
