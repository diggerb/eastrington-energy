<?php
require_once 'core/init.php';

$user = new user();
$db = db::getInstance();

$query = $db->get('articles', array('showing', '=', '1'), array('id', true, 3));

if($query){
	foreach($query->results() as $key => $item){
		$alpha[$key] = $item->alpha;
		$title[$key] = $item->title;
		$description[$key] = $item->description;
	}
}

$information = $db->getall('information');

if($information){
	foreach($information->results() as $key => $item){
		$articleid[$key] = $item->id;
		$articletitle[$key] = $item->title;
		$articledescription[$key] = $item->description;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="UTF-8">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">
	
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

				<a href="">
					<div class="menuitem">Newsletter - Coming Soon</div>
				</a>
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
		<ul class="centre cf">
			<li class="specialitem">
				<div>
					<p id="welcome">Welcome to </p>
					<p id="eastrington">Eastrington Energy</p>
				</div>
			</li>

			<li class="header">
				<p>Latest News</p>
			</li>
			
			<a href="article.php?alpha=<?php echo escape($alpha[0]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('articles', $alpha[0])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($title[0]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($description[0]); ?></p>
					</div>
				</li>
			</a>
			<a href="article.php?alpha=<?php echo escape($alpha[1]); ?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('articles', $alpha[1])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($title[1]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($description[1]); ?></p>
					</div>
				</li>
			</a>
			<a href="article.php?alpha=<?php echo escape($alpha[2]); ?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('articles', $alpha[2])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($title[2]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($description[2]); ?></p>
					</div>
				</li>
			</a>
			
			
			
			<li class="header">
				<p>Making Energy</p>
			</li>
			
			<a href="information.php?id=<?php echo escape($articleid[0]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[0])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[0]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[0]); ?></p>
					</div>
				</li>
			</a>
			<a href="information.php?id=<?php echo escape($articleid[1]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[1])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[1]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[1]); ?></p>
					</div>
				</li>
			</a>
			<a href="information.php?id=<?php echo escape($articleid[2]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[2])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[2]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[2]); ?></p>
					</div>
				</li>
			</a>
			
			
			
			<li class="header">
				<p>Information</p>
			</li>
			
			<a href="information.php?id=<?php echo escape($articleid[3]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[3])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[3]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[3]); ?></p>
					</div>
				</li>
			</a>
			<a href="information.php?id=<?php echo escape($articleid[4]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[4])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[4]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[4]); ?></p>
					</div>
				</li>
			</a>
			<a href="information.php?id=<?php echo escape($articleid[5]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[5])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[5]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[5]); ?></p>
					</div>
				</li>
			</a>
			
			
			
			<li class="header">
				<p>More About Us</p>
			</li>
			
			<a href="information.php?id=<?php echo escape($articleid[6]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[6])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[6]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[6]); ?></p>
					</div>
				</li>
			</a>
			<a href="information.php?id=<?php echo escape($articleid[7]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[7])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[7]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[7]); ?></p>
					</div>
				</li>
			</a>
			<a href="information.php?id=<?php echo escape($articleid[8]);?>">
				<li class="item" style="background-image: url(<?php echo escape(image::get('information', $articleid[8])); ?>);">
					<div class="itemhover">
						<p class="title"><?php echo escape($articletitle[8]); ?></p>
						<div class="divider"></div>
						<p class="description"><?php echo escape($articledescription[8]); ?></p>
					</div>
				</li>
			</a>
		</ul>
	</div>

<script>

// find screen width
var innerwidth = window.innerWidth;
var maxwidth = innerwidth / 4 * 3;

//find margin
var totalmargin = innerwidth / 100 * 8;
var margin = totalmargin / 6;
var margintop = margin * 1.2;
var marginx4 = margin * 4;



function applyMarginLeft(boxType){

	// get all items
	var box = document.getElementsByClassName(boxType);

	var index;
	for (index = 0; index < box.length; ++index){
		document.getElementsByClassName(boxType)[index].style.marginLeft = margin + 'px';
		document.getElementsByClassName(boxType)[index].style.marginRight = margin + 'px';
	} // end of margin to items
	
	console.log('applyMarginLeft complete: ' + boxType + '.');
} // end of function



function applyMarginTop(boxType){

	// get all items
	var box = document.getElementsByClassName(boxType);

	var index;
	for (index = 0; index < box.length; ++index){
		document.getElementsByClassName(boxType)[index].style.marginTop = margintop + 'px';
		document.getElementsByClassName(boxType)[index].style.marginBottom = margintop + 'px';
	} // end of margin to items
	
	console.log('applyMarginTop complete: ' + boxType + '.');
} // end of function



applyMarginLeft('item');
applyMarginLeft('specialitem');
applyMarginLeft('header');

applyMarginTop('item');
applyMarginTop('specialitem');
applyMarginTop('header');


// total horizontal padding
var i = totalmargin;

// finding the width of centre
while (i < maxwidth){
	i = i + 48;
}

var centre = 0;

if (i > maxwidth){
	centre = i - 48;
}

// total width of item boxes
var totalitembox = centre - totalmargin;

// item box width and height
var width = totalitembox / 3;
var widthx3 = width * 3;
var height = width / 16 * 9;
var specialwidth = widthx3 + marginx4;



// apply centre width
document.getElementsByClassName('centre')[0].style.width = centre + 'px';



function applyToItems(boxType){
	
	//get all items
	var box = document.getElementsByClassName(boxType);
	
	var index;
	for (index = 0; index < box.length; ++index){
		document.getElementsByClassName(boxType)[index].style.width = width + 'px';
		document.getElementsByClassName(boxType)[index].style.height = height + 'px';
	} // end of width to items
	
	console.log('applyToItems complete: ' + boxType + ' height and width.');
}



applyToItems('item');



function applyToSpecialItems(boxType){
	
	//get all items
	var box = document.getElementsByClassName(boxType);
	
	var index;
	for (index = 0; index < box.length; ++index){
		document.getElementsByClassName(boxType)[index].style.width = specialwidth + 'px';
		document.getElementsByClassName(boxType)[index].style.height = height + 'px';
	} // end of width to items
	
	console.log('applyToSpecialItems complete: ' + boxType + ' height and width.');
}



//applyToSpecialItems('specialitem');



function applyToHeaders(boxType){
	
	//get all items
	var box = document.getElementsByClassName(boxType);
	
	var index;
	for (index = 0; index < box.length; ++index){
		document.getElementsByClassName(boxType)[index].style.width = specialwidth + 'px';
	} // end of width to items
	
	console.log('applyToHeaders complete: ' + boxType + ' height and width.');
}



applyToHeaders('header');
applyToHeaders('specialitem');


$(function(){
	$("#overlay").fadeOut();
})

</script>

</body>
</html>