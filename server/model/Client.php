<?php
namespace server\model;

use server\core\Helper;

class Client extends User{
    public $table = "customers",$id = "entity_guid", $user = "client",$pre = "CLT",$project;
    function __construct(){
        Parent::__construct();
        $this->project = $this->data->project ?? 0;
        $this->code    = "";
    }
}