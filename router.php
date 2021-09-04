<?php
require_once "server/core/AutoLoader.php";
$nSpace = 'server\controller\admin\\';
$url = server\core\Helper::ctrlRoute();
server\core\Controller::route($url);