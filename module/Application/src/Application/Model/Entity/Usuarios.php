<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model\Entity;

/**
 * Description of Ususarios
 *
 * @author Jeisson
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Usuarios extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, Resulset $selecResulPrototype = null) {
        return parent::__construct('usuarios', $adapter, $databaseSchema, $selecResulPrototype);
    }

    public function checkUsser() {
        $resulSet = $this->select();
        return $resulSet->toArray();
    }

}
