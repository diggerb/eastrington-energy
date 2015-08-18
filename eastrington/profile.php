<?php
require_once 'core/init.php';

if(!$username = input::get('user')){
	redirect::to('index.php');
} else {
	$user = new user($username);

	if(!$user->exists()){
		redirect::to(404);
	} else{
		$data = $user->data();
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="iso-8859-1">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">
	
	<script src="js/jquery-1.11.1.min.js"></script> 
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
	
</head>
<body>

	<h3><?php echo escape($data->username); ?></h3>
	<p>full name: <?php echo escape($data->name); ?></p>
	<p>Change Avatar <i>Coming Soon.</i></p>

</body>
</html>

	<?php
}