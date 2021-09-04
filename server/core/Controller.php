<?php
/**
 * DO NOT MODIFY THIS FILE WITHOUT THE DEVELOPER's CONCENT
 * DEVELOPER: github => mrprotocoll
 */
namespace server\core;

use Error;
use Exception;
abstract class Controller{

   public static function route(array $url){
      $action = $url;
      if(count($action) > 1){
         $controller = $action[0]; $method = $action[1];
      }
      else{
         throw new \Exception("Route not Correctly formed : ".implode("/",$url));
      }
      $ns = 'server\controller\\';
      $method = Helper::treatCtrlAction($method);
      $class = $ns.Helper::convertToClassCaps(trim($controller));
      if(class_exists($class)){
         $controller_obj = new $class();
         if (is_callable([$controller_obj, $method]))
            if(isset($action[2])) $controller_obj->$method($action[2]);
            else {
               try{
                  $controller_obj->$method();
               }catch(Exception $e){
                  $errormsg = (Config::$SHOW_ERROR) ? $e->getMessage().$e->getTraceAsString() : "";
                  echo json_encode(array("message" => "Exception: Failed, Try Again ".$errormsg, "valid" => 0));
               }catch(Error $e){
                  $errormsg = (Config::$SHOW_ERROR) ? $e->getMessage().$e->getTraceAsString() : "";
                  echo json_encode(array("message" => "Error: Failed, Try Again ".$errormsg, "valid" => 0));
               }
            }
         else{
            echo json_encode(array("valid" => "0", "message" => "MOops!!: Error Occurred"));
         }
      }else {
         // throw new \Exception("Class $class is not found");
         echo json_encode(array("valid" => "0", "message" => "Coops!!: Error Occured"));
      }
      //    else echo json_encode(array("valid" => "0", "message" => 'MOops!!'));
      // }else echo json_encode(array("valid" => "0", "message" => 'Coops!!'));
   }
}




