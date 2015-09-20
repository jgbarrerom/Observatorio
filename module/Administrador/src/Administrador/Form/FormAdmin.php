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
 * @author JeissonGerardo
 */
use Zend\Form\Form;

class FormAdmin extends Form {

    protected $em;

    public function __construct($dbAdapter = null) {
        $this->setEm($dbAdapter);
        parent::__construct('formAdmin');

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
                "data-toggle"=>"popover"
            )
        ));

        $this->add(array(
            "name" => "apellido",
            "options" => array(
                "label" => "Apellidos* : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "apellido",
                "type" => "text",
                "class" => "form-control",
                "data-toggle"=>"popover"
            )
        ));

        $this->add(array(
            "name" => "correo",
            "options" => array(
                "label" => "Correo* : ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes" => array(
                "id" => "correo",
                "type" => "text",
                "class" => "form-control",
                "data-toggle"=>"popover"
            )
        ));
        if ($dbAdapter != null) {
            $this->add(array(
                "type" => "Zend\Form\Element\Select",
                "name" => "perfil",
                "options" => array(
                    "label" => "Perfil* : ",
                    "value_options" => $this->getOptionsPerfil(),
                    "label_attributes" => array(
                        "class" => "control-label",
                        "data-toggle"=>"tooltip",
                        "title"=>"Se selecciona el eje al que pertenece el usuario que se va a crear"
                    )
                ),
                "attributes" => array(
                    "id" => "perfil",
                    "data-toggle"=>"popover"
                )
            ));
            $this->add(array(
                "type" => "Zend\Form\Element\MultiCheckbox",
                "name" => "permisos",
                "options" => array(
                    "label" => "Permisos del Usuario* : ",
                    "value_options" => $this->getPermisos(),
                    "label_attributes" => array(
                        "class" => "control-label",
                        "data-toggle"=>"tooltip",
                        "title"=>"Se asignan permisos de creacion, modificacion y/o borrado para el nuevo usuario"
                    )
                ),
                "attributes" => array(
                    "class" => "checkbox inline"
                )
            ));
        }

        //BOTONES SUBMIT
        $this->add(array(
            "name" => "crear",
            "attributes" => array(
                "type" => "submit",
                "class" => "btn btn-primary",
                "value" => "Crear Usuario"
            )
        ));
    }

    public function setEm($em) {
        $this->em = $em;
    }

    /**
     * Metodo para consultar todos los posibles perfiles que existen en la BBDD
     * @return type
     */
    public function getOptionsPerfil() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId <> 1');
        $dataResult[''] = '--Seleccione un perfl--';
        foreach ($resultSelect as $res) {
            $dataResult[$res->getPerfilId()] = $res->getPerfilNombre();
        }
        return $dataResult;
    }

    private function getPermisos() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Permiso p');
        foreach ($resultSelect as $res) {
            //$dataResult[$res->getPermisoId()] = $res->getPermisoTipo();
            $dataResult[] = array(
                'value'=>$res->getPermisoId(),
                'label'=>$res->getPermisoTipo(),
                'attributes'=>array(
                    'id'=>$res->getPermisoTipo().'opt'
                ),
                'label_attributes'=>array(
                    'id'=>$res->getPermisoTipo(),
                    'class'=>''
                )
            );
        }
        return $dataResult;
    }

}
