<?php
namespace server\controller\admin;
use server\core\{EventLogger};
use server\model\Permission;

class Admin extends \server\controller\Auth {
    public $user = "admin",$module = "Admin",$admin,$auth,$password,$class,$table,$data,$enumUser = 0;
	public function __construct(){
        Parent::__construct();
        $this->class = new \server\model\Admin;
        $this->table = $this->class->table;
	}
    
    //get admin by id
    public function get(){
	    $data = [];
        $data['data'] = $this->class->getById($this->data->id);
        $data["permission"] = (new Permission($this->data->id))->getPermissions();
        echo json_encode($data);
    }
    
    // upload document
    public function delete()
    {
        if(empty($this->data->id)){
            echo json_encode(array("message" => " No Identity", "valid" => 0));
            exit();
        }
        else{
            if($this->class->deleteRecord($this->data->id,$this->class->guid)){
                EventLogger::log(0,"delete","a Guest Writer with ID: {$this->class->getById($this->data->id)->code}");
                echo json_encode(array("message" => "Guest Writer Removed Successfully", "valid" => 1));
            }
            else
                echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
        }
    }

    

}
