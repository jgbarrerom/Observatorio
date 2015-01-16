<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\Formularios;
use Application\Model\FormulariosAuth;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
 class TrabajoController extends AbstractActionController{
     
     
     
     public function indexAction() {
         $this->layout()->titulo="Trabajo";
         return new ViewModel();
     }
     public function formularioAction() {
         $this->layout()->titulo="Formulario";
         $request = $this->getRequest();
         $formularioIng = new Formularios();
         if($request->isPost()){
             $authForm = new FormulariosAuth();
             $formularioIng->setInputFilter($authForm->getInputFilter());
             $formularioIng->setData($request->getPost());
             if($formularioIng->isValid()){
                 $data = $formularioIng->getData();
                 $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
                 $authAdapter = new AuthAdapter($adapter, 'usuarios', 'nombre_usuario','password_ususario');
                 $authAdapter->setIdentity($data['nombre']);
                 $authAdapter->setCredential($data['password']);
                 
                 $auth = new AuthenticationService();
                 $resultado = $auth->authenticate($authAdapter);
                 
                 
                 echo 'El codigo de resultado fue ' . $resultado->getCode();
             }
         }
         
         return new ViewModel(array("cargaForm"=>$formularioIng,"url"=>$this->getRequest()->getBaseUrl()));
     }
     public function obtenerAction() {
         return new ViewModel();
     }
 }