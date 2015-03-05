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
            "name" => "dirInicio",
            "options" => array(
                "label" => "Direccion Inicio :"
            ),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control espacio"
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
                "style" => "resize: none;",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "fotos",
            "options" => array(
                "label" => "Fotografias :"
            ),
            "attributes" => array(
                "type" => "file",
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
            "type" => "select",
            "name" => "tipoObra",
            "options" => array(
                "label" => "Tipo de Obra :",
                'value_options' => array(
                    '' => 'Seleccione tipo de obra',
                    '2' => 'rehabilitacion',
                    '3' => 'creacion'
                ),),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "type" => "select",
            "name" => "estado",
            "options" => array(
                "label" => "Estado:",
                'value_options' => array(
                    '' => 'Seleccione estado',
                    '2' => 'terminado',
                    '3' => 'en proceso'
                ),),
            "attributes" => array(
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
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
            "name" => "coordenadas",
            "attributes" => array(
                "type" => "hidden",
                "required" => "required",
                "id" => "coordenadas",
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
        $this->add(array(
            "name" => "enviar",
            "attributes" => array(
                "type" => "submit",
                "class" => "btn btn-primary ",
                "value" => "Enviar"
            )
        ));
//
//        $textarea = new Element\Textarea('my-textarea');
//        $textarea->setLabel('Objetivo');
    }

}
