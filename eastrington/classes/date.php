<?php
class date {
	public static function display($full){
		$part = explode(' ', $full);

		$date = explode('-', $part[0]);
		$time = explode(':', $part[1]);

		$part1 = $date[2] . '/' . $date[1] . '/' . $date[0];
		$part2 = $time[0] . ':' . $time[1];

		return $part1 . ' at ' . $part2;
	}

	public static function now(){
		return date('Y-m-d H:i:s');
	}

	public static function foralpha($full){
		$part = explode(' ', $full);

		$date = explode('-', $part[0]);
		$time = explode(':', $part[1]);

		$date[0] = substr($date[0], 2);

		$part1 = $date[0] . $date[1] . $date[2];
		$part2 = $time[0] . $time[1] . $time[2];

		return array($part1, $part2);
	}
}