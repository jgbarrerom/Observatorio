<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Salud\Form;

/**
 * Description of FormularioSalud
 *
 * @author JeissonGerardo
 */

use Zend\Form\Form;

class FormularioSalud extends Form{
    public function __construct() {
        parent::__construct('formSalud');
        
        $this->add(array(
            "name"=>"nombreP",
            "options"=>array(
                "label"=>"Nombre Proyecto: ",
                "label_class"=>array(
                    "class"=>"control-label"
                )
            ),
            "attributes"=>array(
                "id"=>"nombreP",
                "type"=>"text",
                "class"=>"form-control"
            )
        ));
        $this->add(array(
            "name"=>"objetivo",
            "options"=>array(
                "label"=>"Objetivos: "
            ),
            "attributes"=>array(
                "id"=>"objetivo",
                "type"=>  "\Zend\Form\Element\Textarea",
                "class"=>"form-control"
            )
        ));
        $this->add(array(
            "name"=>"fechaIni",
            "options"=>array(
                "label"=>"Fecha Inicio: "
            ),
            "attributes"=>array(
                "id"=>"fechaIni",
                "type"=> "text"
            )
        ));
        $this->add(array(
            "name"=>"plazoEjec",
            "options"=>array(
                "label"=>"Plazo de Ejecucion (Meses): "
            ),
            "attributes"=>array(
                "id"=>"plazoEjec",
                "type"=> "text",
            )
        ));
        $this->add(array(
            "name"=>"valProj",
            "options"=>array(
                "label"=>"Valor Proyecto: "
            )
        ));
        $this->add(array(
            "name"=>"superVi"
        ));
        $this->add(array(
            "name"=>"interventoria"
        ));
        $this->add(array(
            "name"=>"videncia"
        ));
        $this->add(array(
            "name"=>"ejecutor"
        ));
    }
}
