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
        $containerSession = new \Zend\Session\Container('cbol');
        $e->getTarget()->layout()->repo = $containerSession->reportesVias;
        $e->getTarget()->layout()->acceso = $containerSession->permisosUser;
        $e->getTarget()->layout()->suge = $containerSession->sugerencias;
        $e->getTarget()->layout()->ft = ($containerSession->firstTime == NULL)?'true':'false';
        if(($controllerName != 'login' ) && ($controllerName != 'application' && $controllerName != 'home')){
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
                    $this->onDispatchError($e);
                }
                elseif (is_null($containerSession->idSession)){
                    $url = $e->getRequest()->getBaseUrl() . '/login/logout';
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                    return $response;
                }elseif ($e->getResponse()->getStatusCode() == 403) {
                    $this->onDispatchError($e);
                }
            }
        }
    }
    
    public function onDispatchError(MvcEvent $e){
            $app = $e->getApplication();
            $sm = $app->getServiceManager();
            $viewModel = $e->getViewModel();
            $content = new \Zend\View\Model\ViewModel();
            $content->setTemplate('error/403');
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
