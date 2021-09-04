<?php
namespace server\controller;
$DIR = "../../../";
use server\core\{Core,Config,EventLogger,Validation,Session,Helper,Mail};
use server\enum\Status;
use server\model\Message;

class Auth {
  public $user,$module,$table,$data,$enumUser,$class,$message;

  public function __construct(){
    $this->data = new Validation;
  }

  public function getall(){
    $data = $this->class->getAll();
    echo json_encode($data);
  }

  //get user by id
  public function get(){
    $data = $this->class->getById($this->data->id);
    echo json_encode($data);
  }

  public function register(){
    if($this->data->isEmpty()->true)
      echo json_encode(array("message" => " All Fields Are Required", "valid" => 0));
    elseif(!$this->data->reg($this->table)->true)
      echo json_encode(array("message" => $this->data->reg($this->table)->msg, "valid" => 0));
    else{
      $user = $this->class;
      $create = $user->create();
      if($create->true){
        // SEND confirmation link MAIL to customer
        $data = $user->getById($create->data);
        $token = $data->session_token;
        $id = $data->entity_guid;
        $link = Config::$user->root."verify?auth={$token}&u={$id}";
        $mail = new Mail($this->data->email, $data->name);
        if($mail->auth($link)){
          echo json_encode(array("message" => "Account Created Successfully, kindly Confirm Your Email", "valid" => 1, "link" => Config::$user->root."auth"));
        }else{
          echo json_encode(array("message" => "mail not sent", "valid" => 0));
        }
      }
      else
        echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
    }
  }

  public function create(){
    if(!$this->data->reg($this->table)->true)
      echo json_encode(array("message" => $this->data->reg($this->table)->msg, "valid" => 0));
    else{
      $user = $this->class;
      $create = $user->create(1);
      if($create->true){
        $mail = new Mail($this->data->email,$this->data->fullname);      //send email to user
        $u = strtolower($this->module);
        $link = Config::$site->base.$u;
        $mail->newUser($this->module,$link,$this->data->pass);
        if($this->enumUser <= 2){
          EventLogger::log($this->enumUser,"create","a new $this->module with Email: {$this->data->email}");
        }
        echo json_encode(array("message" => "Account Created Successfully", "valid" => 1));
      }
      else
        echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
    }
  }

  public function fb(){
    $user = $this->class;
    $info = json_decode($_POST["data"]);
    $this->data->fullname = $info->first_name." ".$info->last_name;
    $this->data->id = $info->id;
    $this->data->email = $info->email;
    if($user->isExist("email",$info->email)){
      $entity = $user->getByColumn($info->email,"email");
    }
    else{
      $last = $user->oAuth($this->data,"facebook");
      if($last != ""){
        $entity = $user->getById($last);
      }else{
        echo json_encode(array("message" => "Oops!! Something Went Wrong. Try Again", "valid" => 0));
        exit;
      }
    }
    //   set session
    Session::set($this->user,$entity);
    //   create redirection link after to go back to the page before session expired
    $from = isset($_SESSION["from"]) ? $_SESSION["from"] : null;
    $link = (isset($from) AND (strpos($from, "/{$this->user}/?v=") !== false)) ? $from : Config::$user->root;
    echo json_encode(array("message" => "Login Successful, Welcome!!", "valid" => 1, "link" => $link));
  }

  /**
   * Update user info
   */
  public function update() : void{
      if(empty($this->data->email) or empty($this->data->fullname))
          $out = ["msg" => "Email Address and Name Are Required", "status" => 0];
      elseif(!$this->data->email())
          $out = ["msg" => "Invalid Email", "Status" => 0];
      else{
          if($this->class->update())
              $out =["msg" => "Account Updated Successfully", "status" => 1];
          else
              $out = ["msg" => "Failed", "status" => 0];
      }
      $out = (object)$out;
      if($out->status === 1 and $this->enumUser < 1){
          EventLogger::log($this->enumUser,"update","{$this->module} data with Email: {$this->data->email}");
      }
      echo json_encode(array("message" => $out->msg, "valid" => $out->status));
  }

  public function pp(){
    if(!empty($this->data->image)){
      //validate for file type, file must be an image
      if( !in_array($_FILES['image']['type'],$this->data->imgType)){
          echo json_encode(array("message" => "Invalid File Upload: Only jpg,png or jpeg File Format is Required ", "valid" => 0));
          exit();
      }

      //validate for image file size, must not exceed 2megabyte
      if($_FILES["image"]["size"]/1000000 > 1){
          echo json_encode(array("message" => "Image size is too large, Maximum is 2mb", "valid" => 0));
          exit();
      }
      // if(!file_exists($this->imgFolder.Self::LOGO)){
      //     mkdir($this->imgFolder.Self::LOGO,"0777");
      // }
      $this->target = $this->imgFolder.$this->vendor->image;
      move_uploaded_file($_FILES['image']['tmp_name'],$this->target);
    }else{
      echo json_encode(array("message" => "No image Uploaded", "valid" => 0));
      exit();
    }
  }

