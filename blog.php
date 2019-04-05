<?php

session_start();

include_once"INCLUDES/PHP/Var_Dumps.php";
include_once"INCLUDES/PHP/CLASS/messageFlags.class.php";
include_once"INCLUDES/PHP/dbConn.php";
include $blogPath;

global $more;


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

    <title>Blogs - <?php echo $_GLOBALS['G_SiteName'];?></title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">
	<link rel="stylesheet" href="INCLUDES/CSS/blogPost.css">
	

</head>

<body>
    <div id="header">
        <?php include'INCLUDES/PHP/navbar.php'; ?>
    </div>
    <div class="row container">
		<div class="pageTitle">
			<h3> Blog</h3>
		</div>
		<div id="errorArea">
                        <?php echo $messageBox; ?>
                    </div>

<?php
 

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

$noPosts = 2;

if(isset($_GET['offset']))
{
	$offset += $_GET['offset'];
}
else
{
	$offset = 0;
}

		
if(isset($_GET['tag']))
{
	$tagName = $_GET['tag'];
	$args = array( 'showposts' => $noPosts, 'offset' => $offset, 'tag'=>$tagName );
	
}
else
{
	$args = array( 'showposts' => $noPosts, 'offset' => $offset );
}

		

$wp_query = new \WP_Query();
$wp_query->query($args);

		while ($wp_query->have_posts()) :
   			$wp_query->the_post();

		$more = 1;
		$blogger = getBlogAuthor(get_the_author_id());
		$thumbnailSrc = $blogger['bloggerThumbName'];
		$thumbnailTag = "<img src='".$thumbnailSrc."'>";
		$author = $blogger['bloggerName'];
		$date = get_the_date();
		$date = date("l jS M Y", strtotime($date));
		
		$args = array(
  'id_form'           => 'commentform',
  'class_form'      => 'comment-form',
  'id_submit'         => 'submit',
  'class_submit'      => 'submit',
  'name_submit'       => 'submit',
  'title_reply'       => __( 'Leave a Reply' ),
  'title_reply_to'    => __( 'Leave a Reply to %s' ),
  'cancel_reply_link' => __( 'Cancel Reply' ),
  'label_submit'      => __( 'Post Comment' ),
  'format'            => 'xhtml',

  'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
    '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
    '</textarea></p>',

  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p>',

  'logged_in_as' => '<p class="logged-in-as">' .
    sprintf(
    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
      admin_url( 'profile.php' ),
      $user_identity,
      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
    ) . '</p>',

  'comment_notes_before' => '<p class="comment-notes">' .
    __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
    '</p>',

  'comment_notes_after' => '<p class="form-allowed-tags">' .
    sprintf(
      __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
      ' <code>' . allowed_tags() . '</code>'
    ) . '</p>',

  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
);
		
?>
	
<div class='blog-post'>
			<div class='blog-thumbnail'><?php echo $thumbnailTag; ?></div>
			<div class='blog-author'>By: <?php echo $author; ?></div>
			<div class='blog-date'><?php echo $date; ?></div>
		
			<div class='blog-title'><?php the_title()?></div>
			
			<div class='blog-div'><hr></div>
	
			<div class='blog-content'><?php the_content('Keep Reading', true); ?></div>	
			<div class='blog-footer'>Tags: <?php
												$posttags = get_the_tags();
												if ($posttags) {
												  foreach($posttags as $tag) {
													echo "<a class='tagName' href='blog.php?tag=".$tag->name ."'>".$tag->name." "; 
												  }
												}
												?> </div>
			<?php comment_form( $args, the_id ); ?> 
			
		</div>

	<?php endwhile; ?>

		</div>
	<div>
		<a class="nextBlogPage" href="blog.php?offset=<?php  echo ($offset+$noPosts);?>"> Next Page... </a>
	</div>
	
        <div>

            <?php include'INCLUDES/PHP/footer.php'; ?>
        </div>
    
</body>

</html>
