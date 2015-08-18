<?php
require_once 'core/init.php';

$user = new user();

$page = new page(
	$user,
	array(
		'js' => array(), 
		'css' => array()
	), 
	array()
);