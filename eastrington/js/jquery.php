<?php
if(preg_match('/(.*\.)?eastringtonenergy\.co\.uk/', $_SERVER['HTTP_HOST'])){
	?>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<?php
}else{ 
	if(@fsockopen("www.google.co.uk", 80)){
		?>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<?php
	}else{
		?>

		<script src="js/jquery-1.11.1.min.js"></script>

		<?php
	}
}
