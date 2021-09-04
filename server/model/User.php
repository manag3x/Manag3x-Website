<?php
namespace server\model;
use server\core\{Core, Helper, Session, Validation};
class User extends Core{

    public $table,$id,$user;
    public $username,$email,$password,$description,$phone,$image,$fullname,$project,$guid,$date,$note,$code,$pre,$data;
    function __construct(){
        Parent::__construct();
        $dat = Session::get($this->user);
        if(isset($dat) AND !empty($dat)){
            if(is_object($dat)){
                $this->data         = $dat->data ?? "";
                $this->fullname     = $dat->name ?? "";
                $this->email        = $dat->email ?? "";
                $this->phone        = $dat->phone ?? "";
                $this->username     = $dat->username ?? "";
                $this->image        = $dat->image ?? "";
                $this->guid         = $dat->__id_ ?? "";
                $this->description  = $dat->description ?? "";
                $this->date         = $dat->date ?? "";
            }
        }
    }
    
    /**
     * add new Record
     *
     * @return void
     */
    public function create($status = 0){
        $data = new Validation;
        $admin = new Admin;
        $guid = ($status > 0) ? $admin->guid : "";
        $code = Helper::genRand(10,$this->pre);
        $sql = "INSERT INTO {$this->table} (`entity_guid`,`code`,`name`,`email`,`password`,`session_token`,`act_date`,`act_by`,`activated`,`status`) VALUES (uuid(),'$code','$data->fullname','$data->email','$data->password','$data->token','$data->xdate','$guid','$status','$status')";
        // echo $sql;
        if(Parent::$conn->query($sql)){
            $last = $this->getGuid("id",mysqli_insert_id(parent::$conn));
            return (object)["true" => true,"data" => $last];
        }
        return (object)["true" => false];
    }

    public function oAuth($data,$oauth){
        $code = Helper::genRand(10,$this->pre);
        $sql = "INSERT INTO {$this->table} (`entity_guid`,`oauth_id`,`name`,`email`,`code`,`session_token`,`act_date`,`activated`,`status`,`oauth`) VALUES (uuid(),'$data->id','$data->fullname','$data->email','$code','$data->token','$data->xdate',1,1,'$oauth')";
        // echo $sql;
        if(Parent::$conn->query($sql)){
            $last = $this->getGuid("id",mysqli_insert_id(parent::$conn));
            return $last;
        }
        return "";
    }
    
    /**
     * activate user account
     *
     * @param [type] $id
     * @return void
     */
    public function activate($id){
        $data = new Validation();
        $sql = "UPDATE {$this->table}  SET `activated` = 1,`status` = 1,`session_token` = '$data->token' WHERE $this->id = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * update user token
     *
     * @param [type] $id
     * @return void
     */
    public function updateToken($id){
        $sql = "UPDATE {$this->table}  SET `session_token` = '$this->token' WHERE $this->id = '$id'";
        // echo $sql;
        return Parent::$conn->query($sql);
    }

    /**
     * Update Record Based on identity
     *
     * @param id $id
     * @return void
     */
    public function update(){
        $data = new Validation();
        if(empty($data->image))
            $sql = "UPDATE {$this->table} SET `tel` = '$data->phone', `email` = '$data->email',`description` =             '$data->description' WHERE {$this->id} = '$data->id'";
        else
            $sql = "UPDATE {$this->table} SET `tel` = '$data->phone', `email` = '$data->email',`description` =             '$data->description', `profile_pic` = '$data->image' WHERE {$this->id} = '$data->id'";
            
            // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

}
?>