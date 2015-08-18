<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="UTF-8">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<?php
		foreach($this->_css as $file){
			echo $file;
		}

		echo '<br/>';

		foreach($this->_js as $file){
			echo $file;
		}
	?>
	
</head>
<body>