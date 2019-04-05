<?php

session_start();

include_once"INCLUDES/PHP/Var_Dumps.php";
include_once"INCLUDES/PHP/globals.inc.php";
include_once"INCLUDES/PHP/CLASS/messageFlags.class.php";
include_once"INCLUDES/PHP/dbConn.php";


if(!array_key_exists('id', $_SESSION))
{
	header('Location: index.php?invalid');
	
}
else
{
$error = new messageBox();
$error->setBoxType("Error", "Sorry there is an Error", "");


function getBlogAuthor($id)
{
	global $conn;
	if(!empty($id))
	{
	$sql = "SELECT * FROM `bloggers` WHERE `bloggerID` = ?";
	
		$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql))
				{	
					$flag="ERROR SQL Statement Failed Fetch Authors";
					echo $flag;
					$error->addFlag($flag);
				}
				else
				{
					mysqli_stmt_bind_param($stmt,"s",$id);
					mysqli_stmt_execute($stmt);
					
					if(mysqli_stmt_errno($stmt)==0)
					{				
						$result = mysqli_stmt_get_result($stmt);
						if(mysqli_num_rows($result) == 0)
						{
							//if no results returned
							$row = array('bloggerName'=>'BoobBah', 'bloggerThumbName'=>"IMG/BLOGS/THUMBS/BoobBah_LOGO_PINK_100x100.php");
						}
						else
						{
							$row = mysqli_fetch_assoc($result);
						}
						return $row;

					}
					else
					{
						$flag = mysqli_stmt_error($stmt);
						echo $flag;
						$error->addFlag($flag);
					}
			   }
	}
	else
	{
		$flag = "ID is empty";
		echo $flag;
	}
}

define('WP_USE_THEMES', false);
require('Blog/wp-blog-header.php');


$messageBox = "";

	/*
if($error->flagsExist())
	{
		$messageBox = $error->getMessageBox();
	}
*/
	
}
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Join Us - <?php echo $GLOBAL['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">
	<link rel="stylesheet" href="INCLUDES/CSS/blogPost.css">
	

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
    <div class="row container">
		<div id="errorArea">
                        <?php echo $messageBox; ?>
                    </div>

<?php
 
$number_of_posts = 5;

	if (isset($_GET['offset']))
	{
		$offset += $_GET['offset'];
	}
	else
	{
		$offset = 0 ;
	}
		/*
	'numberposts' => 10,
	'offset' => 0,
	'category' => 0,
	'orderby' => 'post_date',
	'order' => 'DESC',
	'include' => '',
	'exclude' => '',
	'meta_key' => '',
	'meta_value' =>'',
	'post_type' => 'post',
	'post_status' => 'draft, publish, future, pending, private',
	'suppress_filters' => true
	*/
$args = array( 'numberposts' => $number_of_posts, 'offset' => $offset );
$recent_posts = wp_get_recent_posts( $args );
foreach( $recent_posts as $recent_post ){
	$blogger = array();


	$blogger = getBlogAuthor($recent_post['post_author']);
		$thumbnailSrc = $blogger['bloggerThumbName'];
		$thumbnailTag = "<img src='".$thumbnailSrc."'>";
		$author = $blogger['bloggerName'];
		$date = $recent_post['post_date'];
		$date = date("l jS M y", strtotime($date));
		//$content = $recent_post['post_content'];
		$content = get_the_content('Keep Reading');

	
echo	"<div class='blog-post'>
			<div class='blog-thumbnail'>".$thumbnailTag."</div>
			<div class='blog-author'>By: ".$author."</div>
			<div class='blog-date'>".$date."</div>
		
			<div class='blog-title'>".$recent_post['post_title']."</div>
			
			<div class='blog-div'><hr></div>
	
			<div class='blog-content'>".$content."</div>	
			 
		</div>";
}
	?>

		</div>
	
        <div id="footer" class="p-3">

            <?php include'INCLUDES/PHP/footer.php'; ?>
        </div>
    
</body>

</html>
