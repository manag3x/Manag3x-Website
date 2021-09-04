<?php
$DIR = "../";
$USER = "admin";
require_once $DIR."server/core/AutoLoader.php";
use server\core\Helper;
include_once "views.php";
$file = Helper::page();
view(!empty($file) ? $file : "dashboard");