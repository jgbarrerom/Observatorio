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
    public function __construct($dbAdapter) {
        $this->setEm($dbAdapter);
        parent::__construct('formAdmin');
        
        $this->add(array(
            "name"      =>"nombre",
            "options"   =>array(
                "label"=>"Nombre : "
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"      =>"apellido",
            "options"   =>array(
                "label"=>"Apellidos : "
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"      =>"correo",
            "options"   =>array(
                "label"=>"Correo : "
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"form-control"
            )
        ));
                
        $this->add(array(
            "type"      => "Zend\Form\Element\Select",
            "name"      =>"perfil",
            "options"   =>array(
                "label"=>"Perfil : ",
                "value_options"=> $this->getOptionsPerfil()
            )
        ));
        
        $this->add(array(
            "name"      =>"crear",
            "attributes"=>array(
                "type"=>"submit",
                "class"=>"btn btn-primary",
                "value"=>"Crear Usuario"

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
        $query = $this->em->createQuery('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId <> 1');
        $resultSelect = $query->getResult();
        $dataResult[0]='';
        foreach ($resultSelect as $res){
            $dataResult[$res->getPerfilId()]=$res->getPerfilNombre();
        }
        return $dataResult;
    }

}
