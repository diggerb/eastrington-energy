<?php
session_start();

//error_reporting(0);

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'jimbo1',
		'db' => 'eastrington2'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800,
		'cookie_accept' => true
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	),
	'image' => array(
		'members' => 'members',
		'articles' => 'articles',
		'information' => 'information'
	)
);

spl_autoload_register(function($class){
	require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitise.php';
include_once 'includes/uk2stats.php';
include_once 'js/jquery.php';

if(cookie::exists(config::get('remember/cookie_name')) && !session::exists(config::get('session/session_name'))){
	$hash = cookie::get(config::get('remember/cookie_name'));
	$hashCheck = db::getInstance()->get('users_session', array('hash', '=', $hash));

	if($hashCheck->count()){
		$user = new user($hashCheck->first()->user_id);
		$user->login();
	}
}

function cookieAccept(){
	if(!cookie::exists(config::get('remember/cookie_accept'))){
		echo '<div style="width: 33%; position: fixed; right:0; z-index: 10000; cursor:pointer; transform: translate(0,-50%);">';
		echo '<div style="position: relative; width: 5%; font-size:210%; transform: translate(0,100%);">&times;</div>';
		echo '<div style="position: relative; width: 94%; float:right; ">By using this website you accept the use of cookies. <br/>Click here to discard this message.</div>';
		echo '</div>';
	}
}
