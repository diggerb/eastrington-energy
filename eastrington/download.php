<?php
require_once 'core/init.php';

$link = escape(input::get('link'));

$type = substr($link, strrpos($link, '.') + 1);
$url = "downloads/" . $link;

header("Content-disposition: attachment; filename=" . $url);
header("Content-type: application/" . $types);
readfile($url);