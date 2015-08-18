<?php
require_once 'core/init.php';

$user = new user();
$db = db::getInstance();

$id =  escape(input::get('id'));
$queryarticle = $db->get('information', array('id', '=', $id))->first();

if(empty($queryarticle)){
	redirect::to(404);
	die();
} else {
		$article = $queryarticle->article;

		$parsedown = new parsedown();
		$output = $parsedown->text($article);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="iso-8859-1">
	<!--<meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/article2.css">
	
	<script src="js/jquery-1.11.1.min.js"></script> 
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
	
</head>
<body>

	<!-- <div id="overlay"></div> -->

	<input type="checkbox" id="menutoggle" autocomplete="off">

	<div id="menu">
		<div id="menuleft">
			<div id="menuitembox">
				<a href="search.php">
					<div id="search">Search</div>
				</a>

				<a href="index.php">
					<div class="menuitem">Home</div>
				</a>
				
				<?php

				if($user->isLoggedIn()){
					if($user->hasPermission('admin')){
						?>

				<a href="upload.php">
					<div class="menuitem">Upload</div>
				</a>


						<?php
					}
				?>

				<a href="profile.php?user=<?php echo escape($user->data()->username); ?>">
					<div class="menuitem">Profile</div>
				</a>
				<a href="logout.php">
					<div class="menuitem">Logout</div>
				</a>

				<?php
				} else {
				?>

				<a href="login.php">
					<div class="menuitem">Login</div>
				</a>
				<a href="register.php">
					<div class="menuitem">Register</div>
				</a>

				<?php
				}
				?>
			</div>
		</div>

		<label for="menutoggle">
			<div id="menuright">
				<div id="menutogglecontainer">
					<div id="menuicon"><p>&#8801;</p></div>
					<p id="menuiconmenu">menu</p>
				</div>
			</div>
		</label>
	</div>

	<div id="main">
		<div class="centre">
			<h2 id="title"><?php echo escape($queryarticle->title); ?></h2>
			
			<div class="text">
				<?php echo $output; ?>
			</div>
		</div>
	</div>

<script>
// find screen width
var innerwidth = window.innerWidth;
var centre = innerwidth / 10 * 7;


// apply centre width
document.getElementsByClassName('centre')[0].style.width = centre + 'px';

$(function(){
	$("#overlay").fadeOut();

	var top = $("#title").outerHeight() + 20; 
	console.log(top);
	$(".text").css("top",top)

	$("img").not("#avatar").parent().wrap('<div class="imgWrap"></div>');

		$(".imgWrap").hover(function(){
	
		var child = $(this).children("p").children("img");
		
		child.css("opacity","0.4");
		
		var alt = child.attr("alt");
		$(this).children("p").after('<div id="imgHover1"><div id="imgHover2"><div>'+alt+'</div></div></div>');
		
		var height = child.height();
		var width = child.width();
		$("#imgHover1").css({"height":height,"width":width});
		
		var position = child.position();

		$("#imgHover1").css({"top":position.top, "left":position.left});
		
	},
	function(){
		$(this).css("opacity","1");
		$("#imgHover1").remove();
		$(this).children("p").children("img").css("opacity","1");
	});
});

</script>

</body>
</html>

<?php
}
