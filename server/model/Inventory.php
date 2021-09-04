<?php
namespace server\model;
use server\core\{Core,Validation};
class Inventory extends Core{

    public $table = "inventory",$id = "entity_guid";
    public $guid,$note,$data;
    function __construct(){
        Parent::__construct();
    }
    
    /**
     * add new Record
     *
     * @return bool
     */
    public function create($data){

        $cat = implode(", ",$data->category);
        $lim = implode(", ",$data->limit);
        $sql = "INSERT INTO {$this->table} (`entity_guid`,`dr`,`email`,`outreach`,`url`,`traffic`,`amount`,`country`,`note`,`user`,`currency`,`category`,`constraint`,`act_date`,`act_by`) VALUES (uuid(),'$data->dr','$data->email','$data->outreach','$data->link','$data->traffic','$data->amount','$data->country','$data->description','$data->user','$data->currency','$cat','$lim','$data->xdate','$this->guid')";
        // echo $sql;
        if(Parent::$conn->query($sql)){
            $last = $this->getGuid("id",mysqli_insert_id(parent::$conn));
            // add categories
            if(count($data->category) > 0){
                foreach ($data->category as $cat){
                    if(!empty($cat)){
                        $sql = "INSERT INTO {$this->tables->webCat} (`entity_guid`,`website`,`category`,`act_date`) VALUES (uuid(),'$last','$cat', '$data->xdate')";
                        Parent::$conn->query($sql);
                    }
                }
            }

            //add constraints
            if(count($data->limit) > 0) {
                foreach ($data->limit as $limit) {
                    $sql = "INSERT INTO {$this->tables->constraint} (`entity_guid`,`website`,`constraint`,`act_date`) VALUES (uuid(),'$last','$limit','$data->xdate')";
                    Parent::$conn->query($sql);
                }
            }  
            return true;
        }
        return false;
    }

    public function getAll($archive = 0,$num = false)
    {
        $sql = "SELECT *,i.email, c.name AS symbol,i.act_by AS user_guid, i.act_date AS act_date, i.entity_guid AS entity_guid,p.name AS publisher FROM {$this->table} i LEFT JOIN {$this->tables->currency} c ON  c.entity_guid = i.currency LEFT JOIN {$this->tables->publisher} p ON  p.entity_guid = i.act_by WHERE i.$this->deleted = 0 AND i.archived = '$archive' ORDER BY i.act_date DESC";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

    public function getRecommended($client,$num = false)
    {
        $sql = "SELECT *,c.name AS symbol,i.entity_guid AS inv_id,i.url, ci.entity_guid AS _guid, ci.status AS _status, ci.act_date FROM {$this->tables->cInventory} ci LEFT JOIN {$this->table} i ON i.entity_guid = ci.website LEFT JOIN {$this->tables->currency} c ON  c.entity_guid = i.currency WHERE ci.$this->deleted = 0 AND ci.client = '$client' AND ci.status != 6 ORDER BY ci.act_date DESC "; 
        // echo $sql;
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

    public function getRecommendedByStatus($status, $num = false)
    {
        $client = new Client();
        $sql = "SELECT *,i.entity_guid AS inv_id, ci.entity_guid AS _guid, ci.status AS _status, ci.act_date AS _date FROM {$this->tables->cInventory} ci LEFT JOIN {$this->table} i ON i.entity_guid = ci.website WHERE ci.$this->deleted = 0 AND ci.client = '$client->guid' AND ci.status = '$status' ORDER BY ci.act_date DESC ";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

    public function getSaved($num = false)
    {
        $client = new Client();
        $sql = "SELECT *,i.entity_guid AS inv_id, ci.entity_guid AS _guid, ci.status AS _status, ci.act_date AS _date FROM {$this->tables->cInventory} ci LEFT JOIN {$this->table} i ON i.entity_guid = ci.website WHERE ci.$this->deleted = 0 AND ci.client = '$client->guid' AND ci.status != 6 AND ci.save = 1 ORDER BY ci.act_date DESC ";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

    /**
     * get inventory by id
     * @param $id
     * @return false|int|object|null
     */
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->deleted} = 0 AND $this->id = '$id'";
        $ex = Parent::$conn->query($sql);
        if($ex->num_rows > 0){
            return mysqli_fetch_object($ex);
        }else{
            return 0;
        }
    }

    /**
     * get inventory by url
     * @param $id
     * @return false|int|object|null
     */
    public function getByUrl($url)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->deleted} = 0 AND `url` = '$url'";
        $ex = Parent::$conn->query($sql);
        if($ex->num_rows > 0){
            return mysqli_fetch_object($ex);
        }else{
            return 0;
        }
    }

