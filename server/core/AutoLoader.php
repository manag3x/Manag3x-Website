<?php
declare(strict_types=1);
session_start();

// CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}

spl_autoload_register(function($className) {
    $file = dirname(__DIR__) . $className . '.php';
    $file = str_replace(DIRECTORY_SEPARATOR.'server', DIRECTORY_SEPARATOR, $file);
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
//    echo $file;exit;
    if (file_exists($file)) {
        include_once $file;
    }
});
/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler("server\core\Error::errorHandler");
set_exception_handler("server\core\Error::exceptionHandler");