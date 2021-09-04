<?php
namespace server\model;
use server\core\{Core,Helper,Validation,Mail,EventLogger};
class Order extends Core{

    public $table = "orders",$id = "entity_guid";
    public $guid,$status;
    function __construct(){
        Parent::__construct();
    }

    /**
     * add new Record
     *
     * @return bool
     */
    public function create($data){
        $code = Helper::genRand(7,"TSK");
        $data->file = empty($data->file) ? 0 : 1;
        $sql = "INSERT INTO {$this->table} (`entity_guid`,`client`,`writer`,`editor`,`url`,`due_date`,`note`,`user`,`act_date`,`act_by`,`status`,`code`,`document`,`content_upload`) VALUES (uuid(),'$data->fullname','$data->writer','$data->editor','$data->link','$data->traffic','$data->description','$data->user','$data->xdate','$this->guid','$this->status','$code','$data->doc','$data->file')";
        // echo $sql;
        if(Parent::$conn->query($sql)){
            $last = $this->getGuid("id",mysqli_insert_id(parent::$conn));
            
            //add promoted url
            if(count($data->limit) > 0) {
                for ($x = 0; $x < count($data->limit); $x++) {
                    $url = $data->limit[$x];
                    $anchor = $data->checkAll[$x];
                    if(!empty($data->limit[$x])){
                        $sql = "INSERT INTO {$this->tables->purl} (`entity_guid`,`task`,`url`,`anchor`,`act_date`) VALUES (uuid(),'$last','$url','$anchor','$data->xdate')";
                        Parent::$conn->query($sql);
                    }
                }
            }

            // add content
            if(count($data->ctitle) > 0){
                for ($x = 0; $x < count($data->ctitle); $x++) {
                    $code = Helper::genRand(9,"CNT");
                    $cat = $data->category[$x] ?? "";
                    $title = $data->ctitle[$x] ?? "";
                    $desc = $data->cdesc[$x] ?? "";
                    $word_count = $data->word[$x] ?? "";
                    $keyword = $data->keyword[$x] ?? "";
                    if(!empty($title)) {
                        $sql = "INSERT INTO {$this->tables->content} (`entity_guid`,`code`,`client`,`task`,`title`,`word_count`,`description`,`category`,`keywords`,`doc`,`act_date`) VALUES (uuid(),'$code','$data->fullname','$last','$title','$word_count','$desc','$cat','$keyword','$data->doc','$data->xdate')";
                        // echo $sql;
                        Parent::$conn->query($sql);

                    }
                }
            }
            // SEND MAIL TO CLIENT AND ADMIN
            $client = new Client();  
            $orderID = $this->getById($last)->code;
            $mail = new Mail($client->email,$client->name);      //send email
            $mail->order("Campaign",$orderID);
            // notify admin
            $amail = new Mail();      //send email to admin
            $amail->orderAdmin("Campaign",$client->email,$client->name,$orderID);
            EventLogger::log(0,"create","a new task with ID: {$orderID}");
            return true;
        }
        return false;
    }

