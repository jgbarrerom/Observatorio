<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormCrearProyectoVia
 *
 * @author NATHALY
 */

namespace Vias\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Form\Element\Select as select;

class FormCrearProyectoVia extends Form {

    public function __construct() {
        parent::__construct('formCrearProyVia');

        $this->add(array(
            "name" => "nombreProyecto",
            "options" => array(
                "label" => "Nombre de proyecto :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "presupuesto",
            "options" => array(
                "label" => "Presupuesto :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "objetivo",
            "options" => array(
                "label" => "Objetivo :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "style" => "resize: none;",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "documento",
            "options" => array(
                "label" => "Documento :"
            ),
            "attributes" => array(
                "type" => "file",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "problematica",
            "options" => array(
                "label" => "Problematica :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "type" => "select",
            "name" => "segmento",
            'options' => array(
                'label' => _('Segmento'),
                'label_attributes' => array('class' => 'control-label'),
                'value_options' => array(
                    '' => 'Select your gender',
                    '2' => 'Female',
                    '3' => 'Male'
                ),),
            "attributes" => array(
                "type" => "text",
                "required" => "required", +
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "type" => "select",
            "name" => "upz",
            "options" => array(
                "label" => "UPZ :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
        "type" => "select",
        "name" => "barrio",
        "options" => array(
        "label" => "Barrio :",
        'value_options' => array(
        '' => 'Select your gender',
        '2' => 'Female',
        '3' => 'Male'
        ), ),
        "attributes" => array(
        "required" => "required",
        "class" => "form-control"
        )
        ));
        $this->add(array(
            "name" => "dirInicio",
            "options" => array(
                "label" => "Direccion Inicio :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "dirFinal",
            "options" => array(
                "label" => "Direccion Final :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "civ",
            "options" => array(
                "label" => "CIV :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "largo",
            "options" => array(
                "label" => "Largo :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "map",
            "attributes" => array(
                "id" => "googleMap",
                "type" => "",
                "style" => "height: 400px;width: 80%;background: #CECEF6;",
            )
        ));

        $element = new Element\Select('language');
        $element->setValueOptions(array(
            '0' => 'French',
            '1' => 'English',
            '2' => 'Japanese',
            '3' => 'Chinese'
        ));

        $this->add(array(
            "name" => "enviar",
            "attributes" => array(
                "type" => "submit",
                "class" => "btn btn-primary",
                "value" => "Enviar"
            )
        ));
//
//        $textarea = new Element\Textarea('my-textarea');
//        $textarea->setLabel('Objetivo');
    }

}
