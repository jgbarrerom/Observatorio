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
            "name"=>"nombre",
            "options"=>array(
                "label"=>"Usuario : "
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"=>"password",
            "options"=>array(
                "label"=>"Contraseña : "
            ),
            "attributes"=>array(
                "type"=>"password",
                "required"=>"required",
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
