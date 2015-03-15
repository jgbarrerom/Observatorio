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

    function init() {
        $this->addRole(new Role('usuario_vias'))
                ->addRole(new Role('usuario_educacion'))
                ->addRole(new Role('usuario_salud'))
                ->addRole(new Role('admin'));
        $this->addResource(new Resource('ingresarVia'));
        
        $this->deny('usuario_salud', 'ingresarVia');
        $this->allow('usuario_vias', 'ingresarVia');
    }
    
}
