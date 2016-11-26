<?php

namespace App\Services;

use PHPMailer;
use Noodlehaus\Config;

class Mailer {

    public function sendMail($email, $message, $subject){
        $config = new Config(__DIR__ . '/../config');
        date_default_timezone_set('Europe/Athens');
        $this->mail = new PHPMailer;
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug  = $config->get('mail.SMTPDebug');
        $this->mail->SMTPAuth   = $config->get('mail.SMTPAuth');
        $this->mail->SMTPSecure = $config->get('mail.SMTPSecure');
        $this->mail->Host       = $config->get('mail.Host');
        $this->mail->Port       = $config->get('mail.Port');
        $this->mail->AddAddress($email);
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $this->mail->Username = $config->get('mail.Username');
        $this->mail->Password = $config->get('mail.Password');
        $this->mail->SetFrom($config->get('mail.SetFrom'));
        $this->mail->AddReplyTo($config->get('mail.AddReplyTo'));
        $this->mail->Subject    = $subject;
        $this->mail->MsgHTML($message);
        $this->mail->Send();
    }
}