<?php
class hash {
	public static function make($string, $salt = ''){
		return hash('sha256', $string . $salt);
	}

	public static function salt($length){
		return mcrypt_create_iv($length);
	}

	public static function unique(){
		return self::make(uniqid());
	}

	public static function article($date){
		$part = explode(' ', $date);

		$date1 = str_replace("-", "", $part[0]);
		$date2 = str_replace(":", "", $part[1]);

		return array(0 => $date1, 1 => $date2);
	}
}