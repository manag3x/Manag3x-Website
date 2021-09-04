<?php
namespace server\core;
use mysqli;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * overall model class which all models extends.
 * it contains the connections to databse and other database functions
 */
abstract class Model{

   public static function conn() {
      $db = null;
      if($db === null){
         $data = (new Config())->dbParam();
         try{
            $db = new mysqli($data->host,$data->user,$data->pass,$data->db);
            // var_dump(self::$db);
            return $db;
         }catch(\Exception $e){
            echo $e->getMessage();
         }
      }
   }
}