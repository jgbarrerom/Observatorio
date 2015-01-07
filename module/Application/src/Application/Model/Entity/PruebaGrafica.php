<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model\Entity;

/**
 * Description of PruebaGrafica
 *
 * @author Jeisson
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class PruebaGrafica extends TableGateway{
    public function __construct(Adapter $adapter, $features = null, \Zend\Db\ResultSet\ResultSetInterface $resultSetPrototype = null, \Zend\Db\Sql\Sql $sql = null) {
        parent::__construct('prueba_grafica', $adapter, $features, $resultSetPrototype, $sql);
    }
    public function charsZF(){
        $resulset = $this->select();
        return $resulset->toArray();
    }
}
