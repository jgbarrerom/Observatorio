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

    /**
     *
     * @var boolean
     */
    private $respuesta;
    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    private $em;

    /**
     * Constructor que recibe el EntityManager
     * @param type $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->respuesta = true;
        $this->em = $em;
    }

    /**
     * 
     * @param String $obj
     * @return array
     */
    public function selectAll($obj) {
        $data = $this->em->getRepository($obj)->findAll();
        return $data;
    }

    /**
     * 
     * @param array $arrayIds
     * @param String $obj
     * @return type
     */
    public function selectAllById(array $arrayIds, $obj) {
        $data = $this->em->getRepository($obj)->findBy($arrayIds);
        return $data;
    }
    
    /**
     * 
     * @param type $entity
     * @param type $id
     * @return type
     */
    public function selectById($entity,$id) {
        return $this->em->getRepository($entity)->find($id);
    }

    /**
     * Metodo para realizar un INSER en cualquier tabla
     * @param type $obj
     * @return boolean
     */
    public function insertObj($obj) {
        try {
            $this->em->persist($obj);
            $this->em->flush();
            return true;
        } catch (\Doctrine\DBAL\DBALException $dba) {
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
        try {
            $query = $this->em->createQuery($param);
            if ($where != null) {
                foreach ($where as $campo => $variable) {
                    $query->setParameter($campo, $variable);
                }
            }
            $resultado = $query->getResult();
            return $resultado;
        } catch (Doctrine\ORM\Query\QueryException $ex) {
            return NULL;
        }
    }

    /**
     * 
     * @param type $param
     * @param array $where
     * @return type
     */
    public function selectWhereArray($param, array $where = null) {
        try {
            $query = $this->em->createQuery($param);
            if ($where != null) {
                foreach ($where as $campo => $variable) {
                    $query->setParameter($campo, $variable);
                }
            }
            return $query->getArrayResult();
        } catch (Exception $exc) {
            return NULL;
        }
    }

    /**
     * 
     * @param type $param
     * @param array $where
     * @return type
     */
    public function selectWhereJson($param, array $where = null) {
        try {
            $query = $this->em->createQuery($param);
            if ($where != null) {
                foreach ($where as $campo => $variable) {
                    $query->setParameter($campo, $variable);
                }
            }
            return $query->getArrayResult();
        } catch (Exception $exc) {
            return NULL;
        }
    }

    /**
     * 
     * @param type $query
     * @param array $params
     * @return array
     */
    public function nativeQuery($query, array $params = null) {
        try {
            $qr = $this->em->createNativeQuery($query, new \Doctrine\ORM\Query\ResultSetMapping());
            if ($params != null) {
                $qr->setParameter($params);
            }
            $result = $qr->getResult();
            //$this->em->flush();
            return $result;
        } catch (Exception $exc) {
            return NULL;
        }
    }

}
