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
        $contenedor = new Container('col');
        $sessi = $contenedor->getDefaultManager();
        $sessi->destroy();
        $sessi->expireSessionCookie(); 
        print_r($sessi->getId());
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
        return new ViewModel(array('graficar' =>  $scritp));
    }
        public function validateAction(){
            $container = new Container('cbol');
            $sessionM = $container->getDefaultManager();
            print_r($sessionM->getId());
            return new ViewModel();
    }
    
    public function index3Action() {
        $this->layout()->titulo = '';
        $container = new Container('cbol');
        $session = $container->getDefaultManager();
        return new ViewModel(array('session' => $session->getId()));
    }

    public function index2Action() {
        $this->layout()->titulo = 'POLYLINE';
        return new ViewModel();
    }
}
