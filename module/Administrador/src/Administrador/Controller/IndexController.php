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

    public function addAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Crear Usuarios::.';
        $formAddUser = new FormAdmin($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $url = $this->getRequest()->getBaseUrl() . '/admin/confirmSave';
        return new ViewModel(array("formAdd" => $formAddUser, 'url' => $url));
    }

    public function consultarUsuarioAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Lista De Usuarios::.';
//        $perfiles = $dbh->selectWhereJson('SELECT p.perfilNombre label,p.perfilId value FROM \Login\Model\Entity\Perfil p WHERE p.perfilId <> 1');
        return new ViewModel();
    }

    public function listaUsuarioAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayUser = $this->arrayUser($dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId <> 1'));
        return new JsonModel($arrayUser);
    }
    
    public function indexAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Administrador::.';
        return new ViewModel();
    }

    public function confirmSaveAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Confimar Creacion::.';
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $data = $this->getRequest()->getPost();
        $perfil = $this->serchPerfil($data['perfil']);
        $usuario = new \Login\Model\Entity\Usuario();
        $usuario->setUsuarioNombre($data['nombre']);
        $usuario->setUsuarioApellido($data['apellido']);
        $usuario->setUsuarioCorreo($data['correo']);
        $usuario->setPerfil($perfil);
        $pass = substr(md5(microtime()), 1, 8);
        $usuario->setUsuarioPassword(md5($pass));
        if ($dbh->insertObj($usuario)) {
            $usuario->setUsuarioPassword($pass);
//            $mail = new \Administrador\SendMail();
//            $mail->contruirCorreo();
            return new ViewModel(array('objUsuario' => $usuario));
        } else {
            return new ViewModel(array('msg' => 'Ha ocurrido un error al insertar el usuario por favor intente mas tarde'));
        }
    }

    public function editAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        var_dump($jsonView);
        $usuario = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId = :id', array('id' => $jsonView['usuarioId']));
        $updateUser = $usuario[0];
        $updateUser->setUsuarioNombre($jsonView['nombre']);
        $updateUser->setUsuarioApellido($jsonView['apellido']);
        $updateUser->setUsuarioCorreo($jsonView['mail']);
        $perfil = $this->serchPerfil($jsonView['perfil']);
        $updateUser->setPerfil($perfil);
        $dataUpdate = array(
            'Resut' => 'OK'
        );
        if ($dbh->insertObj($updateUser)) {
            return new JsonModel($dataUpdate);
        }
    }
    
    public function deleteAction() {
        $dbh->deleteObj($usuario[0]);
        return new JsonModel();
    }

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

    private function arrayUser(array $usuarioArray) {
        $arrayJason = array();
        foreach ($usuarioArray as $key => $value) {
            $arrayJason[$key]=array(
                'Id'=>$value->getUsuarioId(),
                'Nombre'=>$value->getUsuarioNombre(),
                'Apellido'=>$value->getUsuarioApellido(),
                'Correo'=>$value->getUsuarioCorreo(),
                'perfil'=>$value->getPerfil()->getPerfilId(),
            );
        }
        $arrayUser = array(
            'Result'=>'OK',
            'Records'=>$arrayJason
            );
        
        return $arrayUser;
    }

}
