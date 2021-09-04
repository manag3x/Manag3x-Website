<?php
namespace server\controller;
use server\core\{Core,Validation,EventLogger};
// use server\controller\admin\Inventory;
use server\model\Message;
use server\model\Order;
use server\model\Settings;

class Custom {
    public $user,$password,$core,$data,$service;
    public function __construct(){
        $this->data = new Validation;
        $this->core = new Core();
    }

    public function getdata($table){
        $data = (new Core($table))->getAll();
        echo json_encode($data);
    }
    
    public function getbyid($table){
        $data = (new Core($table))->getById($this->data->id);
        echo json_encode($data);
    }

    // get notifications
    public function getnotifications($id){
        $data = (new Core($this->core->tables->genLog,"act_to"))->getAllById($id);
        echo json_encode($data);
    }

    // get notifications
    public function markasread(){
        $data = (new Message)->markNotificationAsRead($this->data->id);
        echo ($data) ? json_encode(1) : json_encode(0);
    }

    public function getloginlog(){
        $class = new Settings();
        $data = $class->getLoginLogs($this->data->id);
        echo json_encode($data);
    }

    // get recent orders
    public function recenttask(){
        $data = (new Order)->recentOrders();
        echo json_encode($data);
    }

    // change status generally
    public function change_status($table){
        $data = (new Core($table))->changeStatus($this->data->id,$this->data->status);
        echo ($data) ? json_encode(array("message" => "Status Changed Successfully", "valid" => 1)) : json_encode(array("message" => "Failed, Try Again", "valid" => 0));
    }

    // create basic information
    public function create($table){
        if(empty($this->data->fullname))
            echo json_encode(array("message" => "All fields except description are Required", "valid" => 0));
        elseif((new Core($table))->isExist("name",$this->data->fullname)){
            echo json_encode(array("message" => "{$this->data->fullname} Already Exist", "valid" => 0));
        }
        elseif(Settings::create($tabl)){
            EventLogger::log(0,"create","new [{$this->data->id}] with name [{$this->data->fullname}]");
            echo json_encode(array("message" => "{$this->data->fullname} Added Successfully", "valid" => 1));
        }else
            echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
    }

    // update basic information
    public function update($table){
        $class = new Settings();
        if(empty($this->data->fullname))
            echo json_encode(array("message" => "All fields except description are Required", "valid" => 0));
        elseif($class->update($table)){
            EventLogger::log(0,"update","[{$this->data->title}] with name [{$this->data->fullname}]");
            echo json_encode(array("message" => "{$this->data->title} Updated Successfully", "valid" => 1));
        }else
            echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
    }

}

?>