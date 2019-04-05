<?php

session_start();

include_once'INCLUDES/PHP/CLASS/messageFlags.class.php';
$error = new messageBox();
$error->setBoxType('error', 'Sorry There Was A Problem Signing In', 'Please fix the errors below');

include_once("INCLUDES/PHP/navBarSignIn.inc.php");
include_once"INCLUDES/PHP/globals.inc.php";
include"INCLUDES/PHP/Var_Dumps.php";



?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-8423357029805234",
			enable_page_level_ads: true
		  });
		</script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Welcome to - <?php echo $GLOBAL['G_SiteName'];?> </title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">

</head>

<body>
    
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
    
    <div class="jumbotron jumbotron-fluid px-5 mt-4" id="jumbotronHome">
        <h1 class="display-4 text-light">Here to help!</h1>
        <p class="lead text-light">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p class="text-light">It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-outline-secondary btn-lg" href="signUp.php" role="button" id="jumboSignUp">Join In</a>
    </div>

    <div id="midSection" class="m-3">

        <div class="row m-3 card-deck" id="cardDeck">
            <div class="col-md-4">
                <div class="card aboutCard">
                    <img class="card-img-top" src="IMG/bottles-Card-286x180.png" alt="cardImage">
                    <div class="card-body">
                        <h5 class="card-title"> Card Title</h5>
                        <p class="card-text"> This is some made up text for the card </p>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card aboutCard">
                    <img class="card-img-top" src="IMG/mum-Card-286x180.png" alt="cardImage">
                    <div class="card-body">
                        <h5 class="card-title"> Card Title</h5>
                        <p class="card-text"> This is some made up text for the card </p>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card aboutCard">
                    <img class="card-img-top" src="IMG/postit-Card-286x180.png" alt="cardImage">
                    <div class="card-body">
                        <h5 class="card-title"> Card Title</h5>
                        <p class="card-text"> This is some made up text for the card </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

        <?php include'INCLUDES/PHP/footer.php'; ?>
    </div>

    <!-- includes !-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>
