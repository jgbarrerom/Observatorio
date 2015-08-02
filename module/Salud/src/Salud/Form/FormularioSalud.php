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

class FormularioSalud extends Form {

    protected $em;

    public function __construct($dbAdapter) {
        $this->setEm($dbAdapter);
        parent::__construct('formSalud');

        $this->add(array(
            "name" => "nombreP",
            "options" => array(
                "label" => "Nombre Proyecto: ",
                "label_attributes" => array(
                    "class" => "control-label "
                )
            ),
            "attributes" => array(
                "id" => "nombreP",
                "type" => "text",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "objetivo",
            "options" => array(
                "label" => "Objetivos: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "objetivo",
                "type" => "\Zend\Form\Element\Textarea",
                "class" => "form-control",
                "style" => "width:100%;resize:none",
                "rows" => "4",
            )
        ));
        $this->add(array(
            "name" => "objetoC",
            "options" => array(
                "label" => "Objeto Contractual: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "objetoC",
                "type" => "\Zend\Form\Element\Textarea",
                "class" => "form-control",
                "style" => "width:100%;resize:none",
                "rows" => "4",
            )
        ));
        $this->add(array(
            "name" => "fechaIni",
            "options" => array(
                "label" => "Fecha Inicio: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "fechaIni",
                "type" => "text",
                "readonly" => "readonly"
            )
        ));
        $this->add(array(
            "name" => "plazoEjec",
            "options" => array(
                "label" => "Plazo de Ejecucion (Meses): ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "plazoEjec",
                "type" => "text",
            )
        ));
        $this->add(array(
            "type" => "Zend\Form\Element\Select",
            "name" => "vigencia",
            "options" => array(
                "label" => "Vigencia : ",
                "value_options" => $this->ultimosAnios(),
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "vigencia",
                "data-toggle" => "popover"
            )
        ));


        $this->add(array(
            "type" => "Zend\Form\Element\Select",
            "name" => "estado",
            "options" => array(
                "label" => "Estado : ",
                "value_options" => $this->getOptionsEstado(),
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "estado",
                "data-toggle" => "popover"
            )
        ));


        $this->add(array(
            "name" => "numeroP",
            "options" => array(
                "label" => "Numero de Proyecto: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "numeroP",
                "type" => "text",
            )
        ));
        $this->add(array(
            "name" => "ejecutorP",
            "options" => array(
                "label" => "Ejecutor: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "ejecutorP",
                "type" => "text",
            )
        ));

        $this->add(array(
            "name" => "valProj",
            "options" => array(
                "label" => "Valor Proyecto: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "valProj",
                "type" => "text"
            )
        ));

        $this->add(array(
            "name" => "proyecto-fotos",
            "options" => array(
                "label" => "Fotografias :"
            ),
            "attributes" => array(
                "id" => "proyecto-fotos",
                "type" => "Zend\Form\Element\File",
                "multiple" => "true",
                "accept" => "image/x-png, image/jpeg",
                "class" => "form-control"
            )
        ));

        $this->add(array(
            "type" => "Zend\Form\Element\Select",
            "name" => "segmento",
            "options" => array(
                "label" => "Dirigido a: ",
                "label_attributes" => array(
                    "class" => "control-label"
                ),
                "attributes" => array(
                    "id" => "segmento"
                ),
                "value_options" => $this->getOptionsSegmento(),
                "label_attributes" => array(
                    "class" => "control-label"
                )
            )
        ));
        $this->add(array(
            "name" => "ejecutor"
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

    public function getOptionsSegmento() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Segmento');
        $dataResult[''] = '--Seleccione un segmento--';
        foreach ($resultSelect as $res) {
            $dataResult[$res->getSegmentoId()] = $res->getSegmentoNombre();
        }
        return $dataResult;
    }

    public function getOptionsEstado() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Estado');
        $dataResult[''] = '--Seleccione un estado--';
        foreach ($resultSelect as $res) {
            $dataResult[$res->getEstadoId()] = $res->getEstadoNombre();
        }
        return $dataResult;
    }

    function ultimosAnios() {
        $anio_a = date("Y");
        $dataResult = array();
        $dataResult[''] = '--Seleccione año--';
        for ($i = 0; $i < 8; $i++) {
            $dataResult[$anio_a - $i] = $anio_a - $i;
        }
        return $dataResult;
    }

}
