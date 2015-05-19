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
            "name"      =>"nombre",
            "options"   =>array(
                "label"=>"Nombre : "
            ),
            "attributes"=>array(
                "id"=>"nombre",
                "type"=>"text",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"      =>"apellido",
            "options"   =>array(
                "label"=>"Apellidos : "
            ),
            "attributes"=>array(
                "id"=>"apellido",
                "type"=>"text",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"      =>"correo",
            "options"   =>array(
                "label"=>"Correo : "
            ),
            "attributes"=>array(
                "id"      =>"correo",
                "type"=>"text",
                "class"=>"form-control"
            )
        ));
        if($dbAdapter != null){
            $this->add(array(
                "type"      => "Zend\Form\Element\Select",
                "name"      =>"perfil",
                "options"   =>array(
                    "label"=>"Perfil : ",
                    "value_options"=> $this->getOptionsPerfil()
                ),
                "attributes"=>array(
                    "id"=>"perfil"
                )
            ));
            $this->add(array(
                "type"      => "Zend\Form\Element\MultiCheckbox",
                "name"      => "permisos",
                "options"   => array(
                    "label" => "Permisos del Usuario: ",
                    "value_options"=>$this->getPermisos()
                ),
                "attributes"=>array(
                    "class"=>"checkbox inline"
                )
            ));
        }
        $this->add(array(
            "name"  =>  "buscar",
            "options"   =>array(
                "label"    => "Correo : "
            ),
            "attributes"=>array(
                "id"  =>  "buscar",
                "type"  =>  "text",
                "class" =>  "input-medium search-query"
            )
        ));
        
        //BOTONES SUBMIT
        $this->add(array(
            "name"      =>"crear",
            "attributes"=>array(
                "type"=>"submit",
                "class"=>"btn btn-primary",
                "value"=>"Crear Usuario"

            )
        ));
        $this->add(array(
            "name"  =>  "serch",
            "attributes"    =>  array(
                "type"  =>  "submit",
                "class" =>  "btn",
                "value" =>  "Buscar"
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
        $dataResult['']='--Seleccione un perfl--';
        foreach ($resultSelect as $res){
            $dataResult[$res->getPerfilId()]=$res->getPerfilNombre();
        }
        return $dataResult;
    }
    
    private function getPermisos() {
        $dataResult = array();
        $dbh = new \Login\Model\DataBaseHelper($this->em);
        $resultSelect = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Permiso p');
        foreach ($resultSelect as $res){
            $dataResult[$res->getPermisoId()]=$res->getPermisoTipo();
        }
        return $dataResult;
    }
}
