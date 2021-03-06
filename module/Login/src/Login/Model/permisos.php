<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permission
 *
 * @author NATHALY
 */

namespace Login\Model;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class permisos extends Acl {
/**
 * Lista de roles
 * 1=admin
 * 2=Educacion
 * 3=Salud
 * 4=Vias
 * crear
 * editar-borrar
 */
    function __construct() {
        $this->addRole(new Role(1))
             ->addRole(new Role(2))
             ->addRole(new Role(3))
             ->addRole(new Role(4));
        
        $this->addResource(new Resource('administrador'));
        $this->addResource(new Resource('vias'));
        $this->addResource(new Resource('salud'));
        $this->addResource(new Resource('educacion'));
        $this->addResource(new Resource('application'));
        
        $this->deny(1, 'vias');
        $this->deny(2, 'vias');
        $this->deny(3, 'vias');
        
        $this->deny(1, 'salud');
        $this->deny(2, 'salud');
        $this->deny(4, 'salud');
        
        $this->allow(1, 'application');
        $this->allow(2, 'application');
        $this->allow(3, 'application');
        $this->allow(4, 'application');
        
        $this->allow(1,'administrador');
        $this->allow(2,'educacion');
        $this->allow(3,'salud');
        $this->allow(4,'vias');
    }
    
    /**
     * Metodo que comprueba si el usuario tiene permiso para modificar, crear o eliminar
     * 1 = Crear
     * 2 = Editar
     * 3 = Borrar
     * @param type $permiso
     * @return boolean
     */
    public static function validarPermiso($permiso) {
        $container = new \Zend\Session\Container('cbol');
        if($container->permisosUser != NULL){
            return in_array($permiso, $container->permisosUser);
        }else{
            return false;
        }
    }
    
    
}


