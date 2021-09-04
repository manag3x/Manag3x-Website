<?php
namespace server\core;

class Mail{
  
    public $header,$subject,$from,$to,$title,$body,$init,$email,$logo,$company,$name;
    
    function __construct($to="",$name = ""){
        $this->init = "";
        $this->to = empty($to) ? Config::$site->admin_email : $to;
        $this->from = Config::$site->email;
        $this->name = empty($name) ? "Mr Denis" : $name;
        $this->title = ucfirst(Config::$site->name);
        $this->data = new Validation();
        $this->logo = Config::$site->logo;
        $this->dir = "../email/";
        $this->company = ucfirst(Config::$site->name);
    }

    public function send($body){
        $config = new Config();
        $this->subject = $this->init.$this->subject;  
        $this->headers = "MIME-Version: 1.0\r\nContent-Type: text/html\r\n";
        $this->headers  .= "From: $this->company <{$this->from}>\r\n";
        $this->headers  .= "Reply-to: $this->company <{$this->from}>\r\n";
        $this->headers .= "X-Mailer: PHP/".phpversion()."\r\n";
        $this->headers .= "Date: ".date("M m, Y, h:i a")."\r\n";
        $this->headers .= "To: " . $this->name . " <" . $this->to . ">\r\n";
        $this->body = <<<MSG
        <html><style>a{text-decoration:none}</style><body><div style="background: #fbf7f0; color: #000; font-size: 18px; padding: 20px;border-radius: 10px;line-height: 1.5;">
            <div style="">
                <div style="text-align: left; margin-bottom: 15px;">
                    <img src="{$config::$site->logo}" alt="Company Logo" style="max-width: 100%; padding: 10px; border-radius: 10px">
                </div>
                $body
                <div style="text-align: center; margin-top: 20px">{$config::$site->copy}</div>
            </div>
        </div></body></html>
MSG;
        return (mail($this->to, $this->subject, $this->body, $this->headers)) ? true : false;
    }

