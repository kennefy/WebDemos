<!doctype html>
<?php 

include_once"INCLUDES/PHP/globals.inc.php";


?>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Coming Soon - <?php echo $GLOBAL['G_SiteName'];?> </title>
    <link rel="icon" href="IMG/logoNAV.png">
    <link rel="stylesheet" href="INCLUDES/CSS/mainStyle.css">
		<script type="text/javascript">
		
			
			
		function size()
		{
			var w = window.innerWidth
|| document.documentElement.clientWidth
|| document.body.clientWidth;
			
			
			document.getElementById('splash').width = w;
		}	
		
			
			
		
	</script>
	<style>
	
		#splash{
			
			height: auto;
		
			
			
		}
		
		#container{
			
			margin: auto;

		}
	
	</style>

	
</head>

<body>
	

	

	
<div id="container">
	<img src="IMG/splash-1.png" alt="comingSoon" id="splash" onload="size()" >
</div>
<div>

        <?php include'INCLUDES/PHP/footer.php'; ?>
    </div>	

</body>
</html>