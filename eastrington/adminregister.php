<?php
require_once 'core/init.php';

if(input::exists()){
	if(token::check(input::get('token'))){
		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			),
			'firstname' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'surname' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'email' => array(
				'required' => true	
			)
		));

		if($validation->passed()){
			$user = new user();

			$salt = hash::salt(32);

			try{
				$user->create(array(
					'username' => input::get('username'),
					'password' => hash::make(input::get('password'), $salt),
					'salt' => $salt,
					'firstname' => input::get('firstname'),
					'surname' => input::get('surname'),
					'email' => input::get('email'),
					'joined' => date::now(),
					'group' => 2
				));

				session::flash('home', 'You have been registered and can now login.');
				redirect::to('index.php');
			}catch(Exception $e){
				die($e->getMessage());
			}
		} else{
			foreach($validation->errors() as $error){
				echo $error, '<br>';
			}
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
	<meta charset="iso-8859-1">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	
	<script src="js/jquery-1.11.1.min.js"></script> 
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
	
</head>
<body>

	<form action="" method="post">
		<div class="field">
			<label for="useranme">Username</label>
			<input type="text" name="username" id="username" value="<?php echo escape(input::get('username')); ?>" autocomplete="off">
		</div>

		<div class="field">
			<label for="password">Choose a password</label>
			<input type="password" name="password" id="password" autocomplete="off">
		</div>

		<div class="field">
			<label for="password_again">Repeat your password</label>
			<input type="password" name="password_again" id="password_again" autocomplete="off">
		</div>

		<div class="field">
			<label for="name">Your first name</label>
			<input type="text" name="firstname" id="firstname" value="<?php echo escape(input::get('firstname')); ?>" autocomplete="off">
		</div>

		<div class="field">
			<label for="name">Your surname</label>
			<input type="text" name="surname" id="surname" value="<?php echo escape(input::get('surname')); ?>" autocomplete="off">
		</div>

		<div class="field">
			<label for="name">Your email address</label>
			<input type="text" name="email" id="email" value="<?php echo escape(input::get('email')); ?>" autocomplete="off">
		</div>

		<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
		<input type="submit" value="Register">
	</form>

</body>
</html>