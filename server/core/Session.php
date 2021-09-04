<?php
namespace server\core;

abstract class Session{

    public static function confirm($user){
        if(!isset($_SESSION[$user]["__id_"])){
            if(isset($_SERVER['HTTP_REFERER']))
                $_SESSION["from"] = @$_SERVER['HTTP_REFERER'];
            header("Location:auth");
        }
    }

	/**
	 * check if sssion is active
	 * @param string $user session name
	 */
    public static function active($user) {
        return (isset($_SESSION[$user]["__id_"])) ? true : false;
    }

	/**
	 * set session
	 * @param string $user session name
	 */
    public static function set($user,object $vars) {
        $_SESSION[$user]["__id_"]          = $vars->entity_guid ?? "";
        $_SESSION[$user]["name"]        = $vars->name ?? "";
        $_SESSION[$user]["username"]    = $vars->username ?? "";
        $_SESSION[$user]["email"]       = $vars->email ?? "";
        $_SESSION[$user]["phone"]       = $vars->tel ?? "";
        $_SESSION[$user]["image"]       = $vars->profile_pic ?? "";
        $_SESSION[$user]["date"]        = $vars->act_date ?? "";
        $_SESSION[$user]["description"] = $vars->description ?? "";
        $_SESSION[$user]["project"]     = $vars->project ?? "";
        $_SESSION[$user]["data"]        = $vars;
    }
    
    /**
	 * get session
	 * @param string $user session name
	 */
    public static function get($user) {
        return (isset($_SESSION[$user]['__id_'])) ? (object)$_SESSION[$user] : "";
    }

    /**
	 * destroy session
	 * @param string $user session name
	 */
    public static function destroy($user) {
        unset($_SESSION[$user]);
    }

}