  public function login(){
    $data = new Validation();
    // if all fields re empty return error and stay on the page
    if(@$data->isEmpty()->true){
      echo json_encode(array("message" => "All Fields Ae Required", "valid" => 0));
      exit;
    }
    // instantiate user class
    $admin = $this->class;
    $auth = $admin->auth();
    if($auth->true){
      //   set session
      Session::set($this->user,$auth->data);
      //   create redirection link after to go back to the page before session expired
      $from = isset($_SESSION["from"]) ? $_SESSION["from"] : null;
      $link = (isset($from) AND (strpos($from, "/{$this->user}/?v=") !== false)) ? $from : Config::$user->root;
      //   log event
      if($this->enumUser < 3){
        EventLogger::loginLog($this->enumUser,"login");
      }
      echo json_encode(array("message" => "Login Successful, Welcome!!", "valid" => 1, "link" => $link));
    }else{
      echo json_encode(array("message" => "Invalid (Username/Email)/Password, Try Again", "valid" => 0));
    }
  }

  //logout
  public function logout(){
      EventLogger::loginLog($this->enumUser,"logout");
      Session::destroy($this->user);
      echo json_encode(array("message" => "Logging You Out......", "valid" => 1,"link" => Config::$user->root."auth"));
      exit();
  }

  public function authenticate(){
    $token  = $this->data->username;
    if($this->class->isExist("session_token",$token,$this->data->id)){
      // activate account
      if($this->class->activate($this->data->id)){
        // set session and redirect to dashboard
        $data = $this->class->getById($this->data->id);
        Session::set($this->user,$data);
        // show success verification
        $mail = new Mail($data->email, $data->name);
        if($mail->custReg($this->user,$data->name,Config::$user->root))
          echo json_encode(array("message" => "Account Verified Successfully. Redirecting you to Dashboard......", "valid" => 1, "link" => Config::$user->root));
      }else{
        echo json_encode(array("message" => "Oops! Something Went Wrong", "valid" => 0, "link" => Config::$site->base));
      }
    }else{
      // show error
      echo json_encode(array("message" => "oops!! Session Expired", "valid" => 0, "link" => Config::$site->base));
    }
  }

  // change password
  public function changepass(){

    $verify = $this->class->isExist('password',md5($this->data->oldPass),$this->class->guid);
    $validate = $this->data->password();
    if($this->data->isEmpty()->true)
      echo json_encode(array("message" => " All Fields Are Required", "valid" => 0));
    elseif(!$verify)
      echo json_encode(array("message" => "Incorrect old Password pleaase try again", "valid" => 0));
    elseif(!$validate->true)
      echo json_encode(array("message" => $validate->msg, "valid" => 0));
    else{
      if($this->class->changePass()){
        if($this->enumUser < 3){
          $name = $this->class->getById($this->class->guid);
          $code = $name->code;
          $uname = $name->name;
          $className = get_class($this->class);
          EventLogger::log($this->enumUser,"update","Password for $className with name: $uname: ID: $code");
        }
        echo json_encode(array("message" => "password Changed successfully", "valid" => 1));
      }else{
        echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
        exit();
      }
    } 
    
  }

  public function fpass(){
    if(empty($this->data->email)){
      echo json_encode(array("message" => " Email is Required", "valid" => 0));
    }elseif(!$this->class->isExist("email",$this->data->email)){
      echo json_encode(array("message" => "Invalid Email. Kindly create a new account or login with Google or Facebook", "valid" => 0));
    }else{

      $data = $this->class->getByColumn($this->data->email,"email");
      if(is_object($data)){
        $token = $data->session_token;
        $id = Helper::crypt($data->entity_guid);
        $link = Config::$user->root."auth?i=reset&auth={$token}&u={$id}";
        $mail = new Mail($data->email,$data->name);      //send email
        if($mail->forgotPassword($link))
          echo json_encode(array("message" => "Kindly retrieve your password using the link sent to your email", "valid" => 1));
        else
          echo json_encode(array("message" => "Failed, try again in few minutes", "valid" => 0));
      }else{
        echo json_encode(array("message" => "Sorry! Couldnt Fetach Your Data", "valid" => 0));
      }
    }
  }

  // change password
  public function resetpass(){
   
    $validate = $this->data->password();
    $token  = $this->data->username;
    $id = Helper::crypt($this->data->id,false);
    if($this->class->isExist("session_token",$token,$id)){
      if($this->data->isEmpty()->true)
        echo json_encode(array("message" => " All Fields Are Required", "valid" => 0));
      elseif(!$validate->true)
        echo json_encode(array("message" => $validate->msg, "valid" => 0));
      else{
        if($this->class->changePass($id)){
          echo json_encode(array("message" => "password Reset successfully", "valid" => 1, "link" => Config::$user->root."auth"));
        }else{
          echo json_encode(array("message" => "Failed, Try Again", "valid" => 0));
          exit();
        }
      } 
    }else{
      echo json_encode(array("message" => "Page Expired!!", "valid" => 1, "link" => Config::$site->base));
      exit();
    }
    
  }
}

?>