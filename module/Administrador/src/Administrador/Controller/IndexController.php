<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Administrador\Controller;

/**
 * Description of AdministracionUsuarioController
 *
 * @author JeissonGerardo
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Administrador\Form\FormAdmin;

class IndexController extends AbstractActionController {

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Crear Usuarios::.';
        $formAddUser = new FormAdmin($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $url = $this->getRequest()->getBaseUrl() . '/admin/confirmSave';
        return new ViewModel(array("formAdd" => $formAddUser, 'url' => $url));
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function consultarUsuarioAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Lista De Usuarios::.';
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayUser = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId <> 1');
        //var_dump($arrayUser[0]->getPermiso());
        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function listaUsuarioAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayUser = $this->arrayUser($dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId <> 1'));
        return new JsonModel($arrayUser);
    }
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Administrador::.';
        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function confirmSaveAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Confimar Creacion::.';
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $data = $this->getRequest()->getPost();
        $arrayPermiso = array(1=>0,2=>0,3=>0,4=>0);
        foreach ($data->permisos as $key => $value){
            $arrayPermiso[$key+1]=$value;
        }
        $objPermisos = $dbh->selectWhere("SELECT p FROM \Login\Model\Entity\Permiso p WHERE p.permisoId IN (?1,?2,?3,?4)", $arrayPermiso);
        var_dump($dbh->selectAllById($arrayPermiso, "Login\Model\Entity\Permiso"));
        $perfil = $this->serchPerfil(array('id'=>$data['perfil']));
        $usuario = new \Login\Model\Entity\Usuario();
        $usuario->setUsuarioNombre($data['nombre']);
        $usuario->setUsuarioApellido($data['apellido']);
        $usuario->setUsuarioCorreo($data['correo']);
        $usuario->setPerfil($perfil);
        foreach ($objPermisos as $value){
            $usuario->addPermiso($value);
            $value->addUsuario($usuario);
        }
        $pass = substr(md5(microtime()), 1, 8);
        $usuario->setUsuarioPassword(md5($pass));
        if ($dbh->insertObj($usuario)) {//true){//
            $usuario->setUsuarioPassword($pass);
//            $mail = new \Administrador\SendMail();
//            $mail->contruirCorreo();
            return new ViewModel(array('objUsuario' => $usuario));
        } else {
            return new ViewModel(array('msg' => 'Ha ocurrido un error al insertar el usuario por favor intente mas tarde'));
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function editAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $usuario = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId = :id', array('id' => $jsonView['Id']));
        $updateUser = $usuario[0];
        $updateUser->setUsuarioNombre($jsonView['nombre']);
        $updateUser->setUsuarioApellido($jsonView['apellido']);
        $updateUser->setUsuarioCorreo($jsonView['correo']);
        $updateUser->setPerfil($this->serchPerfil(array('id'=>$jsonView['perfil'])));
        //$updateUser->getPermiso()->clear();
        //eliminar relacion r
        $arrayPermiso = array(1=>0,2=>0,3=>0,4=>0);
        foreach ($jsonView['permisos'] as $key => $value){
            $arrayPermiso[$key+1]=$value;
        }
        $permisos = $dbh->selectWhere("SELECT p FROM \Login\Model\Entity\Permiso p WHERE p.permisoId IN (?1,?2,?3,?4)", $arrayPermiso);
        foreach ($permisos as $value){
            $updateUser->addPermiso($value);
            $value->addUsuario($updateUser);
        }
        if ($dbh->insertObj($updateUser)) {
            return new JsonModel(array('Result' => 'OK'));
        }else{
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message'=>'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }
    
    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $usuario = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId = :id', array('id' => $jsonView['Id']));
        if($dbh->deleteObj($usuario[0])){
            return new JsonModel(array('Result'=>'OK'));
        }else{
            return new JsonModel(array(
                'Result'=>'ERROR',
                'Message'=>'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }
    /**
     * 
     * @param array $idPerfil
     * @return type
     */
    private function serchPerfil(array $idPerfil){
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $perfil = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId = :id',$idPerfil);
        return $perfil[0];
    }
    
    
    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function serchPerfilAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $perfil = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId <> 1');
        $arrayPerfil = array();
        foreach ($perfil as $key => $value) {
            $arrayPerfil[$key]=array(
                'DisplayText'=>$value->getPerfilNombre(),
                'Value'=>$value->getPerfilId()
            );
        }
        $arrayJson = array(
            'Result'=>'OK',
            'Options'=>$arrayPerfil
        );
        return new JsonModel($arrayJson);
    }

    /**
     * 
     * @param array $usuarioArray
     * @return type
     */
    private function arrayUser(array $usuarioArray) {
        $arrayJason = array();
        foreach ($usuarioArray as $key => $value) {
            $arrayJason[$key]=array(
                'Id'        =>  $value->getUsuarioId(),
                'Nombre'    =>  $value->getUsuarioNombre(),
                'Apellido'  =>  $value->getUsuarioApellido(),
                'Correo'    =>  $value->getUsuarioCorreo(),
                'perfil'    =>  $value->getPerfil()->getPerfilNombre(),
                'permisos'  =>  $value->getArrayPermiso()
            );
        }
        $arrayUser = array(
            'Result'=>'OK',
            'Records'=>$arrayJason
            );
        
        return $arrayUser;
    }
    
    public function permisoUsuarioAction(){
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $permiso = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Permiso p');
        $arrayPermiso = array();
        foreach ($permiso as $key => $value) {
            $arrayPermiso[$key]=array(
                'DisplayText'   =>  $value->getPermisoTipo(),
                'Value'         =>  $value->getPermisoId()
            );
        }
        $result = array(
            'Result'=>'OK',
            'Options'=>$arrayPermiso
        );
        return new JsonModel($result);
    }
    
}
