<?php
declare(strict_types=1);
namespace server\core;
require_once $GLOBALS['DIR'] . "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailGenerator {
    public function smtp_settings(PHPMailer $mail) : PHPMailer{
        //Server settings
        #$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Host       = 'email-smtp.us-east-2.amazonaws.com';                     //Set the SMTP server to send through
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->Username   = 'AKIATOGC576KI3I3R7RX';                     //SMTP username
        $mail->Password   = 'BHd/6J7jNT8I7bvakqbNWRtsc3FA0PUE6M9qyTsvTS8c';                               //SMTP password
        return $mail;
    }
    public function send_mail($subject,$msg,array $opt = [], bool $loop = false){
        $config = new Config();
        $mail = new PHPMailer();
        $msg = <<<MSG
                <html><body><div style="background: #fbf7f0; color: #000; font-size: 18px; padding: 20px;border-radius: 10px;line-height: 1.5;">
                    <div style="text-align: center; margin-bottom: 15px;"><img src="{$config::$site->logo}" alt="Company Logo" style="max-width: 100%; background: #000; padding: 10px; border-radius: 10px"></div>
                    $msg
                    <div style="text-align: center; margin-top: 10px">{$config::$site->copy}</div>
                </div></body></html>
MSG;

        if(isset($opt['from_email']))
            $mail->setFrom($opt['from_email'], $opt['from_name']);
        else
            $mail->setFrom($config::$site->email, $config::$site->name);
        $mail->Subject = $subject;
        $mail->addAddress($opt['to_email'], $opt['to_name']);
        $mail->msgHTML($msg);

        if($loop == false) {
            if(isset($opt['to_email']))
                $mail->addAddress($opt['to_email'], $opt['to_name']);
            else
                $mail->addAddress($config::$site->email, $config::$site->name);

            if(isset($opt['attach']))
                $mail->addStringAttachment($opt['attach_name'], $opt['attach']);

            try {
                // $mail = $this->smtp_settings($mail);
                $mail->send();
                return true;
            } catch (Exception $e) {
                echo 'Mailer Error (' . htmlspecialchars($opt['to_email']) . ') ' . $mail->ErrorInfo . '<br>';
            }

            return false;
        }
        return $mail->send();
    }

}