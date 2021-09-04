<?php
/**!
 * @core library
 * @author mrprotocoll
 * @version 1.0.3
 * @since 2/2/2020
 * @modified 02/06/2021
 *
 */
namespace server\core;
use Exception;

class Core{

   protected static $conn;
   public $xdate,$table,$token,$id,$link,$type,$password,$deleted = "view_status";
   public object $tables;
   function __construct($table="", $id = "entity_guid"){
      self::$conn    = Model::conn();
      $this->xdate   = time();
      $this->token   = bin2hex(openssl_random_pseudo_bytes(50));
      if(!empty($table)){
         $this->table   = $table;
         $this->id      = $id;
      }
      $this->tables = (object) \server\enum\Tables::KEYS;
   }

    /**
     * Log login event
     */
    public function loginLog(){
        $sql = "INSERT INTO {$this->tables->loginLog} (`entity_guid`,`user`,`description`,`act_by`,`act_date`) VALUES (uuid(),'$this->user','$this->note','$this->guid','$this->xdate')";
        // echo $sql;exit;
        return self::$conn->query($sql);
    }

    public function eventLog($user){
      $sql = "INSERT INTO {$this->tables->event_log} (`entity_guid`,`user`, `description`,`act_by`,`act_date`,`link`) VALUES
      (uuid(), '$user','$this->note','$this->guid','$this->xdate','$this->link')";
//         echo $sql;exit;
      return self::$conn->query($sql);
    }

    public function genLog($user,$to){
      $sql = "INSERT INTO {$this->tables->genLog} (`entity_guid`,`user`, `description`,`act_by`,`act_to`,`act_date`,`link`,`event_type`) VALUES
      (uuid(), '$user','$this->note','$this->guid','$to','$this->xdate','$this->link','$this->type')";
//         echo $sql;exit;
      return self::$conn->query($sql);
  }

   public static function treat($data){
      $data = self::post($data);
      $data = self::$conn->real_escape_string(trim($data));
      $data = htmlspecialchars($data);
      return $data;
   }

   public function userComment($id) {
      $data = new Validation();
      try{
         $sql = "INSERT INTO {$this->tables->comment} (`entity_guid`,`task`,`description`,`act_date`,`act_by`) VALUES (uuid(),'$data->id','$data->description','$data->xdate','$id')";
         // echo $sql;
         return Self::$conn->query($sql);
      }
      catch(\Exception $e){
         return "Failed to insert correction: ".$e->getMessage();
      };
   }

   public static function cleanse($data){
      $data = self::$conn->real_escape_string(trim($data));
      $data = htmlspecialchars($data);
      return $data;
   }

   public static function post($key){
        if(array_key_exists($key,$_POST))
            return $_POST[$key];
   }

   public static function escape($data){
      $data = self::post($data);
      $data = self::$conn->real_escape_string(trim($data));
      return $data;
   }
   
   public static function treatFile($data){
      $data=str_replace("/", "_", $data);
      return $data;
   }

    public function getAsOption($num = false){
        $sql = "SELECT `name`,entity_guid FROM {$this->table} WHERE {$this->deleted} = 0 AND status != 2 AND activated = 1";
        return ($num) ? $this->getNumRows($sql) : $this->fetchAll($sql);
    }

   /**
   * get config
   *
   * @return object
   */
   public static function config(){
      $sql = "SELECT * FROM system_user_config";
      return mysqli_fetch_object(self::$conn->query($sql));
   }
  
   public static function saveContact(){
      $data = new Validation();
      $sql = "INSERT INTO contacts (entity_guid,`email`,`name`,`subject`,`message`,`act_date`) VALUES (uuid(),'$data->email','$data->fullname','$data->column','$data->title','$data->xdate')";
      // echo $sql;
      return self::$conn->query($sql);
   }

   // add entity_guid values to table
   public static function addGuid($table){
       $sql = "UPDATE {$table} SET entity_guid = uuid()";
       // echo $sql;
       return self::$conn->query($sql);
   }

    public function changeStatus($id,$status){
        $sql = "UPDATE {$this->table} SET `status` = '$status' WHERE {$this->id} = '$id'";
        // echo $sql;
        return self::$conn->query($sql);
    }

   public static function subscribe(){
      $data = new Validation();
      $sql = "INSERT INTO subscriptions (entity_guid,`email`,`act_date`) VALUES (uuid(),'$data->email','$data->xdate')";
      return self::$conn->query($sql);
   }
   
   //get number of rows 
   public function getNumRows($sql){
      $query = self::$conn->query($sql);
      if (!$query) {
         trigger_error('Invalid query: ' . self::$conn->error);
     }
   //   echo $sql;
      return $query->num_rows;
   }
   
