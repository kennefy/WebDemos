<?php


include_once("INCLUDES/PHP/validator2.php");
include_once('INCLUDES/PHP/messageFlags.class.php');


$navBar =	
	
	
	'<nav class="navbar navbar-expand-lg feedNav">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <span>FEEDS</span>
  
  <div class="collapse navbar-collapse feedNav" id="navbarToggler">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	
      <li class="nav-item">
       <a class="nav-link  feednavlink" href="feeds.php">
	   <img class="feed-nav-Link_div" src="IMG/spacer-16x5px.png">
	   Add A Feed
	   
	   </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  feednavlink" href="view-feeds.php">
		<img class="feed-nav-Link_div" src="IMG/spacer-16x5px.png">
		Show My Feeds
		</a>
      </li> 
    </ul>
    
';

$navBar .='</nav> <div class="navUnder"> &nbsp; </div> ';

echo $navBar;
    