<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
/**
 * Description of Formularios
 *
 * @author Jeisson
 */
class Formularios extends Form {    
    
    public function __construct($name = null) {
        parent::__construct($name);
        
        
        
        $this->add(array(
            "name"=>"nombre",
            "options"=>array(
                "label"=>"Ingrese su Nombre : "
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"input-medium"
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
    }
    
}
