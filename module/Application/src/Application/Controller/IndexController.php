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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Application\Model\Entity\Usuarios;
use Application\Model\Entity\PruebaGrafica;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class IndexController extends AbstractActionController
{
private $adapter;
    public function indexAction(){
        
        $this->layout()->titulo="Observatorio"; 
        $this->adapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        //var_dump($this->adapter);
        //$resul = $this->adapter->query('SELECT * FROM ususarios',  Adapter::QUERY_MODE_EXECUTE);
        //$datos = $resul->toArray();
        $usser = new Usuarios($this->adapter);
        return new ViewModel(array('resultado'=>  $usser->checkUsser()));
    }
    public function resultAction(){
        $sesion = new Container('cbol');
        $sesion->id = 23;
        $sesion->nombre = 'jeisson';
        $this->layout()->titulo = "highChart";
        $this->adapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $grafica = new PruebaGrafica($this->adapter);
        $graficar = $grafica->charsZF();
        $contador = count($graficar);
        $scritp = "";
        foreach ($graficar as $value){
            $scritp .= "{name : '" . trim($value['grafica_nombre']) . "',";
            $scritp .=  "data : [" . trim($value['grafica_valor1']) . "," . trim($value['grafica_valor2']) . "," . trim($value['grafica_valor3']) . "]},";
        }
        substr_replace($scritp, "", -1);
        return new ViewModel(array('graficar' =>  $scritp, 'session' => $sesion->id));
    }
    public function validateAction(){
        /*$config = new StandardConfig();
        $config->setOptions(array(
            'remember_me_seconds' => 1800,
            'name'                => 'cbol',
        ));
        $manager = new SessionManager($config);*/
        
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions(array(
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true
        ));
        $sessionManager = new SessionManager();
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
        $container = new Container('cbol');
        if(!isset($container->init)){
            $sessionManager->regenerateId(true);
            
        }
    }
    
    public function index3Action() {
        $this->layout()->titulo = '';
        $session = new Container('cbol');
        return new ViewModel(array('session' => $session->nombre));
    }

    public function index2Action() {
        $this->layout()->titulo = 'POLYLINE';
        return new ViewModel();
    }
}
