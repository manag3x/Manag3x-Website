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
    public static object $assets;
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
                "user" => "managex",
                "pass" => "Backlink2021",
                "db" => "managex",
            ];
        }
        else{
            self::$db = (object)[
                "host" => "localhost",
                "user" => "root",
                "pass" => "",
                "db" => "managex",
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

        self::$assets = Helper::object([
            "upload"            =>     $base . "uploads/",
            // "sass"              =>     $base . "assets/sass/",
            "plugin"            =>     $base . "assets/plugins/",
            "js"                =>     $base . "assets/js/",
            "css"               =>     $base . "assets/css/",
            "img"               =>     $base . "assets/images/",
            "custom"            => [
                "js"            =>     $base . "assets/custom/js/",
                "css"           =>     $base . "assets/custom/css/",
                "img"           =>     $base . "assets/custom/img/",
                "dimg"          =>     $dir . "assets/custom/img/",
            ],
            "uploads"           => [
                "root"          =>     $dir . "uploads/",
                "client"        =>     $dir . "uploads/client/",
                "admin"         =>     $dir . "uploads/admin/",
            ],
        ]);

        self::$site = Helper::object([
            "base"              => $base,
            "base_no_proto"     => $base,
            "name"              => "Manag3x",
            "name_full"         => "Manag3x | Your Business Management Software",
            "author"            => "Manag3x Team",
            "logo"              => self::$assets->img . "logo.png",
            "white_logo"        => self::$assets->img . "logo.png",
            "icon"              => self::$assets->img . "favicon.png",
            "pry_color"         => "",
            "sec_color"         => "",
            "email"             => "info@".self::$WEBSITE,
            "admin_email"       => "info@".self::$WEBSITE,
            "support"           => "support@".self::$WEBSITE,
            "copy"              => "Copyright &copy; Manag3x " . date("Y") . ", All Rights Reserved",
            "tel"               => "01234567890",
            "address"           => "",
        ]);
    }
}
