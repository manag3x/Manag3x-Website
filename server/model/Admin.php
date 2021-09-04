<?php
namespace server\model;
use server\core\{Helper,Validation};
class Admin extends User{

    public $table = "system_user",$id = "entity_guid", $user = "admin",$pre = "ADM",$super,$permission;
    function __construct(){
        Parent::__construct();
        $this->super = (!empty($this->data)) ? $this->data->super_admin : "";
        $this->permission = new Permission($this->guid);
    }
    
    // return tru if current admin is super admin
    public function isSuper(){
        return ($this->super > 0) ? true : false;
    }

    public function create($status = 1){
        $data = new Validation;
        $code = Helper::genRand(10,$this->pre);
        while($this->isExist("code",$code)){
            $code = Helper::genRand(10,$this->pre);
        }
        $sql = "INSERT INTO {$this->table} (`entity_guid`,`code`,`name`,`email`,`password`,`session_token`,`act_date`,`act_by`,`activated`,`status`) VALUES (uuid(),'$code','$data->fullname','$data->email','$data->password','$data->token','$data->xdate','$this->guid','$status','$status')";
        // echo $sql;
        if(Parent::$conn->query($sql)){
            $last = $this->getGuid("id",mysqli_insert_id(parent::$conn));
            // set permission
            $perm = new Permission($last); $perm->setPermission();
            // if($)
                return (object)["true" => true,"data" => $last];
            // else
            //     return (object)["true" => false,"data" => "could not set permission"];
        }
        return (object)["true" => false];
    }
    
    /**
     * Update Record Based on identity
     *
     * @param id $id
     * @return void
     */
    public function update(){
        $data = new Validation();
        $sql = "UPDATE {$this->table} SET `tel` = '$data->phone',`name` = '$data->fullname',`email` = '$data->email',`description` = '$data->description',`update_date` = '$data->xdate',`updated_by` = '$this->guid' WHERE {$this->id} = '$this->guid'";
        // echo $sql;exit;
        if(Parent::$conn->query($sql)){
            return $this->permission->updatePermission();
        };
    }

    /**
     * accept or decline assigned job
     *
     * @param order_id $order
     * @param status $action
     * @return void
     */
    public function action($order,$action){
        $sql = "UPDATE orders_customer  SET `status` = '$action' WHERE `order` = '$order'";
        // echo $sql;
        if(Parent::$conn->query($sql)){
            if($action == "1"){
                $sql = "UPDATE orders  SET `assigned` = '$action', customer = '$this->entity_guid', `status` = 3 WHERE `entity_guid` = '$order'";
            }else{
                $sql = "UPDATE orders  SET `assigned` = '$action' WHERE `entity_guid` = '$order'";
            }
            
            return Parent::$conn->query($sql);
        };
    }

    

    /*
    * get new messages
    *
    * @param order_id $order
    * @param string $msg
    * @return void
    */
    public function newMessage($order = ""){
        if(!empty($order))
            $sql = "SELECT * FROM messages WHERE order_id = '$order' AND deleted = 0 AND sender_id != '$this->entity_guid' AND `status` <= 2";
        else
            $sql = "SELECT * FROM messages WHERE deleted = 0 AND sender_id != '$this->entity_guid' AND `status` <= 2";
        return [
            "output" => Parent::fetchAll($sql),
            "rows"  => $this->getNumRows($sql)
        ];
     }
}
?>