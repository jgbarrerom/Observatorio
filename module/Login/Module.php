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

use Zend\Mvc\ModuleRouteListener;
use Zend\Session\Container;

class Module {

    public function onBootstrap(\Zend\Mvc\MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH, array(
            $this,
            'afterDispatch'
                ), -100);
    }

    public function afterDispatch(\Zend\Mvc\MvcEvent $e) {
        $auth = new \Zend\Authentication\AuthenticationService();
        if($e->getRequest()->getRequestUri()!='/observatorio_cb/public/login'){;
            if (!$auth->hasIdentity()) {
                $response = $e->getResponse();
                $url = $e->getRequest()->getBaseUrl() . '/login';

                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                return $response;
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
