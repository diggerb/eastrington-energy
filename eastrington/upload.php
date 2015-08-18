<?php
require_once 'core/init.php';

$user = new user();

if(!$user->hasPermission('admin')){
	redirect::to(404);
	die();
} else {
	if(input::exists()){
		if(token::check(input::get('token'))){
			$validate = new validate();
			$validation = $validate->check($_POST, array(
				'title' => array(
					'required' => true,
					'min' => 1,
					'max' => 70
				),
				'description' => array(
					'max' => 210
				),
				'article' => array(
					'required' => true
				)
			));

			$article = new article();
			$alpha = alphaID::generate();

			if($validation->passed()){
				try{
					$article->create(array(
						'alpha' => $alpha,
						'title' => escape(input::get('title')),
						'description' => escape(input::get('description')),
						'article' => escape(article::imgurl(input::get('article'), $alpha))
					), array(
						'alpha' => $alpha,
						'uploaderid' => $user->data()->id,
						'date' => date::now()
					));

					session::put('alpha', $alpha);
					session::put('i', 0);
					session::put('imagenum', 0);
					session::put('article', input::get('article'));
					redirect::to('imageupload.php');
				} catch(Exception $e) {
					die($e->getMessage());
				}


			}else{
				echo '<div style="text-align:right;">';

				foreach($validation->errors() as $error){
					echo $error, '<br>';
				}

				echo '</div>';
			}
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
	<link rel="stylesheet" type="text/css" href="css/upload.css">
	
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
					<div id="menuicon"><p>≡</p></div>
					<p id="menuiconmenu">menu</p>
				</div>
			</div>
		</label>
	</div>

	<div id="main">
		<div id="mainpart">

			<form action="upload.php" method="POST">
				<fieldset>
					<legend>Article Upload</legend>
					
					<p>* = field required</p>
					
					<label>*Title:</label>
					<br/>Characters remaining: <input disabled  maxlength="2" size="2" value="70" id="counter">
					<br/>
					<textarea autocomplete="on" name="title" id="title" onkeyup="textCounter(this,'counter',70);" maxlength="70" cols=32 rows=2></textarea>
					
					<br/><br/>
					<label>Article Description:</label>
					<br/>Characters remaining: <input disabled  maxlength="2" size="2" value="210" id="counter2">
					<br/>
					<textarea name="description" id="description" onkeyup="textCounter(this,'counter2',160);" maxlength="160" cols=60 rows=4></textarea>
					
					<br/><br/>
					<label>*Article:</label>
					<br/>This is where you need to use MarkDown. <a href="markdown.php" target="_blank">Click here</a> for details on how to use MarkDown. 
					<br/>Tip: I recommend writing your article in a word editor before uploading. e.g. Microsoft Word or Notepad. <a href="tip.php" target="_blank">Click here</a> to find out why.
					<br/>
					<textarea name="article" id="article" cols=100 rows=10></textarea>

					<br/><br/>
					<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
					<input type="submit" value="Submit"/>
				</fieldset>
			</form>

		</div>
	</div>

<script>
 
function textCounter(field,field2,maxlimit){
	var countfield = document.getElementById(field2);
	if(field.value.length > maxlimit){
		field.value = field.value.substring( 0, maxlimit );
  		return false;
 	} else {
 		countfield.value = maxlimit - field.value.length;
 	}
}

</script>

</body>
</html>



	<?php
}