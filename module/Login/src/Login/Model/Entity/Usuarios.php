<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login\Model\Entity;

/**
 * Description of Ususarios
 *
 * @author Jeisson
 */

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Usuarios extends TableGateway {

    private $idUser;
    private $nickname;
    private $password;
    private $apellido;
    private $correo;
    private $telefono;
    private $direccion;
    private $idPerfil;
    

    public function __construct(Adapter $adapter = null, $databaseSchema = null, Resulset $selecResulPrototype = null) {
        return parent::__construct('usuarios', $adapter, $databaseSchema, $selecResulPrototype);
    }
    
    public function getIdUser() {
        return $this->idUser;
    }

    public function getNickname() {
        return $this->nickname;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getIdPerfil() {
        return $this->idPerfil;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function setNickname($nickname) {
        $this->nickname = $nickname;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

        
    /*
     * Metodos para las consultas
     */
    public function checkUsser() {
        $resulSet = $this->select();
        return $resulSet->toArray();
    }
    
    public function getArrayLogin($param) {
        $this->nickname = $param['nombre'];
        $this->password = $param['password'];
        
    }
    /**
     * Meodo para almacenar un nuevo usuario o modificar uno exsitente
     * @param \Login\Model\Entity\Usuarios $user
     */
    public function saveUsuario(Usuarios $user) {
        if($user->idUser){
            $this->insert($user);
        }  else {
            $this->update($user, $user->idPerfil);
        }
    }

}
