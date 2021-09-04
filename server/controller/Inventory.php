<?php
namespace server\controller;
use server\core\{Core,Config,Helper,EventLogger,Validation};
use server\model\Inventory as ModelInventory;
use server\model\PublisherInventory;

class Inventory {
	public $user,$class,$enumUser,$data,$inventory;
	public function __construct(){
        $this->data = new Validation();
        $this->inventory = new ModelInventory();
	}

    // get all inventory
    public function getall(){
        $data = $this->inventory->getAll();
        echo json_encode($data);
    }

    //get inventory by id
    public function get(){
        $src  = array();
        $data = $this->inventory->get($this->data->id);
        echo json_encode($data);
    }  

    
}
