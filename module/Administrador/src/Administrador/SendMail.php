<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Administrador;

/**
 * Description of SendMail
 *
 * @author JeissonGerardo
 */
use Zend\Mail;
class SendMail {
    public function contruirCorreo(array $param = null) {
        $mail = new Mail\Message();
        $mail->setTo('jgbpqek@gmail.com','Jeisson');//de
        $mail->addFrom('jgb_17@hotmail.com');//para
        $mail->setSubject('Clave ingreso');//asunto
        $cfg = array(
            'ssl'=>'tls',
            'username'=>'jgbpqek@gmail.com',
            'password'=>'JeissonB_1989',
        );
        $smtpOption = new Mail\Transport\SmtpOptions();
        $smtpOption->setHost('smtp.gmail.com')
                   ->setConnectionClass('login')
                   ->setName('smtp.gmail.com')
                   ->setConnectionConfig($cfg);
        
        $smtp = new Mail\Transport\Smtp($smtpOption);
        $smtp->send($mail);
    }
}
