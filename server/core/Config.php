<?php
declare(strict_types=1);
namespace server\core;
use server\core\Helper;

final class Config{
    public static string $ENV = "PROD";
    public static bool $CRYPT = false;
    public static bool $SHOW_ERROR = false;
    public static string $WEBSITE = "manag3x.com";
    public static string $DIR;
    public static string $USER;
    public static object $site;
    public static object $res;
    public static object $user;
    public static object $mvc;
    public static object $db;

    public static function dbParam() : object{
        if(self::$ENV == "heroku"){
            self::$db = (object)[
                "host" => "ao9moanwus0rjiex.cbetxkdyhwsb.us-east-1.rds.amazonaws.com",
                "user" => "mychr92ze4a3irqb",
                "pass" => "drdpcgpxi5ij7lk7",
                "db" => "d9dicck27lsowmih",
            ];
        }elseif(self::$ENV == "prod"){
            self::$db = (object)[
                "host" => "localhost",
                "user" => "u989813977_backlink",
                "pass" => "Backlink2021",
                "db" => "u989813977_backlink",
            ];
        }
        else{
            self::$db = (object)[
                "host" => "localhost",
                "user" => "root",
                "pass" => "",
                "db" => "backlink",
            ];
        }
        return self::$db;
    }
    
    public function __construct(){
        $proto = "";
        $base_no_proto = "/backlink";
        $env = self::$ENV;

        if($_SERVER['HTTP_HOST'] == "manag3x.herokuapp.com"){
            $proto = "https://";
            $base_no_proto = "manag3x.herokuapp.com";
            self::$ENV = "heroku";
        }

        if($env == "prod"){
            $proto = "https://";
            $base_no_proto = "manag3x.com";
        }

        self::$DIR = $GLOBALS['DIR'];
        self::$USER = key_exists('USER',$GLOBALS) ? $GLOBALS['USER'] : "";
        $base = $proto . $base_no_proto . "/";
        $slash = DIRECTORY_SEPARATOR;
        $dir = self::$DIR;
        $usr = self::$USER;
        $env = self::$ENV == "prod" ? "prod" : "dev";

        self::$user = Helper::object([
            "root" => $base . "{$usr}/",
            "ctrl" => $base . "{$usr}/ctrl?",
        ]);

        self::$mvc = Helper::object([
            "ctrl" => [
                "admin"         =>     $dir . "server" . $slash . "controller" . $slash . "admin" . $slash,
                "client"        =>     $dir . "server" . $slash . "controller" . $slash . "client" . $slash,
            ],
           
            "view" => [
                "admin"         =>     $dir . "server" . $slash . "view" . $slash . "admin" . $slash,
                "client"        =>     $dir . "server" . $slash . "view"  . $slash . "client" . $slash,
            ],
            "ctrl"              =>     $dir . "server" . $slash . "controller" . $slash,
            "inc"               =>     $dir . "server" . $slash . "inc" . $slash,
            "view"              =>     $dir . "server" . $slash . "view" . $slash,
            "model"             =>     $dir . "server" . $slash . "model" . $slash,
        ]);

        self::$res = Helper::object([
            "upload"            =>     $base . "uploads/",
            "resource"          =>     $base . "resource/",
            "sass"              =>     $base . "resource/sass/",
            "plugin"            =>     $base . "resource/plugins/",
            "custom"            => [
                "js"            =>     $base . "resource/custom/js/",
                "css"           =>     $base . "resource/custom/css/",
                "img"           =>     $base . "resource/custom/img/",
                "dimg"          =>     $dir . "resource/custom/img/",
            ],
            "uploads"           => [
                "root"          =>     $dir . "uploads/",
                "client"        =>     $dir . "uploads/client/",
                "publisher"     =>     $dir . "uploads/publisher/",
            ],
            "assets"            => [
                "js"            =>     $base . "resource/assets/js/",
                "css"           =>     $base . "resource/assets/css/",
                "img"           =>     $base . "resource/assets/img/",
            ],
        ]);

        self::$site = Helper::object([
            "base"              => $base,
            "base_no_proto"     => $base,
            "name"              => "Manag3x",
            "name_full"         => "Manag3x | Your Global Access to Backlinks",
            "author"            => "Manag3x Team",
            "logo"              => self::$res->custom->img . "logo.png",
            "white_logo"        => self::$res->custom->img . "logo-white.png",
            "icon"              => self::$res->custom->img . "logo.png",
            "pry_color"         => "",
            "sec_color"         => "",
            "email"             => "info@".self::$WEBSITE,
            "admin_email"       => "lekanvgbg@gmail.com",
            "support"           => "support@".self::$WEBSITE,
            "copy"              => "Copyright &copy; Manag3x " . date("Y") . ", All Rights Reserved",
            "tel"               => "01234567890",
            "address"           => "",
        ]);
    }
}