    /**
     * new customer welcome mail
     *
     * @param string $fullname customer fullname
     * @return bool
     */
    public function custReg($user,$fullname,$link){
        $this->subject = "Welcome to ".ucfirst(Config::$site->name);
        switch ($user){
            case "client": 
                $msg = "We're excited to have you here.<br>
                Sign into your account to access and set up your campaign.";
            break;
            case "guest": 
                $msg = "We're excited to have you here.<br>
                Sign into your guest account and upload your contents based n a selected topic.";
            break;
            case "publisher": 
                $msg = "We're excited to have you here.<br>
                Sign into your publisher account and upload your websites to get started";
            break;
        }
        
        $body = <<<MSG
        
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$fullname},</p>
            <p style="text-align: justify;">$msg<br></p>
            <p><a style="background:#060818;text-decoration:none;color:white;padding:10px 20px" href="$link" target="_blank" class="btn btn-primary">Sign in</a></p>
        </div>
        <div class="text" style="padding: 0 2.5em; text-align: center;">
            <p></p>
            <p style="padding-top: 20px;"><em></em></p>
        </div>
MSG;
        return $this->send($body);
    }

    public function auth($link){
        $this->subject = "Activate your Account";
        $msg = "Thank you for joining {$this->company}. Click the button below to confirm that this is correct email to reach you";
        $a = "Verify Email";
        $title = "Verify your email address.";
        $foot = "If you did not sign up for this account you can ignore this email and the account will be deleted";
        $body = <<<MSG
        <div class="text" style="padding: 0 2.5em; text-align: center;">
            <h2 class="head-title" style="font-size: 23px;">$title</h2>
            <p style="text-align: justify;">$msg<br></p>
        </div>
        <div class="text" style="padding: 0 2.5em; text-align: center;">
            <p><a style="background:#060818;text-decoration:none;color:white;padding:10px 20px" href="$link" target="_blank" class="btn btn-primary">$a</a></p>
            <p style="padding-top: 30px;"><em>$foot</em></p>
        </div>
MSG;
        return $this->send($body);
    }

    /**
     * forgot password mail
     *
     * @param string $link forgot password link
     * @return void
     */
    public function forgotPassword($link){
        $this->subject = "User Password Reset";
        $msg = "Click on the Reset Password button below to reset your password";
        $a = "Reset Password";
        $title = "Password Reset.";
        $foot = "If you did not sign up for this action you can ignore this email";
        $body = <<<MSG
        <div class="text" style="padding: 0 2.5em;">
            <h2 class="head-title" style="font-size: 23px;">$title</h2>
            <p style="text-align: justify;">$msg<br></p>
        </div>
        <div class="text" style="padding: 0 2.5em;">
            <p><a style="background:#060818;color:white;text-decoration:none;padding:10px 20px" href="$link" target="_blank" class="btn btn-primary">$a</a></p>
            <p style="padding-top: 30px;"><em>$foot</em></p>
        </div>
MSG;
        return $this->send($body);
    }

    public function adminMsg($type,$data){
        switch ($type){
            case "newGuestArticle": 
                $msg = "You Have a new Guest Article titled: $data ";
            break;
            case "contentApproval": 
                $msg = "You Have a new content approval, check basic details below.<br>
                <p>Task ID: $data->task <br>Content ID: $data->code <br>Client Eamil: $data->email <br>Client Name: $data->name</p>";
            break;
            case "contentCorrection": 
                $msg = "You Have a newly Corrected content by client, check basic details below.<br>
                <p>Task ID: $data->task <br>Content ID: $data->code <br>Client Eamil: $data->email <br>Client Name: $data->name <br> Correction:<br> $data->correction</p>";
            break;
            case "contentRejection": 
                $msg = "You Have a newly Rejected content by client, check basic details below.<br>
                <p>Task ID: $data->task <br>Content ID: $data->code <br>Client Eamil: $data->email <br>Client Name: $data->name <br> Rejection Description:<br> $data->correction</p>";
            break;
        }
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
            
        </div>
MSG;
        return $this->send($body);
    }

    public function order($type,$id){
        $this->subject = "$type Order Received";
        $msg = "Your $type order has been received and under processing, order progress can be monitored from your account";
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
            <p>Order ID: $id</p>
        </div>
MSG;
        return $this->send($body);
    }

    public function orderAdmin($type,$email,$name,$id){
        $this->subject = "New $type Order";
        $msg = "You Have a new $type order, see basic information below:";
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
            <p>Order ID: $id <br>Client Eamil: $email <br>Client Name: $name <br>Order Type: $type</p>
        </div>
MSG;
        return $this->send($body);
    }

    public function posted($link,$title){
        $this->subject = "Newly Posted Article";
        $msg = "We are glad to inform you that your article titled: $title has been posted.<br> Click on the button below to view article";
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
            <p><a style="background:#060818;color:white;text-decoration:none;padding:10px 20px" href="$link" target="_blank" class="btn btn-primary">View Article</a></p>
        </div>
MSG;
        return $this->send($body);
    }

    public function approvedByEditor($title){
        $this->subject = "New Article Awaiting Scrutiny Before Posting";
        $msg = "We are glad to inform you that your article titled: $title has been submitted.<br> visit your account to review";
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
        </div>
MSG;
        return $this->send($body);
    }

    public function assigned($user){
        $this->subject = "Newly Assigned Task";
        $msg = "you have been assigned a new task from {$this->name} Kindly visit your $user's Account to confirm and work on it";
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
        </div>
MSG;
        return $this->send($body);
    }

    public function guestArticle($name,$title,$reason=""){
        $this->subject = "Newly Assigned Task";
        switch ($name){
            case "approve": 
                $msg = "We're pleased to inform you that your guest writer article titled: {$title} has been approved.<br>";
            break;
            case "reject": 
                $msg = "We're sorry to inform you that your guest writer article titled: {$title} was rejected.<br>
                Rejection Note:<br> $reason";
            break;
            case "new": 
                $msg = "Your guest writer article titled: {$title} has been received. We will get back to you in 3 working days";
            break;
        }
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
        </div>
MSG;
        return $this->send($body);
    }

    public function newUser($name,$link,$pass){
        $this->subject = "Congratulations From $this->company";
        $msg = "We are glad to inform you that you have been approved as a $name in $this->company. <br> click on the button below to access your account, kindly change your password once you are logged in.<br><b>Password:</b> $pass";
        $body = <<<MSG
        <div class="text" style="padding: 0 4.5em;text-align: left;">
            <h2 class="head-title" style="font-size: 23px;">$this->subject</h2>
            <p>Hello {$this->name},</p>
            <p style="text-align: justify;">$msg<br></p>
            <p><a style="background:#060818;color:white;text-decoration:none;padding:10px 20px" href="$link" target="_blank" class="btn btn-primary">Sign in</a></p>
        </div>
MSG;
        return $this->send($body);
    }
    
}

?>