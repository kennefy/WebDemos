<?php


include_once("INCLUDES/PHP/validator2.php");
include_once('INCLUDES/PHP/messageFlags.class.php');


$navBar =	
	
	
	'<nav class="navbar navbar-expand-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <img id="navbarlogo" src="IMG/Logos/BoobBah_LOGO_PINK_100x100.png">
  <a class="navbar-brand brand" href="index.php">'.$_GLOBALS['G_SiteName'].'</a>
  
  <div class="collapse navbar-collapse" id="navbarToggler">
	';

if(array_key_exists('id',$_SESSION)){
	
	//logged in nav bar
	$navBar .= 
'

  
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	<li class="nav-item">
        <a class="nav-link nav_bar_link" href="blog.php">
		<img class="nav-Link_div" src="IMG/spacer-16x5px.png">
		Blog

		</a>
      </li>
      <li class="nav-item">
       <a class="nav-link nav_bar_link" href="feeds.php">
	   <img class="nav-Link_div" src="IMG/spacer-16x5px.png">
	   Feeds
	   
	   </a>
      </li>
      <li class="nav-item">
        <a class="nav-link nav_bar_link" href="locations.php">
		<img class="nav-Link_div" src="IMG/spacer-16x5px.png">
		Locations
		
		</a>
		
      </li>
   
	  
	  
	  <li class="nav-item">
        <a class="nav-link nav_bar_link" href="thought.php">
		<img class="nav-Link_div" src="IMG/spacer-16x5px.png">
		Thoughts

		</a>
      </li>
	  <li class="nav-item">
       <a class="nav-link nav_bar_link" href="account.php">
	   <img class="nav-Link_div" src="IMG/spacer-16x5px.png">
	  Account
	   
	   </a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0 float-lg-right"> 
      
	  <a class="btn btn-outline-secondary m-1 nav-item" href="INCLUDES/PHP/signOut.php" role="button">Sign Out</a>
    </form>
';
}else{
	
	//logged out nav bar
	

	$navBar .= 
		'
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		  <li class="nav-item active">
			   <a class="nav-link nav_bar_link" href="signUp.php">
				   <img class="nav-Link_div" src="IMG/spacer-16x5px.png">
				   Sign Up	   
			   </a>
		  </li>
	  </ul>
	<form class="form-inline my-2 my-lg-0" method="post">
      <input class="form-control mr-sm-2" type="text" name="nav-username" placeholder="Username/Email">
	  <input class="form-control mr-sm-2" type="password" name="nav-password" placeholder="Password">
      <button class="btn btn-outline-secondary my-2 my-sm-0" name="nav-signIn" value="nav-signIn" type="submit">Sign In</button>
  </form>
 
			';
}

$navBar .='</nav> <div class="navUnder"> &nbsp; </div> ';
$navBar .=' <div class="navUnder2"> &nbsp; </div>   ';

echo $navBar;
    