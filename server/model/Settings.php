<?php
namespace server\model;
use server\core\{Core, Session, Validation};
class Settings extends Core{

    public $id = "entity_guid";
    public $description,$fullname,$guid;
    function __construct(){
        Parent::__construct();
    }
    
    /**
     * add new Record
     *
     */
    public static function create($table){
        $data = new Validation;
        $admin = new Admin;
        $sql = "INSERT INTO {$table} (`entity_guid`,`name`,`description`,`act_date`,`act_by`) VALUES (uuid(),'$data->fullname','$data->description','$data->xdate','$admin->guid')";
        // echo $sql;
        return Parent::$conn->query($sql);
    }

    /**
     * Update Record Based on identity
     *
     */
    public function update($table){
        $data = new Validation();
        $sql = "UPDATE {$table} SET `name` = '$data->fullname', `description` = '$data->description' WHERE {$this->id} = '$data->id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    public function getloginLogs(){
        $sql = "SELECT * FROM {$this->tables->loginLog}  ORDER BY act_date DESC";
        return $this->fetchAll($sql);
    }

    public function getClientLogs(){
        $sql = "SELECT * FROM {$this->tables->event_log} WHERE `user` = 4 ORDER BY act_date DESC";
        return $this->fetchAll($sql);
    }
}
?>