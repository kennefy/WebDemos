<?php

session_start();

include"INCLUDES/PHP/Var_Dumps.php";
include_once("INCLUDES/PHP/navBarSignIn.inc.php");
require_once 'INCLUDES/PHP/signUp.inc.php';
include"INCLUDES/PHP/globals.inc.php";

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Join Us - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
    <div class="row container">
        <div class="col-8">
            <h1 class="text-muted">

                Join Us</h1>

            <hr class="my-4">

            <div id="signupForm">
                <form method="POST">
                    <div id="errorArea">
                        <?php echo $messageBox; ?>
                    </div>
                    <div class="form-group col-8">
                        <label for="username">Pick a Username</label>
                        <input class="form-control" type="text" id="username" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group col-8">
                        <label for="email">Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" value="<?php echo $email; ?>">
                        <label for="confirmEmail">Confirm Email </label>
                        <input class="form-control" type="email" id="confirmEmail" name="confirmEmail" value="<?php echo $confirmEmail; ?>">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
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
                    
                    
                    </div>
                    <hr class="my-4">
                    <div class="form-group col-12">
                        <label for="password">Password</label>
                        <input class="form-control col-8" type="password" id="password" name="password">
                        <label for="confirmPassword">Confirm Password </label>
                        <input class="form-control col-8" type="password" id="confirmPassword" name="confirmPassword">
                        <small id="passwordHelp" class="form-text text-muted"><?php echo $passwordRequirements; ?></small>
                        <input class="btn btn-outline-secondary btn-block  m-2" type="submit" id="submit" name="submit" value="Sign Up">
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
