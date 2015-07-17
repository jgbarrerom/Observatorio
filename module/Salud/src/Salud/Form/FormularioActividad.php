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
 * @author Nathaly Salamanca
 */
use Zend\Form\Form;

class FormularioActividad extends Form {

    protected $em;

    public function __construct($dbAdapter) {
        $this->setEm($dbAdapter);
        parent::__construct('formEventoSalud');

        $this->add(array(
            "name" => "nombreActividad",
            "options" => array(
                "label" => "Nombre de la actividad: ",
                "label_attributes" => array(
                    "class" => "control-label "
                )
            ),
            "attributes" => array(
                "id" => "nombreActividad",
                "type" => "text",
                "class" => "form-control"
            )
        ));

        $this->add(array(
            "name" => "fechaActividad",
            "options" => array(
                "label" => "Fecha de la actividad: ",
                "label_attributes" => array(
                    "class" => "control-label "
                )
            ),
            "attributes" => array(
                "id" => "fechaActividad",
                "type" => "date",
                "class" => "form-control"
            )
        ));

        $this->add(array(
            "type" => "Zend\Form\Element\Select",
            "name" => "lugarActividad",
            "options" => array(
                "label" => "Lugar : ",
                "label_attributes" => array(
                    "class" => "control-label"
                ),
                "attributes" => array(
                    "id" => "lugarActividad"
                ),
                "value_options" => $this->getOptionsLugar(),
                "label_attributes" => array(
                    "class" => "control-label"
                )
            )
        ));
        $this->add(array(
            "name" => "objetivoActividad",
            "options" => array(
                "label" => "Objetivos de la actividad: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "objetivoActividad",
                "type" => "\Zend\Form\Element\Textarea",
                "class" => "form-control",
                "style" => "width:100%;resize:none",
                "rows" => "4",
            )
        ));
        $this->add(array(
            "name" => "requisitosActividad",
            "options" => array(
                "label" => "Requisitos de la actividad: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "requisitosActividad",
                "type" => "\Zend\Form\Element\Textarea",
                "class" => "form-control",
                "style" => "width:100%;resize:none",
                "rows" => "4",
            )
        ));

        $this->add(array(
            "name" => "almacenar",
            "attributes" => array(
                "type" => "submit",
                "class" => "btn btn-primary",
                "value" => "Guardar"
            )
        ));
    }

    public function setEm($em) {
        $this->em = $em;
    }

    public function getOptionsLugar() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Lugar');
        foreach ($resultSelect as $res) {
            $dataResult[$res->getLugarId()] = $res->getLugarNombre();
        }
        return $dataResult;
    }

}