    public function getAsOption($num = false)
    {
        $sql = "SELECT url AS name,entity_guid FROM {$this->table} WHERE {$this->deleted} = 0 AND archived = 0 ";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

    // get websites for this week
    public function thisWeek()
    {
        $monday = strtotime('next Monday -1 week');
        $monday = date('w', $monday) == date('w') ? strtotime(date("Y-m-d", $monday) . " +7 days") : $monday;

        $sql = "SELECT url FROM {$this->table} WHERE {$this->deleted} = 0 AND archived = 0 AND act_date > '$monday'";
        return $this->getNumRows($sql);
    }

    /**
     * get inventory categories by id
     * @param $id
     * @return false|int|object|null
     */
    public function getCategories($id,$loop = true)
    {
        $sql = "SELECT c.name,w.entity_guid AS cat_id,w.category FROM {$this->tables->webCat} w LEFT JOIN {$this->tables->cat} c ON w.category = c.entity_guid WHERE w.$this->deleted = 0 AND `website` = '$id'";
    //    echo $sql;
        $data = $this->fetchAll($sql);
        if($loop){
            return is_array($data) ? $data : [];
        }else{
            return "";
        }
    }

    /**
     * get a website constraints
     * @param $id
     * @return false|int|object|null
     */
    public function getConstraints($id,$loop = true)
    {
        $sql = "SELECT c.name,w.entity_guid AS cat_id,c.entity_guid AS category FROM {$this->tables->constraint} w LEFT JOIN {$this->tables->web_limit} c ON w.constraint = c.entity_guid WHERE w.$this->deleted = 0 AND `website` = '$id'";
        $data = $this->fetchAll($sql);
    //    echo $sql;
        if($loop){
            return $data;
        }else{
            return "";
        }
    }

    /**
     * Update Record Based on identity
     *
     * @param data
     */
    public function update($data){
        $cat = implode(", ",$data->category);
        $lim = implode(", ",$data->limit);
        $sql = "UPDATE {$this->table} SET `dr` = '$data->dr',`email` = '$data->email',`outreach` = '$data->outreach',`url` = '$data->link',
        `traffic` = '$data->traffic',`amount` = '$data->amount', `country` = '$data->country',`note` = '$data->description',
        `user` = '$data->user',`currency` = '$data->currency', `category` = '$cat',`constraint` = '$lim',`updated_at` = '$data->xdate',`updated_by` = '$this->guid' WHERE {$this->id} = '$data->id'";
            // echo $sql;exit;

        if(Parent::$conn->query($sql)){
            // add categories
            if(count($data->category) > 0){
                $sql = "DELETE FROM {$this->tables->webCat} WHERE website = '$data->id'";
                if(Parent::$conn->query($sql)){
                    foreach ($data->category as $cat){
                        $sql = "INSERT INTO {$this->tables->webCat} (`entity_guid`,`website`,`category`,`act_date`) VALUES (uuid(),'$data->id','$cat', '$data->xdate')";
                        Parent::$conn->query($sql);
                    }
                }
            }

            //add constraints
            if(count($data->limit) > 0){
                $sql = "DELETE FROM {$this->tables->constraint} WHERE website = '$data->id'";
                if(Parent::$conn->query($sql)) {
                    foreach ($data->limit as $limit) {
                        $sql = "INSERT INTO {$this->tables->constraint} (`entity_guid`,`website`,`constraint`,`act_date`) VALUES (uuid(),'$data->id','$limit','$data->xdate')";
                        Parent::$conn->query($sql);
                    }
                }
            }
            return true;
        }
    return false;
    }

    /**
     * archieve website
     *
     * @param [type] $id
     * @return void
     */
    public function archive($id){
        $sql = "UPDATE {$this->table}  SET `archived` = 1 WHERE {$this->id} = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * archieve website by url
     *
     * @param [type] $id
     * @return void
     */
    public function archiveByUrl($id){
        $sql = "UPDATE {$this->table}  SET `archived` = 1 WHERE `url` = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * reject website
     *
     * @param [type] $id
     * @return void
     */
    public function reject($id){
        $sql = "UPDATE {$this->tables->cInventory}  SET `status` = 6 WHERE {$this->id} = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * save website
     *
     * @param [type] $id
     * @return void
     */
    public function save($id){
        $sql = "UPDATE {$this->tables->cInventory}  SET `save` = 1 WHERE {$this->id} = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * restore archieved website
     *
     * @param [type] $id
     * @return void
     */
    public function restore($id){
        $sql = "UPDATE {$this->table}  SET `archived` = 0 WHERE {$this->id} = '$id'";
        // echo $sql;exit;
        return Parent::$conn->query($sql);
    }

    /**
     * Add to client inventory
     */
    public function sendToClient($website){
        $data = new Validation();
        $admin = new \server\model\Admin();
        $sql = "INSERT INTO {$this->tables->cInventory} (`entity_guid`,`website`,`client`,`act_date`,`act_by`,`status`) VALUES (uuid(),'$website','$data->fullname', '$data->xdate', '$admin->guid',7)";
        return Parent::$conn->query($sql);
    }

    public function filter(array $equal,array $g,array $l){
        $content = "";
        $content .= $this->equalFilter($equal);
        $content .= $this->lFilter($l);
        $content .= $this->gFilter($g);
        $sql = "SELECT * FROM {$this->table} WHERE  {$this->deleted} = 0 AND archived = 0 $content ORDER BY `act_date` DESC";
        // echo $sql;exit;
        return $this->fetchAll($sql);
    }

    /**
     * filter for equal to
     * @param array $data
     * @return string
     */
    // function equalFilter(array $data = []){
    //     $content = "";
    //     if(count($data) > 0){
    //         $x = 0;$f = "OR";$b = "";
    //         foreach ($data as $key => $val){
    //             if(!empty($val)){
    //                 if($x == 0 or $x == (count($data) - 1))
    //                     $f = ""; $b="OR";
    //                 $content .= "$f {$key} LIKE '%$val%' $b";
    //             }
    //             $x++;
    //         }
    //     }
    //     // echo $content;
    //     return $content;
    // }
    function equalFilter(array $data = []){
        $content = "";
        if(count($data) > 0){
            foreach ($data as $key => $val){
                if(!empty($val)){
                    $content .= "AND {$key} LIKE '%$val%'";
                }
            }
        }
        // echo $content;
        return $content;
    }

    /**
     * filter for greater than
     * @param array $data
     * @return string
     */
    function gFilter(array $data = []){
        $content = "";
        if(count($data) > 0){
            foreach ($data as $key => $val) {
                if (!empty($val))
                    $content .= " AND {$key} > '$val'";
            }
        }
        return $content;
    }

    /**
     * filter for less than
     * @param array $data
     * @return string
     */
    function lFilter(array $data = []){
        $content = "";
        if(count($data) > 0){
            foreach ($data as $key => $val) {
                if (!empty($val))
                    $content .= " AND {$key} < '$val'";
            }
        }
        return $content;
    }

    /**
     * check if website exist and is active
     * @param $url
     * @return bool
     */
    public function exist($url){
        $sql = "SELECT * from {$this->table} WHERE `url` = '$url' AND `archived` = 0 AND  {$this->deleted} = 0 ";
        return $this->getNumRows($sql) > 0 ? true : false;
    }
}
?>