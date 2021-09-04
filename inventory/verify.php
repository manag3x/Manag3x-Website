<?php
$DIR = "../";
$USER = "client";
require_once $DIR."server/core/AutoLoader.php";
use server\core\View;
$config = new server\core\Config();
View::render("verify",[
    "page_type" => 'verify',
    "page_root" => "client/",
]);