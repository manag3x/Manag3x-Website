<?php
$DIR = "../";
$USER = "admin";
require_once $DIR."server/core/AutoLoader.php";
use server\core\View;
$config = new server\core\Config();
View::render("auth",[
    "page_type" => 'auth',
    "js" => ['authentication/form-2'],
    "css" => ['authentication/form-2',"forms/theme-checkbox-radio","forms/switches"],
    "custom_js" => ["auth/auth"],
    "page_root" => "admin/",
    "body_class" => "form",
    "core_script" => false,
    "page_salute" => "Welcome back admin, sign in to proceed",
]);