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

use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class LoginController extends AbstractActionController {
    private $message;
    //put your code here
    public function ingresoAction() {
        $this->layout()->titulo='.::Login::.';
        $validate = $this->getRequest()->getPost();
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $authAdapter = new AuthAdapter($adapter, 'usuarios', 'nombre_usuario', 'password_usuario');
        $authAdapter->setIdentity($validate['nombre']);
        $authAdapter->setCredential(md5($validate['password']));

        $auth = new AuthenticationService();
        $resultado = $auth->authenticate($authAdapter);

        switch ($resultado->getCode()) {
            case Result::FAILURE_IDENTITY_NOT_FOUND :
                $this->message = "Usuario y/o contraseña incorrectos";
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login/index/'.$this->message);
                break;
            case Result::FAILURE_CREDENTIAL_INVALID :
                $this->message = "Usuario y/o contraseña incorrectos";
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login/index/'.$this->message);
                break;
            case Result::SUCCESS:
                $store = $auth->getStorage();
                $store->write($authAdapter->getResultRowObject(null, 'password'));
                $sessionConfig = new SessionConfig();
                $sessionConfig->setOptions(array(
                    'remember_me_seconds' => 180,
                    'use_cookies' => true,
                    'cookie_httponly' => true
                ));
                $sessionManager = new SessionManager();
                $sessionManager->regenerateId(false);
                $sessionManager->start();
                Container::setDefaultManager($sessionManager);
                $container = new Container('cbol');
                $container->setDefaultManager($sessionManager);
                if (!isset($container->init)) {
                    
                    //print_r($sessionManager->getId());
                    
                }
                break;
            default :
                echo 'Mensaje por defecto';
                break;
        }
        return new ViewModel();
    }

    public function indexAction() {
        $formLogin = new FormularioLogin();
        return new ViewModel(array("formLogin" => $formLogin, 
                                   "url"       => $this->getRequest()->getBaseUrl(),
                                   "mesage"    => $this->message));
    }

}
