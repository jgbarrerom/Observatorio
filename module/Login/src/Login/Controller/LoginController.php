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
                case Result::FAILURE_CREDENTIAL_INVALID :
                    $this->message = "Usuario y/o contraseña incorrectos";
                    $this->flashMessenger()->addMessage($this->message);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
                case Result::SUCCESS:
                    $this->layout('layout/admin');
                    $this->layout()->titulo = '.::Bienvenido::.';
                    $this->flashMessenger()->clearMessages();
                    $store = $auth->getStorage();
                    $store->write($authAdapter->getResultRowObject(null, 'usuario_password'));
                    $sessionConfig = new StandardConfig();
                    $sessionConfig->setOptions(array(
                        'remember_me_seconds' => 8,
                        'use_cookies'     => false,
                        'cookie_httponly' => true,
                        'cache_expire'    => 5
                    ));
                    $sesionMa = new SessionManager($sessionConfig);
                    
                    $container = new Container('cbol');
                    $sesionMa->start();
                    $container->setDefaultManager($sesionMa);
                    
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/admin');
                default :
                    echo 'Mensaje por defecto';
                    break;
            }
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
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
    }

}
