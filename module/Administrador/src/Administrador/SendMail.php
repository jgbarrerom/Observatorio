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

    public function contruirCorreo(array $param = null, $itsNew = true) {
        $mail = new Mail\Message();
        $mail->setTo($param['user'], $param['nombre'] . ' ' . $param['apellido']); //para
        $mail->addFrom('jgbpqek@gmail.com', 'Observatorio Ciudad Bolívar'); //de
        $mail->setSubject('Clave ingreso Observatorio'); //asunto
        $cfg = array(
            'ssl' => 'tls',
            'username' => 'jgbpqek@gmail.com',
            'password' => 'JeissonB_1989',
        );
        if ($itsNew) {
            $htmlMessage = '<div style="text-align:center">'
                    . '<div style="">'
                    . '<img src="" alt="Alcaldia Local de Ciudad Bolivar">'
                    . '</div>'
                    . '<div style="background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #33385f, #3a5e81) repeat scroll 0 0;color:#ffffff">'
                    . '<h3>Bienvenido al observatorio social de la localidad de Ciudad Bol&iacute;var</h3>'
                    . '<p>Para el ingreso a la plataforma, debes ingresar las siguientes credenciales*</p>'
                    . '<p>Correo: ' . $param['user'] . '</p>'
                    . '<p>Contrase&ntilde;a: <b>' . $param['pass'] . '</b></p>'
                    . '<p><h5>*Al momento de hacer el primer ingreso es necesario realizar el cambio de contrase&ntilde;a<h5></p>'
                    . '</div>'
                    . '</div>';
        } else {
            $htmlMessage = '<h4>Gracias por actualizar la contraseña de ingreso a la plataforma</h4>'
                    . '<p>El cambio de contrseña se ha realizado de manera correcta</p>';
        }
        $htmlPart = new \Zend\Mime\Part($htmlMessage);
        $htmlPart->type = "text/html";
        $body = new \Zend\Mime\Message();
        $body->setParts(array($htmlPart));
        $mail->setEncoding("UTF-8");
        $mail->setBody($body);
        $smtpOption = new Mail\Transport\SmtpOptions();
        $smtpOption->setHost('smtp.gmail.com')
                ->setConnectionClass('login')
                ->setName('smtp.gmail.com')
                ->setConnectionConfig($cfg);

        $smtp = new Mail\Transport\Smtp($smtpOption);
        $smtp->send($mail);
    }

}
