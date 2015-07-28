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
            $authAdapter = new AuthAdapter($this->adapter(), 'usuario', 'usuario_correo', 'usuario_password');
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
                    $this->flashMessenger()->clearMessages();
                    $store = $auth->getStorage();
                    $store->write($authAdapter->getResultRowObject(null, 'usuario_password'));
                    $sessionConfig = new StandardConfig();
                    
                    $sessionConfig->setRememberMeSeconds(20)
                                  ->setCookieLifetime(30)
                                  ->setCookieSecure(true)
                                  ->setGcMaxlifetime(60)
                                  ->setGcDivisor(60);
                    $sesionMa = new SessionManager($sessionConfig);
                    $sesionMa->rememberMe(30);
                    $container = new Container('cbol');
                    $container->setExpirationSeconds(1800);
                    
                    $sesionMa->start();
                    $container->idSession = $auth->getIdentity()->perfil_id;
                    $permisos = $this->getPermisos($auth->getIdentity()->usuario_id);
                    $container->permisosUser = $permisos;
                    $indexProfile = \Login\IndexAllProfile::listIndexAllProfiles($auth->getIdentity()->perfil_id);
                    if($indexProfile == 'vias'){
                        $container->reportesVias = $this->getReportesViales();
                    }
                    $container->setDefaultManager($sesionMa);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . "/$indexProfile");
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
        $auth = new \Zend\Authentication\AuthenticationService();
        if (!$auth->hasIdentity()) {
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
        } else {
            $indexProfile = \Login\IndexAllProfile::listIndexAllProfiles($auth->getIdentity()->perfil_id);
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . "/$indexProfile");
        }
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
    
    /**
     * 
     * @param type $idUsuario
     * @return type
     */
    protected function getPermisos($idUsuario){
        $arrayUser = $this->dbh()->selectAllById(array('usuarioId'=>$idUsuario), '\Login\Model\Entity\Usuario');
        $usuario = $arrayUser[0];
        return $usuario->getArrayOnlyId();
    }
    
    /**
     * Busca los reportes viales que no se han leido
     * @return type
     */
    private function getReportesViales() {
        $arrayReport = $this->dbh()->selectWhere('SELECT COUNT(r) sinleer FROM \Login\Model\Entity\ReporteVia r WHERE r.reporteviaLeido = 0');
        return $arrayReport[0]['sinleer'];
    }
    
    /**
     * Action JSON obtiene los datos
     * @return \Zend\View\Model\JsonModel
     */
    public function changeAction() {
        $datos = $this->getRequest()->getPost();
        $auth = new AuthenticationService();
        $objUsuario = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId =:i AND u.usuarioPassword =:p', 
                    array(
                        'i' =>  $auth->getIdentity()->usuario_id,
                        'p' =>  md5($datos['act'])
                    )   
                );
        if((!is_null($objUsuario)) && ($datos['newpass'] == $datos['reppass'])){
            if($this->newPassword($objUsuario[0],$datos['newpass'])){
                return new \Zend\View\Model\JsonModel(array('Status'=>  'OK'));
            }else{
                return new \Zend\View\Model\JsonModel(array('Status'=>  'NOK'));
            }
        }else{
            
        }
    }
    
    /**
     * Metodo para realiza cambio de contraseña
     * @param type $objUser
     * @param type $pass
     * @return boolean
     */
    private final function newPassword($objUser,$pass) {
        $objUser->setUsuarioPassword(md5($pass));
        return $this->dbh()->insertObj($objUser);
    }
    
    /**
     * Adaptador para conexion a Data Base
     * @return \Zend\Db\Adapter\Adapter
     */
    private final function adapter(){
        return $this->getServiceLocator()->get('Zend\Db\Adapter');
    }
}
