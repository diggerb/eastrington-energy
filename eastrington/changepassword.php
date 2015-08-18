<?php
require_once 'core/init.php';

$user = new user();

if(!$user->isLoggedIn()){
	redirect::to('index.php');
}

if(input::exists()){
	if(token::check(input::get('token'))){
		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 6
			),
			'password_new' => array(
				'required' => true,
				'min' => 6
			),
			'password_new_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password_new'
			)
		));

		if($validation->passed()){
			if(hash::make(input::get('password_current'), $user->data()->salt) !== $user->data()->password){
				echo 'Your current password is wrong.';
			} else {
				$salt = hash::salt(32);

				try{
					$user->update(array(
						'password' => hash::make(input::get('password_new'), $salt),
						'salt' => $salt
					), array('id', '=', $user->data()->id));

					session::flash('home', 'Your password has been changed successfully.');
					redirect::to('index.php');
				} catch(Exception $e){
					die($e->getMessage());
				}
			}
		} else {
			foreach($validation->errors() as $error){
				echo $error, '<br>';
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="password_current">Current password</label>
		<input type="password" name="password_current" id="password_current" autocomplete="off">
	</div>

	<div class="field">
		<label for="password_new">New password</label>
		<input type="password" name="password_new" id="password_new" autocomplete="off">
	</div>

	<div class="field">
		<label for="password_new_again">Repeat your new password</label>
		<input type="password" name="password_new_again" id="password_new_again" autocomplete="off">
	</div>

	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	<input type="submit" value="Change">
</form>

