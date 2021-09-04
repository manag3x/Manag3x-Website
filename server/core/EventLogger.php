<?php
declare(strict_types=1);
namespace server\core;
use server\enum\{Activity,User,GeneralActivity};

class EventLogger {
    public static string $table_event_log = "system_user_event_log";
    public static string $table_login_log = "system_user_login_log";
 
    /**
     * log login event
     */
    public static function loginLog(int $id,string $event, string $note = "") : void {
        $ns           = "\server\model\\";
        $class        = $ns.User::get($id); // get user using user enum
        if(class_exists($class)) {
            $user = new $class();
            $event = Activity::get($event);
            $text = strtoupper($event->predicate);
            $username = $user->fullname;
            $user->note = $user::cleanse("[$username] ; [$text] $note");
            $user->loginLog();
        }
    }

    /**
     * log  event
     */
    public static function log(int $id, string $event, string $note = "") : void {
        $ns           = "\server\model\\";
        $class        = $ns.User::get($id); // get user using user enum
        if(class_exists($class)){
            $user         = new $class();
            $event        = Activity::get($event);
            $text         = strtoupper($event->predicate);
            $username     = $user->fullname;
            $user->note   = Core::cleanse("[$username] ; [$text] $note");
            $user->link   = $_SERVER["HTTP_REFERER"];
            $user->eventLog($id);
        }
    }

    /**
     * log  event
     */
    public static function generalLog(int $id, string $event,string $to) : void {
        $ns           = "\server\model\\";
        $class        = $ns.User::get($id); // get user using user enum
        if(class_exists($class)){
            $user         = new $class();
            $event        = GeneralActivity::get($event);
            $text         = ucwords($event->predicate);
            $username     = $user->fullname;
            $user_name    = ucfirst(User::get($id));
            $user->note   = Core::cleanse("$text $user_name: $username");
            $link         = $event->link;
            $user->link   = $link;
            $user->type   = $event->type;
            $user->genLog($id,$to);
        }
    }
}