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
use Zend\Db\Adapter\AdapterInterface;
class FormAdmin extends Form {
    protected $adapter;
    public function __construct(AdapterInterface $dbAdapter) {
        $this->setAdapter($dbAdapter);
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
            "name"      =>"telefono",
            "options"   =>array(
                "label"=>"Telefono : "
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"form-control"
            )
        ));
        
        $this->add(array(
            "name"      =>"direccion",
            "options"   =>array(
                "label"=>"Direccion : "
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
    }
    
    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }
    
    public function getOptionsPerfil() {
        $resultSelect = new \Login\Model\Entity\Perfil($this->adapter);
        $dataResult = array();
        foreach ($resultSelect->getAllPerfil() as $res){
            $dataResult[$res['id_perfil']]=$res['nombre_perfil'];
        }
        return $dataResult;
    }

}
