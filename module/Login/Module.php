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
        $e->getTarget()->layout()->reportes = $containerSession->reportesVias;
        
        if(($controllerName != 'login' ) && ($controllerName != 'application' && $controllerName != 'home')){
            //if ($e->getRequest()->getRequestUri() != 'Observatorio_cb/public/login') {
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
                    //redireccionar a pagina de que no tiene permiso para acceder a este recurso
                    $url = $e->getRequest()->getBaseUrl() .'/error/403';
                    $response->getHeaders()->addHeaderLine('Location', 'error/403');
                    $response->setStatusCode(403);
                    $response->sendHeaders();
                    return $response;
                }
            }
        }
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
