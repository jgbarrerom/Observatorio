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
use Administrador\Form\FormAdmin;
use Zend\Session\Container;

class IndexController extends AbstractActionController {

    public function addAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Crear Usuarios::.';
        $formAddUser = new FormAdmin($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $url = $this->getRequest()->getBaseUrl() . '/admin/confirmSave';
        return new ViewModel(array("formAdd" => $formAddUser, 'url' => $url));
    }

    public function consultarUsuarioAction() {
        return new ViewModel();
    }

    public function indexAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Administrador::.';
        return new ViewModel();
    }

    public function confirmSaveAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Confimar Creacion::.';
        $data = $this->getRequest()->getPost();
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $perfil = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId = :id', array('id' => $data['perfil']));

        $usuario = new \Login\Model\Entity\Usuario();
        $usuario->setUsuarioNombre($data['nombre']);
        $usuario->setUsuarioApellido($data['apellido']);
        $usuario->setUsuarioCorreo($data['correo']);
        $usuario->setPerfil($perfil[0]);
        $pass = substr(md5(microtime()), 1, 8);
        $usuario->setUsuarioPassword(md5($pass));
        if ($dbh->insertObj($usuario)) {
            $usuario->setUsuarioPassword($pass);
//            $mail = new \Administrador\SendMail();
//            $mail->contruirCorreo();
            return new ViewModel(array(
                'objUsuario' => $usuario,
                'url' => $this->getRequest()->getBaseUrl()));
        } else {
            return new ViewModel(array('msg' => 'Ha ocurrido un error al insertar el usuario'));
        }
    }

    public function cancelAction() {
        var_dump($this->getRequest()->getPost());
    }

}
