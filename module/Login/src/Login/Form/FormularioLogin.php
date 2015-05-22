<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormularioLogin
 *
 * @author JeissonGerardo
 */
namespace Login\Form;

use Zend\Form\Form;

class FormularioLogin extends Form{
    public function __construct() {
        parent::__construct('formLogin');
        
        $this->add(array(
            "name"=>"correo",
            "options"=>array(
                "label"=>"Correo : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes"=>array(
                "id"=>"correo",
                "type"=>"text",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"=>"password",
            "options"=>array(
                "label"=>"Contraseña : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes"=>array(
                "id"=>"password",
                "type"=>"password",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"=>"enviar",
            "attributes"=>array(
                "type"=>"submit",
                "class"=>"btn btn-primary",
                "value"=>"Enviar"
            )
        ));
        $this->add(array(
            'type'=> 'Zend\Form\Element\Csrf',
            'name'=>'loginL',
            'options'=>array(
                'csrf_options'=>array(
                    'timeout'=>3600
                )
            )
        ));
    }
}
