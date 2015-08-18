<?php
if(preg_match('/(.*\.)?eastringtonenergy\.co\.uk/', $_SERVER['HTTP_HOST'])){
	?>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<?php
}else{ 
	if(fsockopen("http://www.google.co.uk")){
		?>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<?php
	}else{
		?>

		<script src="js/jquery-1.11.1.min.js"></script>

		<?php
	}
}
