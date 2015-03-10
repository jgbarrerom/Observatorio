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
        $this->respuesta = false;
        $this->em = $em;
    }
    
    /**
     * Metodo para realizar un SELECT * FROM,
     * recibe el path de la entidad
     * @param String $obj
     * @return type
     */
    public function selectAll($obj){
        $data = $this->em->getRepository($obj)->findAll();
        return $data;
    }
    
    /**
     * Metodo para realizar un INSER en cualquier tabla
     * @param type $obj
     * @return type
     */
    public function insertObj($obj) {
        $this->em->persist($obj);
        $this->em->flush();
        return $this->respuesta;
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
     * @param type $obj
     * @return type boolean
     */
    public function deleteObj($obj) {
        $this->em->remove($obj);
        return $this->respuesta;
    }
    
    /**
     * Metodo para hacer un SELECT * FORM XXX WHERE YYY
     * @param type $param nombre de la entidad
     * @param array $where
     */
    public function selectWhere($param,array $where) {
        $query = $this->em->createQuery($param);
        foreach ($where as $campo => $variable){
            $query->setParameter($campo,$variable);
        }
        $resultado = $query->getResult();
        return $resultado;
    }
}