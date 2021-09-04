<?php
/**!
 * @ input validation library
 * @author mrprotocoll
 * @version 1.0.0
 * @since 2/6/2021
 * @modified 27/06/2021
 *
 */
namespace server\core;

class Validation {

    public string $username,$email,$fullname,$phone,$amount,$password,$pass,$conPass,$address,$link,$image,
        $table,$column,$id,$policy,$oldPass,$xdate,$token,$description,$user,$currency,$doc,
        $country,$title,$status,$file;
    public array $imgType,$category,$limit,$checkAll,$ctitle,$cdesc,$camount,$keyword;

    function __construct(){
        $all = ['id','username','name','email','table','status','tel','amount','address','route','policy','user','description','title','currency','link','country','title',"writer","editor","file"];
        $arr = ['category','limit','checkAll',"ctitle","cdesc","word","camount","keyword"];
        foreach ($all as $prop){
            $this->{$prop} = Core::treat($prop);
        }
        foreach ($arr as $prop){
            $this->{$prop}   = (Core::post($prop)) ?? [];
        }
        $this->pass       = Core::treat('password');
        $this->conPass    = Core::treat('con-password');
        $this->oldPass    = Core::treat('old-password');
//      $this->image      = Core::treatFile($_FILES['image']['name'] ?? null);
        $this->password   = md5($this->pass);
        $this->imgType    = array('image/jpg', 'image/jpeg', 'image/png');
        $this->xdate      = time();
        $this->token      = bin2hex(openssl_random_pseudo_bytes(50));
        $this->doc        = "";
    }

    // validate for empty post fields
    public static function isEmpty() : object{
        foreach ($_POST as $key => $val) {
            return (empty($val)) ? (object)[ "true" => true,"key" => $key] : (object)[ "true" => false];
        }
    }

    /**
     * validate username
     *
     * @return void
     */
    public function username(){

        $core       = new Core($this->table);
        $username   = $this->id;
        if(stripos($username," ")){
            ?>
              <span class="text-danger">username must not contain space</span>
            <?php
        }elseif(strlen($username) < 5){
            ?>
            
                <span class="text-danger">username must be atleast 5 characters</span>
            <?php
        }
        elseif($core->isExist("username",$username)){
            ?>
                <span class="text-danger"><?php echo $username?> is not available, try another username</span>
            <?php
        }else{
            ?>
                <span class="text-success"><?php echo $username?> is available</span>
            <?php
        }
    }

    /**
     * validate password
     *
     * @return object
     */
    public function password() : object {
        if($this->pass != $this->conPass)
            $msg = "Password Does not Match";
        else if(strlen($this->password) < 6)
            $msg = "Password Must be Atleast 6 Characters";
        else
            $msg = "";
        return (empty($msg)) ? (object)[ "true" => true] : (object)["true" => false,"msg" => $msg];
    }

    /**
     * validate email
     * Retrun true if email is valid
     * @return boolean
     */
    public function email($email = null) : bool{
        return (bool)filter_var($email ?? $this->email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * validate registration
     *
     * @return object
     */
    public function reg($user) : object{
        $core  = new Core($user);
        if (!$this->email())
            $msg = "Invalid Email";
        elseif($core->isExist("email",$this->email))
            $msg = "User Already Registered, Login With the Email or Use the Forgot Password";
//        elseif(!$this->password()->true)
//            $msg = $this->password()->msg;
        else
            $msg = "";
        return (empty($msg)) ? (object)[ "true" => true] : (object)["true" => false,"msg" => $msg];
    }
}