   /**
    * fetch record from db
    *
    * @param string $sql
    * @return object|string
    */
   public function fetchAll($sql){
         
      try{
         $all = array();
         $ex = self::$conn->query($sql);
         if (!$ex) {
            trigger_error('Invalid query: ' . self::$conn->error);
            exit;
         }
         if($ex->num_rows > 0){
            while($row = mysqli_fetch_object($ex)){
               $all[] = $row;
            }   
            return $all; 
         }else{
            return $ex->num_rows;
         }
         
      }catch(Exception $e){
         echo "ERROR : ".$e->getMessage(). " ON LINE".$e->getLine(). "FILENAME IS".$e->getFile();
      }
   }

   /**
     * get all data from table
     *
     * @return void
     */
      public function getAll($id=null){
         if(isset($id)){
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id} = '$id' and  {$this->deleted} = 0 ORDER BY act_date DESC";
         }else{
            $sql = "SELECT * FROM $this->table WHERE {$this->deleted} = 0 ORDER BY act_date DESC";
         }
         //  echo $sql;
         return $this->fetchAll($sql);
      } 

      /**
       * gets the number of records in table
      *
      * @return void
      */
      public function getNumOfRows($id=null){
         if(is_null($id)){
            $sql = "SELECT * FROM $this->table WHERE {$this->deleted} = 0"; 
         }else{
            $sql = "SELECT * FROM $this->table WHERE {$this->deleted} = 0 AND $this->id = '$id'"; 
         }
         $q = self::$conn->query($sql);
         return $q->num_rows;
      }

   /**
    * get a perticular info by its id
    *
    * @param [type] $id
    */
   public function getById($id,$return="obj") {
      $sql = "SELECT * FROM {$this->table} WHERE {$this->id} = '$id'";
      // echo $sql;
      $ex = self::$conn->query($sql);
      if($ex->num_rows > 0){
         return ($return == "obj") ? mysqli_fetch_object($ex) : mysqli_fetch_assoc($ex) ;
      }else{
         return $ex->num_rows;
      }
       
   } 

   /**
    * gets entity_guid based on the specified column value
    *
    * @param attribute $colName
    * @param string $val
    * @return entity_guid
    */
   public function getGuid($colName,$val) : string{
      $val = ltrim(rtrim($val));
      $sql = "SELECT entity_guid FROM {$this->table} WHERE {$colName} = '$val'";
//      echo $sql;
      $ex = self::$conn->query($sql);
      if(mysqli_num_rows($ex) > 0)
        return mysqli_fetch_object($ex)->entity_guid;
      else
          return '';
   } 

   /**
    * Authenticate User
    *
    * @return object|bool
    */
   public function auth(){
      $data = new Validation();
      $sql = "SELECT * FROM {$this->table} WHERE (`email` = '$data->email' OR `username` = '$data->email') AND `password` = '$data->password' AND {$this->deleted} = 0 AND `status` = 1";
      // echo $sql;
      $ex = mysqli_query(self::$conn,$sql);
      if(mysqli_num_rows($ex) > 0)
         return (object)['data' => mysqli_fetch_object($ex),'true' => true];
      else
         return (object)['true' => false];
   }

   /**
    * get all records by id
    *
    * @param [type] $id
    * @return void
    */
    public function getAllById($id){  
      $sql = "SELECT * FROM {$this->table} WHERE {$this->id} = '$id' and  {$this->deleted} = 0 ORDER BY act_date DESC"; 
      // echo $sql;
      return $this->fetchAll($sql); 
   }

   /**
    * delete record with the specified id
    *
    * @param [type] $id
    * @return void
    */
   public function deleteRecord($id,$user){ 

      $sql = "UPDATE {$this->table} SET {$this->deleted} = 1, delete_by = '$user', delete_date = '$this->xdate' WHERE {$this->id} = '$id'"; 
      // echo $sql;exit;
      return self::$conn->query($sql);
   }

    /**
    * fetch all record based on a column or column and id
    *
    * @param string $column
    * @param [type] $value
    * @param int $id
    * specifiy id to fetch based on column and id
    * @return void
    */
    public function getAllByColumn($value,$column= "",$id=""){
         
      if(empty($column)){
         $sql = "SELECT * from {$this->table} WHERE {$this->id} = '$value' and  {$this->deleted} = 0";
      }else{
        $sql = "SELECT * from {$this->table} WHERE {$column} = '$value' and {$this->id} = '$id' and  {$this->deleted} = 0 ";
      }

      return $this->fetchAll($sql);
     
   }
   /**
    * fetch a single record based on a column or column and id
    *
    * @param string $column
    * @param [type] $value
    * @param int $id
    * specifiy id to fetch based on column and id
    * @return object|string
    */
    public function getByColumn($value,$column,$id=""){
         
      if(empty($id)){
         $sql = "SELECT * from {$this->table} WHERE {$column} = '$value' and  {$this->deleted} = 0";
      }else{
        $sql = "SELECT * from {$this->table} WHERE {$column} = '$value' and {$this->id} = '$id' and  {$this->deleted} = 0 ";
      }
      // echo $sql;
      $ex = mysqli_query(self::$conn,$sql);
      if(mysqli_num_rows($ex) > 0)
         return mysqli_fetch_object($ex);
      else
         return 0;
   }

    /**
    * cheks if a record already exist,
    * @param [type] $column target column
    * @param [type] $value target value of column
    * @param [type] $id 
    * optional parameter, only specified if you want to query for column and id
    * @return boolean
    */
    public function isExist($column,$value,$id = null){
      if(empty($id)){
         $sql = "SELECT id from {$this->table} WHERE {$column} = '$value' and  {$this->deleted} = 0";
      }else{
        $sql = "SELECT id from {$this->table} WHERE {$column} = '$value' and {$this->id} = '$id' and  {$this->deleted} = 0 ";
      }
      // echo $sql;
      return $this->getNumRows($sql) > 0 ? true : false;
      
   }

      /**
    * display select options for a record
    *
    * @param atrribute $column column to display to users
    * @param id $idd specify id if you are editing
    * @return void
    */
    public function selectOptions($column,$idd=null){
      
      $sql = "SELECT * FROM $this->table WHERE {$this->deleted} = 0 ORDER BY $column ASC";
      $run = $this->fetchAll($sql); 
      // show all records in the selected database
      if(is_array($run)){
         foreach($run as $row){
            $name = $row->{$column};
            $id = $row->{$this->id}; 
            if(!is_null($idd)){
               ?>
            <option value='<?php echo $id ?>' <?php echo ($id == $idd) ? 'selected' : ''; ?> > <?php echo $name; ?></option>
            <?php
            }else{
               ?>
               <option value='<?php echo $id ?>'> <?php echo $name; ?></option>
               <?php
            }
            
         }
      }else{
         ?>
            <option value=''>No Record</option>
         <?php
      }
      

   }

   /**
    * displays input select options by col $colName
    *
    * @param string $column column to display to user
    * @param string $colName additional where clause column name
    * @param string $val additional where clause column value
    * @param string $idd optional
    * used for editing
    * @return void
    */
   public function selectOptionsById($column,$colName,$val,$idd=null){
      
      $sql = "SELECT * FROM $this->table WHERE {$this->deleted} = 0 AND {$colName} = '$val' ORDER BY $column ASC";
      $run = $this->fetchAll($sql); 
      // show all records in the selected database
      foreach($run as $row){
         $name = $row->$column;
         $id = $row->$this->id; 

         if(!is_null($idd)){
            ?>
         <option value='<?php echo $id ?>' <?php echo ($id == $idd) ? 'selected' : ''; ?> > <?php echo $name; ?></option>
         <?php
         }else{
            ?>
            <option value='<?php echo $id ?>'> <?php echo $name; ?></option>
            <?php
         }
         
         }

   }

   public function sqlOptions($sql,$column,$idd=""){
      $run = $this->fetchAll($sql); 
      // show all records in the selected database
      foreach($run as $row){
         $name = $row->$column;
         $id = $row->$this->id; 

         if(!empty($idd)){
            ?>
         <option value="<?php echo $id ?>" <?php echo ($id == $idd) ? "selected" : ""; ?> > <?php echo $name; ?></option>
         <?php
         }else{
            ?>
            <option value="<?php echo $id ?>"> <?php echo $name; ?></option>
            <?php
         }
         
         }

   }

  /**
   * get customer's city
   *
   * @return void
   */
  public function city(){
      $sql = "SELECT `name` FROM cities WHERE id = '$this->city'";
      return mysqli_fetch_assoc(self::$conn->query($sql))['name'];
  }

   /**
    * get cities based on user's country
    *
    * @param id $country
    * @return void
    */
   public function getCities($country){
      $sql = "SELECT * FROM cities WHERE country_id = '$country'";
      return $this->fetchAll($sql);
   }

   /**
    * function to change password
    *
    * @return void
    */
    public function changePass($id=""){
      $data = new Validation();
      if(empty($id)){
         $sql = "UPDATE {$this->table} SET `password` = '$data->password', `session_token` = '$data->token' WHERE {$this->id} = '$this->guid'";
      }else{
         $sql = "UPDATE {$this->table} SET `password` = '$data->password', `session_token` = '$data->token' WHERE  {$this->id} = '$id'";
      }
      return self::$conn->query($sql);
   }

   
}

$core = new Core();
