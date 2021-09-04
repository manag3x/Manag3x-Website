<?php
namespace server\core;

class Error{
     
   /**
    * Handles all errors
    *
    * @param [type] $level
    * @param string $message the error message
    * @param string $file The file where error is thrown
    * @param int $line The line on the file
    * @return void
    */
   public static function errorHandler($level,$message,$file,$line){
      if(error_reporting() !== 0){
         throw new \ErrorException($message,0,$level,$file,$line);
      }
   }

   /**
    * Exception Handler
    *
    * @param Exception $e the exception
    * @return void
    */
   public static function exceptionHandler($e){
      $code = $e->getCode();
      http_response_code($code);
      if(Config::$SHOW_ERROR){
         ?>
            <h3>Fatal Error</h3>
            <span>Uncaught Exception: <?php echo get_class($e) ?></span><br>
            <span>Exception Message:  <?php echo $e->getMessage() ?></span><br>
            <span>Stach Trace: <pre><?php echo $e->getTraceAsString() ?></pre></span><br>
            <span>Thrown in: <?php echo $e->getFile(); ?></span><br>
            <span>Line: <?php echo $e->getLine(); ?></span>
         <?php
      }else{
         $log_file = dirname(__DIR__)."/log/".date("Y-m-d").".txt";
         // echo $log_file; exit;
         ini_set("error_log",$log_file);
         $error = "Uncaught Exception: '". get_class($e) ."'";
         $error .= " with Message: ". $e->getMessage();
         $error .= "\nStack trace: ". $e->getTraceAsString();
         $error .= "\nThrown in: ". $e->getFile(). " on line ". $e->getLine();
         error_log($error);
         // View::render("error",["error",
         //    "page_title" => 'Page not Found - Error 404',
         //    "page_view" => "error_view",
         //    "css" => ["pages/error/style-400"],
         //    "body_class" => "error404 text-center",
         //    "core_script" => false,
         //    "page_type" => "error",
         //    // "error_root" => "admin/",
         //    "error_code" => $code ?? "404",
         //    // "page_root" => "admin/",
         // ]);
      }
   }

}