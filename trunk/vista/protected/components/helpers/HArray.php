<?php
class HArray {
	public static function array_var($arr, $key, $default = NULL) {
		if (isset($arr, $key)) {
			return $arr[$key] ? $arr[$key] : $default; 
		}
	}
}
?>
