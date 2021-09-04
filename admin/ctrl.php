<?php
$DIR = "../";
$USER = "admin";
require_once $DIR."server/core/AutoLoader.php";
$nSpace = 'server\controller\admin\\';
$url = server\core\Helper::ctrlRoute();
server\core\Controller::route($url,$nSpace);
