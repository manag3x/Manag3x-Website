<?php
namespace server\model;
use server\core\Core;
class Permission extends Core{

    public $table = "system_permission",$id = "user_guid",$admin,$xdate;
    public static $permissions = ['system_user',"articles","system_logs","client","writer","editor","admin","publisher","guest","inventory","archive","create_task","settings","enter_accounts","guest_articles","writers_articles","new_guest_articles"];
    function __construct($admin){
        Parent::__construct();
        $this->admin = $admin;
    }
    
    // get admin permissions
    public function getPermissions(){
        return $this->getById($this->admin);
    }

    // get admin permissions
    public static function getAsEnum(){
        return self::$permissions;
    }

    // get admin permissions
    public function hasPermission($permission){
        return (!empty($permission)) ? $this->isExist($permission,1,$this->admin) : true;
    }

    /**
     * set admin permission
     *
     * @return void
     */
    public function setPermission(){
        $content = [];
        // set $_POST
        foreach (self::$permissions as $prop){
            $var = Core::treat($prop);
            $content [] = "$prop"."="."'$var'";
        }
        $output = implode(",", $content);
        $sql = "INSERT INTO {$this->table} SET `entity_guid` = uuid(),`user_guid` = '$this->admin', {$output} ,`act_date` = '$this->xdate'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * update admin permission
     *
     * @return void
     */
    public function updatePermission(){
        $content = [];
        // set $_POST
        foreach (self::$permissions as $prop){
            $var = Core::treat($prop);
            $content [] = "$prop"."="."'$var'";
        }
        $output = implode(",", $content);
        $sql = "UPDATE {$this->table} SET `entity_guid` = uuid(),`user_guid` = '$this->admin', {$output} ,`act_date` = '$this->xdate' WHERE {$this->id} = '$this->admin'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

}
?>