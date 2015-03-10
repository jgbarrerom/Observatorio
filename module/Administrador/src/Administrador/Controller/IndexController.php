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

class IndexController extends AbstractActionController{
    
    public function addAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Crear Usuarios::.';
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formAddUser = new FormAdmin($adapter);
        return new ViewModel(array("formAdd"=>$formAddUser));
    }
    public function consultarUsuarioAction() {
        return new ViewModel();
    }
    
    public function indexAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Administrador::.';
        $contain = new Container('cbol');
        var_dump($contain->DataSesion);
        return new ViewModel();
    }
}
