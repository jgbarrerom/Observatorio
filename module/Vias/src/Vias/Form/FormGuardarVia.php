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
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;

class FormGuardarVia extends Form {

    protected $em;

    public function __construct($dbAdapter) {
        $this->setEm($dbAdapter);
        parent::__construct('FormGuardarVia');

        $this->add(array(
            "name" => "tramo",
            "options" => array(
                "label" => "Tramo :"
            ),
            "attributes" => array(
                "id" => "tramo",
                "type" => "text",
                "required" => "required",
            )
        ));

        $this->add(array(
            "name" => "dirInicio",
            "options" => array(
                "label" => "Direccion Inicio :"
            ),
            "attributes" => array(
                "id" => "dirInicio",
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
                "id" => "dirFinal",
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
                "id" => "civ",
                "type" => "text",
                "required" => "required",
                "style" => "resize: none;",
                "class" => "form-control"
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
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "name" => "largo",
            "options" => array(
                "label" => "Largo :"
            ),
            "attributes" => array(
                "id" => "largo",
                "type" => "text",
                "required" => "required",
                "class" => "input-mini"
            )
        ));

        $this->add(array(
            "type" => "select",
            "name" => "tipoObra",
            "options" => array(
                "label" => "Tipo de Obra :",
                'value_options' => $this->getOptionsTipoObra(),
            ),
            "attributes" => array(
                "id" => "tipoObra",
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
                'value_options' => $this->getOptionsEstados(),
            ),
            "attributes" => array(
                "id" => "estado",
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "type" => "select",
            "name" => "barrio",
            "options" => array(
                "label" => "Barrio:",
                'value_options' => $this->getOptionsBarrios(),
            ),
            "attributes" => array(
                "id" => "barrio",
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
                "id" => "presupuesto",
                "type" => "text",
                "required" => "required",
                "class" => "input-mini"
            )
        ));
        $this->add(array(
            "name" => "ancho",
            "options" => array(
                "label" => "Ancho :"
            ),
            "attributes" => array(
                "id" => "ancho",
                "type" => "text",
                "required" => "required",
                "class" => "input-mini"
            )
        ));
        $this->add(array(
            "name" => "interventor",
            "options" => array(
                "label" => "Interventor :"
            ),
            "attributes" => array(
                "id" => "Interventor",
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));

        $this->add(array(
            "type" => "select",
            "name" => "ejecutor",
            "options" => array(
                "label" => "Ejecutor:",
                'value_options' => $this->getOptionsEjecutores(),
            ),
            "attributes" => array(
                "id" => "ejecutor",
                "type" => "text",
                "required" => "required",
                "class" => "form-control"
            )
        ));
        $this->add(array(
            "type" => "select",
            "name" => "anio",
            "options" => array(
                "label" => "Año:",
                'value_options' => $this->ultimosAnios()
            ),
            "attributes" => array(
                "id" => "anio",
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
            "name" => "enviar",
            "attributes" => array(
                "type" => "button",
                "class" => "btn btn-primary ",
                "value" => "Enviar",
                "id" => "enviar"
            )
        ));

//        $textarea = new Element\Textarea('my-textarea');
//        $textarea->setLabel('Objetivo');
    }

    /**
     * Metodo para consultar todos los posibles perfiles que existen en la BBDD
     * @return type
     */
    public function setEm($em) {
        $this->em = $em;
    }

    public function getOptionsTipoObra() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\TipoObra');
        foreach ($resultSelect as $res) {
            $dataResult[$res->getTipoobraId()] = $res->getTipoobraNombre();
        }
        return $dataResult;
    }

    public function getOptionsEstados() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Estado');
        $dataResult[''] = '--Seleccione un estado--';

        foreach ($resultSelect as $res) {
            $dataResult[$res->getEstadoId()] = $res->getEstadoNombre();
        }
        return $dataResult;
    }

    public function getOptionsBarrios() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Barrio');
        $dataResult[''] = '--Seleccione un barrio--';

        foreach ($resultSelect as $res) {
            $dataResult[$res->getBarrioId()] = $res->getBarrioNombre();
        }
        return $dataResult;
    }

    public function getOptionsEjecutores() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Ejecutor');
        $dataResult[''] = '--Seleccione un Ejecutor--';

        foreach ($resultSelect as $res) {
            $dataResult[$res->getEjecutorId()] = $res->getEjecutorNombre();
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
