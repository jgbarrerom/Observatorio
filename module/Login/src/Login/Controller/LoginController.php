<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author JeissonGerardo
 */

namespace Login\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Login\Form\FormularioLogin;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Session\Config\StandardConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class LoginController extends AbstractActionController {

    private $message;

    /**
     * Metodo para validar acceso al portal
     * @return \Zend\View\Model\ViewModel
     */
    public function ingresoAction() {
        if ($this->getRequest()->isPost()) {
            $auth = new AuthenticationService();
            $validate = $this->getRequest()->getPost();
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter');            
            $authAdapter = new AuthAdapter($adapter, 'usuario', 'usuario_correo', 'usuario_password');
            $authAdapter->setIdentity($validate['correo']);
            $authAdapter->setCredential(md5($validate['password']));


            $resultado = $auth->authenticate($authAdapter);

            switch ($resultado->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND :
                    $this->message = "Usuario y/o contraseña incorrectos";
                    $this->flashMessenger()->addMessage($this->message);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID :
                    $this->message = "Usuario y/o contraseña incorrectos";
                    $this->flashMessenger()->addMessage($this->message);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
                    break;
                case Result::SUCCESS:
                    $this->layout('layout/admin');
                    $this->layout()->titulo = '.::Bienvenido::.';
                    $this->flashMessenger()->clearMessages();
                    $store = $auth->getStorage();
                    $store->write($authAdapter->getResultRowObject(null, 'usuario_password'));
                    $sessionConfig = new StandardConfig();
                    $sessionConfig->setOptions(array(
                        'remember_me_seconds' => 1800,
                        'use_cookies'     => false,
                        'cookie_httponly' => true,
                        'cache_expire'    => 5
                    ));
                    $sesionMa = new SessionManager($sessionConfig);
                    
                    $container = new Container('cbol');
                    $sesionMa->start();
                    $container->setDefaultManager($sesionMa);

                    $container->objIdentity = $auth->getIdentity();
                    
                    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                    $data = $em->getRepository('Login\Model\Entity\Eje')->findAll();
                    $dataSesion = array();
                    $dataSelect = array();
                    foreach ($data as $value) {
                        $dataSelect[$value->getEjeId()] = $value;
                    }
                    $dataSesion['eje']=$dataSelect;
                                        
                    $data = $em->getRepository('Login\Model\Entity\Perfil')->findAll();
                    $dataSelect = array();
                    foreach ($data as $value) {
                        $dataSelect[$value->getPerfilId()] = $value;
                    }
                    $dataSesion['perfil']=$dataSelect;
                    
                    $data = $em->getRepository('Login\Model\Entity\Estado')->findAll();
                    $dataSelect = array();
                    foreach ($data as $value) {
                        $dataSelect[$value->getPerfilId()] = $value;
                    }
                    $dataSesion['estado']=$dataSelect;
                    $container->DataSesion = $dataSesion;
                    break;
                default :
                    echo 'Mensaje por defecto';
                    break;
            }
            return new ViewModel();
        }
    }

    /**
     * Metodo para el index del formulario de login
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        $this->layout('layout/login');
        $this->layout()->titulo = '.::Ingreso::.';
        $formLogin = new FormularioLogin();
        return new ViewModel(
                array(
                    "formLogin" => $formLogin,
                    "url" => $this->getRequest()->getBaseUrl(),
                    "message" => $this->flashMessenger()->getMessages(),
                )
        );
    }

    /**
     * Metodo para cerrar la sesion 
     * @return \Zend\View\Model\ViewModel
     */
    public function logoutAction() {
        $content = new Container("cbol");
        $content->getDefaultManager()->getStorage()->clear();
        $this->layout('layout/login');
        $auth = new \Zend\Authentication\AuthenticationService();
        $auth->getStorage()->clear();
        //$auth->clearIdentity();
        //unset(Container::getDefaultManager());
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
    }

}
