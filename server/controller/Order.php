<?php
namespace server\controller;
use server\core\{Core,EventLogger,Validation,Mail};

class Order {
	public $users,$class,$order,$data,$enumUser,$code;
	public function __construct(){
        $this->data = new Validation();
        $this->order = new \server\model\Order;
	}

    public function getbystatus($status = 0){
        $data = $this->order->getByStatus($status);
        echo json_encode($data);
    }

    public function filter(){
        $data = $this->order->getByStatus($this->data->id);
        echo json_encode($data);
    }

    public function getall(){
        $data = $this->order->getAllOrders();
        echo json_encode($data);
    }

    
    // create new Task
    public function create(){
        $data = $this->data;
        $data->user = $this->enumUser;
        $this->order->status = (empty($data->writer) and empty($data->editor)) ? 0 : 3;
        $this->order->guid = $this->class->guid;
        if(empty($data->fullname) or empty($data->link))
            echo json_encode(array("message" => "Client and Publisher Website are Required", "valid" => 0));
        elseif(count($data->limit) == 0)
            echo json_encode(array("message" => "Atleast One Promoted Url is Required", "valid" => 0));
        else{
            if($this->order->create($data)){
                if($this->enumUser == 0)
                    EventLogger::log(0,"create","a new Website to the Website order with URL: {$data->link}");
                echo json_encode(array("message" => "Website Added Successfully", "valid" => 1));
            }
            else
                echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
        }
    }

}
