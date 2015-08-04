<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author JeissonGerardo
 */

namespace Login;

use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this,'afterDispatch'), -100);
    }

    public function afterDispatch(MvcEvent $e) {
        $controllerName = $e->getRouteMatch()->getMatchedRouteName();
        if(($controllerName != 'login' ) && ($controllerName != 'application' && $controllerName != 'home')){
            $containerSession = new \Zend\Session\Container('cbol');
            $e->getTarget()->layout()->repo = $containerSession->reportesVias;
            $e->getTarget()->layout()->acceso = $containerSession->permisosUser;
            $e->getTarget()->layout()->suge = $containerSession->sugerencias;
            $auth = new \Zend\Authentication\AuthenticationService();
            $response = $e->getResponse();
            if (!$auth->hasIdentity()) {
                $url = $e->getRequest()->getBaseUrl() . '/login';
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                return $response;
            }else{
                $localAcl = new \Login\Model\permisos();
                if(!$localAcl->isAllowed($auth->getIdentity()->perfil_id,$controllerName)){
                    $this->onDispatchError($e,$controllerName);
                }
                elseif (is_null($containerSession->idSession)){
                    $url = $e->getRequest()->getBaseUrl() . '/login/logout';
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                    return $response;
                }elseif ($e->getResponse()->getStatusCode() == 403) {
                    $this->onDispatchError($e,$controllerName);
                }
            }
        }
    }
    
    public function onDispatchError(MvcEvent $e,$controllerName){
            $app = $e->getApplication();
            $sm = $app->getServiceManager();
            $viewModel = $e->getViewModel();
            $viewModel->setTemplate('error/403');
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
