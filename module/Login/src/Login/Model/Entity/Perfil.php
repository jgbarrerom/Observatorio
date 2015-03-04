<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login\Model\Entity;

/**
 * Description of Perfil
 *
 * @author JeissonGerardo
 */
use Zend\Db\TableGateway\TableGateway;

class Perfil extends TableGateway{
    private $idPerfil;
    private $nombre;
    private $idEje;
    
    public function __construct(\Zend\Db\Adapter\AdapterInterface $adapter, $features = null, \Zend\Db\ResultSet\ResultSetInterface $resultSetPrototype = null, \Zend\Db\Sql\Sql $sql = null) {
        parent::__construct("perfil", $adapter, $features, $resultSetPrototype, $sql);
    }
    
    public function getAllPerfil() {
        $result = $this->select();
        return $result->toArray();
    }
}
