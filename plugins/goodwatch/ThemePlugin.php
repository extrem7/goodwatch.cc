<?php

/**
 * Plugin Name: GoodWatch
 * Version: 1.0
 * Author: Raxkor
 * Author uri: https://t.me/drKeinakh
 */

require_once "includes/functions.php";
require_once "Watch.php";

global $watch;
$watch = new Watch();

function watch() {
	global $watch;
	return $watch;
}