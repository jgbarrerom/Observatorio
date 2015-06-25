<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Form;

use Zend\Captcha;
use Zend\Captcha\Image as CaptchaImagen;
use Zend\Form\Fieldset;
use Zend\Form\Form;
/**
 * Description of Formularios
 *
 * @author Jeisson
 */
class Formularios extends Form {
    
    public function __construct() {
        parent::__construct("reporteVia");
        
        $this->add(array(
            "type"=> 'Zend\Form\Element\Select',
            "name"=>"tipoCalle",
            "options"=>array(
                "value_options"=>array(
                    "Calle",
                    "Carrera",
                    "Diagonal",
                    "Transversal",
                )
            ),
            "attributes"=>array(
                "id"=>"tipoCalle",
                "required"=>"required",
                "class"=>"form-control span2"
            )
        ));
        
        $this->add(array(
            "name"=>"firsthNum",
            "options"=>array(
                "label"=>""
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"=>"letraFirNum",
            "options"=>array(
                "value_options"=>  $this->abcDario()
            ),
            "attributes"=>array(
                "type"=> "Zend\Form\Element\Select",
                "required"=>"required",
            )
        ));        
        
        $this->add(array(
            "name"=>"bis",
            "type"=> "Zend\Form\Element\Checkbox",
            "options"=>array(
                "label"=>"Bis",
                'use_hidden_element' => true,
                'checked_value' => 'bis',
                'unchecked_value' => ''
            )
        ));
        
        $this->add(array(
            "name"=>"letraSecNum",
            "options"=>array(
                "value_options"=>  $this->abcDario()
            ),
            "attributes"=>array(
                "type"=> "Zend\Form\Element\Select",
                "required"=>"required",
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
    private function abcDario() {
        $abcDario = array();
        for($i=65;$i<=95;$i++){
            $abcDario[chr($i)]= chr($i);
        }
        return $abcDario;
    }
}
