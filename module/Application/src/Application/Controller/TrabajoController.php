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
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Session\Container;
 class TrabajoController extends AbstractActionController{
     
     
     
     public function indexAction() {
         $this->layout()->titulo="Trabajo";
         $containerSess = new Container('cbol');
        $session = $containerSess->getDefaultManager()->
        print_r($session->getId());
         return new ViewModel();
     }
     public function formularioAction() {
         $this->layout()->titulo="Formulario";
         $request = $this->getRequest();
         $formularioIng = new Formularios();
                  
         return new ViewModel(array("cargaForm"=>$formularioIng,"url"=>$this->getRequest()->getBaseUrl()));
     }
     public function obtenerAction() {
        $validate = $this->getRequest()->getPost();
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $authAdapter = new AuthAdapter($adapter, 'usuarios', 'nombre_usuario','password_ususario');
        $authAdapter->setIdentity($validate['nombre']);
        $authAdapter->setCredential(md5($validate['password']));

        $auth = new AuthenticationService();
        $resultado = $auth->authenticate($authAdapter);

        switch ($resultado->getCode()){
           case Result::FAILURE_IDENTITY_NOT_FOUND :
               return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/trabajo/formulario');
               break;
           case Result::FAILURE_CREDENTIAL_INVALID :
               return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/trabajo/formulario');
               break;
           case Result::SUCCESS:
               $store = $auth->getStorage();
               $store->write($authAdapter->getResultRowObject(null,'password'));
               echo 'Se ha autenticado correctamente :D';
               break;
           default :
               echo 'Mensaje por defecto';
               break;
        }
        return new ViewModel();
     }
 }