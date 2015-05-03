<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login\Model;

/**
 * Description of DataBaseHelper
 *
 * @author JeissonGerardo
 */
class DataBaseHelper {

    private $respuesta;
    private $em;

    /**
     * Constructor que recibe el EntityManager
     * @param type $em
     */
    public function __construct($em) {
        $this->respuesta = true;
        $this->em = $em;
    }

    /**
     * Metodo para realizar un SELECT * FROM,
     * recibe el path de la entidad
     * @param String $obj
     * @return type
     */
    public function selectAll($obj) {
        $data = $this->em->getRepository($obj)->findAll();
        return $data;
    }
    
    public function selectAllById(array $arrayIds,$obj) {
        $data = $this->em->getRepository($obj)->findById($arrayIds);
        return $data;
    }

    /**
     * Metodo para realizar un INSER en cualquier tabla
     * @param type $obj
     * @return type
     */
    public function insertObj($obj) {
        try {
            $this->em->persist($obj);
            $this->em->flush();
            return true;
        } catch (\Doctrine\ORM\Persisters\PersisterException $p) {
            return false;
        }
    }

    /**
     * Metodo para actualizar cualquier campo de la DB
     * @param type $obj
     * @return type
     */
    public function updateObj($obj) {
        return $this->respuesta;
    }

    /**
     * Metodo para borrar cualquier campo de la DB
     * @param type String $id id a borrar
     * @return type boolean
     */
    public function deleteObj($obj) {
        try {
            $this->em->remove($obj);
            $this->em->flush();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Metodo para hacer un SELECT * FORM XXX WHERE YYY
     * @param type $param nombre de la entidad
     * @param array $where
     */
    public function selectWhere($param, array $where = null) {
        $query = $this->em->createQuery($param);
        if ($where != null) {
            foreach ($where as $campo => $variable) {
                $query->setParameter($campo, $variable);
            }
        }
        $resultado = $query->getResult();
        return $resultado;
    }

    public function selectWhereArray($param, array $where = null) {
        $query = $this->em->createQuery($param);
        if ($where != null) {
            foreach ($where as $campo => $variable) {
                $query->setParameter($campo, $variable);
            }
        }
        return $query->getArrayResult();
    }
    
     public function selectWhereJson($param, array $where = null) {
        $query = $this->em->createQuery($param);
        if ($where != null) {
            foreach ($where as $campo => $variable) {
                $query->setParameter($campo, $variable);
            }
        }
        return $query->getArrayResult();
    }
}
