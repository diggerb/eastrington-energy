<?php
require_once 'core/init.php';

$user = new user();
$db = db::getInstance();

$alpha =  escape(input::get('alpha'));
$queryarticle = $db->get('articles', array('alpha', '=', $alpha))->first();
$queryarticledata = $db->get('articles_data', array('alpha', '=', $alpha))->first();
$queryauthor = $db->get('users', array('id', '=', $queryarticledata->uploaderid))->first();

if(empty($queryarticle) or empty($queryarticledata)){
	redirect::to(404);
	die();
} else {
	if(empty($queryauthor)){
		redirect::to(404);
		die();
	} else {
		$article = $queryarticle->article;
		iconv("UTF-8", "ISO-8859-1//TRANSLIT", $article);

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
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/article.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	
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
			<div id="left">
				<h1 class="title"><?php echo escape($queryarticle->title); ?></h1>
				
				<div class="info">
					<img src="<?php echo escape(image::get('members', $queryauthor->id, true)); ?>" id="avatar"/>
					<br/><br/><br/><br/>
					<p><?php echo escape($queryauthor->firstname) . ' ' . escape($queryauthor->surname); ?></p>
					<p><?php echo escape(date::display($queryarticledata->date)); ?></p>
				</div>
			</div>
			<div id="right">
				<div class="text">
					
<?php	

echo $output;

?>	
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
// find screen width
var innerwidth = window.innerWidth;
var centre = innerwidth / 10 * 7;


// apply centre width
document.getElementsByClassName('centre')[0].style.width = centre + 'px';






// finding arrow correct position

// width of left
var widthpercent = 0.6 * 0.4;
var leftwidth = Math.round(innerwidth * widthpercent);

// find border lengths
var bordertop = leftwidth / 100 * 5;
var bordertop2 = bordertop * bordertop;
var borderright = Math.sqrt(bordertop2 + bordertop2);
var borderright2 = borderright / 2;

// log border numbers
console.log('bordertop: ' + bordertop);
console.log('borderright: ' + borderright);



// find image location
function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
  
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
}

var myelement = document.getElementById('avatar');
var position = getPosition(myelement);
console.log("The avatar is located at: " + position.x + ", " + position.y);

// arrow location on the line
var arrowposition = position.y + 50 - borderright2;
console.log('arrowposition: ' + arrowposition);



// apply border lengths
document.styleSheets[0].insertRule('#left::before { z-index:10; display:block; position:absolute; content:" "; width:0; height:0; right:0; top:' + arrowposition + 'px ; border-top:' + bordertop + 'px solid transparent; border-bottom:' + bordertop + 'px solid transparent; border-right:' + borderright + 'px solid #4D4E53; }', 1);
document.styleSheets[0].insertRule('#left::after { z-index:10; display:block; position:absolute; content:" "; width:0; height:0; right:-2px; top:' + arrowposition + 'px ; border-top:' + bordertop + 'px solid transparent; border-bottom:' + bordertop + 'px solid transparent; border-right:' + borderright + 'px solid #fff; }', 1);







$(function(){

	$("#overlay").fadeOut();

	$("img").not("#avatar").parent().wrap('<div class="imgWrap"></div>');


	$(".imgWrap").hover(function(){
	
		var child = $(this).children("p").children("img");
		
		child.css("opacity","0.4");
		
		var alt = child.attr("alt");
		$(this).children("p").after('<div id="imgHover1"><div id="imgHover2"><div>'+alt+'</div></div></div>');
		
		var height = child.height();
		var width = child.width();
		$("#imgHover1").css({"height":height,"width":width});
		
		var imgPosition = child.offset();
		var bodyHeight = $(window).height() / 100 * 3;
		var place = imgPosition.top - bodyHeight;
		$("#imgHover1").css({"top":place});
		
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
}