    /**
     * add new Record
     *
     * @return bool
     */
    public function orderContent($data){
        $code = Helper::genRand(7,"TSK");
        $sql = "INSERT INTO {$this->table} (`entity_guid`,`client`,`user`,`act_date`,`act_by`,`status`,`code`,`type`) VALUES (uuid(),'$data->fullname','$data->user','$data->xdate','$this->guid',0,'$code',1)";
        
        if(Parent::$conn->query($sql)){
            $last = $this->getGuid("id",mysqli_insert_id(parent::$conn));

            // add content
            if(count($data->ctitle) > 0){
                $count = 0;
                for ($x = 0; $x < count($data->ctitle); $x++) {
                    
                    $code = Helper::genRand(9,"CNT");
                    $cat = $data->category[$x] ?? "";
                    $title = $data->ctitle[$x] ?? "";
                    $desc = $data->cdesc[$x] ?? "";
                    $word_count = $data->word[$x] ?? "";
                    $keyword = $data->keyword[$x] ?? "";
                    $amount = $data->camount[$x] ?? "";
                    if(!empty($data->ctitle[$x])) {
                        $sql = "INSERT INTO {$this->tables->content} (`entity_guid`,`code`,`client`,`task`,`title`,`word_count`,`description`,`category`,`amount`,`keywords`,`act_date`) VALUES (uuid(),'$code','$data->fullname','$last','$title','$word_count','$desc','$cat','$amount','$keyword','$data->xdate')";
                        // echo $sql;
                        if(Parent::$conn->query($sql)){
                            $count++;
                        }
                    }
                }
                if($count > 0){
                    // SEND MAIL TO CLIENT AND ADMIN
                    $client = new Client();  
                    $orderID = $this->getById($last)->code;
                    $mail = new Mail($client->email,$client->name);      //send email
                    $mail->order("Content",$orderID);
                    // notify admin
                    $amail = new Mail();      //send email to admin
                    $amail->orderAdmin("Content",$client->email,$client->name,$orderID);

                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param int $status
     * @return array|object|string|void
     */
    public function getByStatus($status){
        $sql = "SELECT t.status AS stat, t.entity_guid AS guid, c.name, t.act_date, w.url, t.code  FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url  WHERE t.$this->deleted = 0 AND t.status = '$status' ORDER BY t.act_date DESC";
        return $this->fetchAll($sql);
    }

    /**
     * @param int $status
     * @return array|object|string|void
     */
    public function clientByStatus($status){
        $client = new Client();
        $sql = "SELECT *,t.status AS stat,con.entity_guid AS conguid,t.type, t.entity_guid AS guid, c.name, t.act_date, w.url, t.code,con.code AS con_code FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url LEFT JOIN {$this->tables->content} con ON con.task = t.entity_guid  WHERE t.$this->deleted = 0 AND t.status = '$status' AND t.client = '$client->guid' ORDER BY t.act_date DESC";
        return $this->fetchAll($sql);
    }

    public function getAllOrders(){
        $sql = "SELECT t.status AS stat, t.entity_guid AS guid, c.name, t.act_date, w.url, t.code  FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url  WHERE t.$this->deleted = 0 ORDER BY t.act_date DESC";
        return $this->fetchAll($sql);
    }
  
    public function getbyClient($num = false){
        $client = new Client();
        $sql = "SELECT *,t.status AS stat,con.entity_guid AS conguid, t.entity_guid AS guid,t.type, c.name, t.act_date, w.url, t.code,con.code AS con_code FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url LEFT JOIN {$this->tables->content} con ON con.task = t.entity_guid WHERE t.$this->deleted = 0 AND t.client = '$client->guid' ORDER BY t.act_date DESC";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    } 

    public function getByUser($id,$num = false){
        $sql = "SELECT t.status AS stat, t.entity_guid AS guid,t.type, c.name, t.act_date, w.url, t.code  FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url  WHERE  t.$this->deleted = 0 AND t.act_by = '$id' ORDER BY t.act_date DESC";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

    // : \Exception|bool
    public function clientComment() {
        $data = new Validation();
        $client = new Client();
        try{
            $sql = "INSERT INTO {$this->tables->comment} (`entity_guid`,`task`,`description`,`act_date`,`act_by`) VALUES (uuid(),'$data->id','$data->description','$data->xdate','$client->guid')";
            // echo $sql;
            return Parent::$conn->query($sql);
        }
        catch(\Exception $e){
            return "Failed to insert correction: ".$e->getMessage();
        };
    }

    /**
     * approve task
     *
     * @param [type] $id
     * @return void
     */
    public function approveTask($id){
        $sql = "UPDATE {$this->table}  SET `status` = 9, `approved` = 1 WHERE {$this->id} = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * approve task
     *
     * @param [type] $id
     * @return void
     */
    public function approveByAdmin($id){
        $sql = "UPDATE {$this->table}  SET `status` = 4, `approved` = 1 WHERE {$this->id} = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    public function recentOrders(){
        $sql = "SELECT t.status AS stat, t.entity_guid AS guid, c.name, t.act_date, w.url, t.code  FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url  WHERE t.$this->deleted = 0 ORDER BY t.act_date DESC LIMIT 6";
        return $this->fetchAll($sql);
    }

    public function getNumByStatus($status){
        $sql = "SELECT id FROM {$this->table}  WHERE $this->deleted = 0 AND status = '$status'";
        return $this->getNumRows($sql);
    }

    public function getNumClientByStatus($status){
        $client = new Client();
        $sql = "SELECT id FROM {$this->table}  WHERE $this->deleted = 0 AND `status` = '$status' AND `client` = '$client->guid'";
        return $this->getNumRows($sql);
    }

    public function getCodeById($id){
        return (new Core($this->table))->getById($id)->code;
    }

    /**
     * get task info by its id
     * @param int $id
     */
    // : object|string
    public function getById($id,$return="obj"){
        $sql = "SELECT t.status AS stat, c.entity_guid AS guid, c.name, t.act_date, w.url, t.code, t.due_date, t.note, wr.name AS writer,e.name AS editor, t.user FROM {$this->table} t LEFT JOIN {$this->tables->customer} c ON c.entity_guid = t.client LEFT JOIN {$this->tables->inventory} w ON w.entity_guid = t.url LEFT JOIN {$this->tables->writer} wr ON wr.entity_guid = t.writer LEFT JOIN {$this->tables->editor} e ON e.entity_guid = t.editor WHERE t.$this->deleted = 0 AND t.entity_guid = '$id' ORDER BY t.act_date DESC";
        // echo $sql;
        $ex = self::$conn->query($sql);
        if($ex->num_rows > 0){
            return ($return == "obj") ? mysqli_fetch_object($ex) : mysqli_fetch_assoc($ex);
        }else{
            return $ex->num_rows;
        }
    }

    /**
     * get order contents
     * @param $id
     * @return false|int|object|null
     */
    public function getContents($id,$loop = true)
    {
        $sql = "SELECT c.name AS category,title,w.description,w.status AS _status, wc.name AS word_count,w.entity_guid AS guid, w.placement_url FROM {$this->tables->content} w LEFT JOIN {$this->tables->cat} c ON w.category = c.entity_guid LEFT JOIN {$this->tables->word} wc ON w.word_count = wc.entity_guid WHERE w.$this->deleted = 0 AND w.task = '$id'";
//        echo $sql;
        $data = $this->fetchAll($sql);
        if ($loop) {
            return $data;
        } else {
            return "";
        }
    }

    /**
     * get order contents
     * @param $id
     * @return false|int|object|null
     */
    public function getUrl($id,$loop = true)
    {
        $sql = "SELECT url,anchor,w.entity_guid AS guid FROM {$this->tables->purl} w WHERE $this->deleted = 0 AND `task` = '$id'";
        $data = $this->fetchAll($sql);
        if ($loop) {
            return $data;
        } else {
            return "";
        }
    }

    // : \mysqli_result|bool
    public function updateContent() {
        $data = new Validation();
        $sql = "UPDATE {$this->tables->content} SET `title` = '$data->title', `word_count` = '$data->fullname',`description` = '$data->description', `category` = '$data->table' WHERE {$this->id} = '$data->id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    // : \mysqli_result|bool
    public function updateBasic() {
        $data = new Validation();
        $sql = "UPDATE {$this->table} SET `url` = '$data->link', `client` = '$data->fullname',`due_date` = '$data->traffic' WHERE {$this->id} = '$data->id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    // : \mysqli_result|bool
    public function updatePurl() {
        $data = new Validation();
        $sql = "UPDATE {$this->tables->purl} SET `url` = '$data->link', `anchor` = '$data->title' WHERE {$this->id} = '$data->id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    // : \mysqli_result|bool
    public function addPurl() {
        $data = new Validation();
        $sql = "INSERT INTO {$this->tables->purl} (`entity_guid`,`task`,`url`,`anchor`,`act_date`,`act_by`) VALUES (uuid(),'$data->id','$data->link','$data->title','$data->xdate','$this->guid')";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    // : \mysqli_result|bool
    public function addContent() {
        $data = new Validation();
        $sql = "INSERT INTO {$this->tables->content} (`entity_guid`,`task`,`title`,`word_count`,`category`,`description`,`act_date`,`act_by`) VALUES (uuid(),'$data->id','$data->title','$data->fullname','$data->table','$data->description','$data->xdate','$this->guid')";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    // : \mysqli_result|bool
    public function assign() {
        $data = new Validation();
        $sql = "UPDATE {$this->tables->content} SET `writer` = '$data->writer', `editor` = '$data->editor',`status` = 3,`assigned_date` = '$data->xdate' WHERE `task` = '$data->id'";
        // echo $sql;exit;
        if(Parent::$conn->query($sql)){
            $sql = "UPDATE {$this->table} SET `writer` = '$data->writer', `editor` = '$data->editor',`note` = '$data->description',`status` = 3 WHERE {$this->id} = '$data->id'";
            // echo $sql;exit;
            return Parent::$conn->query($sql);
        }
    }

}
?>