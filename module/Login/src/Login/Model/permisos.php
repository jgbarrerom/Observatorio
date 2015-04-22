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
        
        $this->addResource(new Resource('vias'));
        $this->addResource(new Resource('administrador'));
        
        $this->deny(3, 'vias');
        $this->allow(4, 'vias');
        
        $this->allow(1,'administrador');
    }
}


