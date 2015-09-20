<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Administrador\Form;

/**
 * Description of FormAdmin
 *
 * @author NathalySalamanca
 */
use Zend\Form\Form;

class FormLugar extends Form {

    protected $em;

    public function __construct($dbAdapter = null) {
        $this->setEm($dbAdapter);
        parent::__construct('formLugar');

        $this->add(array(
            "name" => "nombre",
            "options" => array(
                "label" => "Nombre* : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "nombre",
                "type" => "text",
                "class" => "form-control",
                "data-toggle" => "popover"
            )
        ));

        $this->add(array(
            "name" => "direccion",
            "options" => array(
                "label" => "Direccion* : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "direccion",
                "type" => "text",
                "class" => "form-control",
                "data-toggle" => "popover"
            )
        ));

        $this->add(array(
            "name" => "coordenadas",
            "options" => array(
                "label" => "Coordenadas* : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "coordenadas",
                "type" => "hidden",
                "class" => "form-control",
                "data-toggle" => "popover"
            )
        ));
        $this->add(array(
            "name" => "telefono",
            "options" => array(
                "label" => "Telefono* : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "telefono",
                "type" => "text",
                "class" => "form-control",
                "data-toggle" => "popover"
            )
        ));
        if ($dbAdapter != null) {
            $this->add(array(
                "type" => "Zend\Form\Element\Select",
                "name" => "tipoLugar",
                "options" => array(
                    "label" => "Tipo de Lugar* : ",
                    "value_options" => $this->getOptionsTipoLugar(),
                    "label_attributes" => array(
                        "class" => "control-label"
                    )
                ),
                "attributes" => array(
                    "id" => "tipoLugar",
                    "data-toggle" => "popover"
                )
            ));

            $this->add(array(
                "type" => "Zend\Form\Element\Select",
                "name" => "barrio",
                "options" => array(
                    "label" => "Barrio* : ",
                    "value_options" => $this->getOptionsBarrio(),
                    "label_attributes" => array(
                        "class" => "control-label"
                    )
                ),
                "attributes" => array(
                    "id" => "barrio",
                    "data-toggle" => "popover"
                )
            ));
        }
        //BOTONES SUBMIT
        $this->add(array(
            "name" => "enviar",
            "attributes" => array(
                "type" => "button",
                "class" => "btn btn-primary",
                "value" => "Enviar",
                "id" => "enviar"
            )
        ));
    }

    public function setEm($em) {
        $this->em = $em;
    }

    /**
     * Metodo para consultar todos los posibles tipo de lugares que existen en la BBDD
     * @return type
     */
    public function getOptionstipoLugar() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\TipoLugar p');
        $dataResult[''] = '--Seleccione un tipo de lugar--';
        foreach ($resultSelect as $res) {
            $dataResult[$res->getTipolugarId()] = $res->getTipolugarNombre();
        }
        return $dataResult;
    }

    /**
     * Metodo para consultar todos los barrios que existen en la BBDD
     * @return type
     */
    public function getOptionsBarrio() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Barrio p');
        $dataResult[''] = '--Seleccione un Barrio--';
        foreach ($resultSelect as $res) {
            $dataResult[$res->getBarrioId()] = $res->getBarrioNombre();
        }
        return $dataResult;
    }

}
