<?php
class dir {
	public static function exists($location){
		clearstatcache();
		return is_dir($location);
	}

	public static function create($location){
		clearstatcache();
		if(!self::exists($location)){
			return mkdir($location, 0777, true);
		}

		return false;
	}
}