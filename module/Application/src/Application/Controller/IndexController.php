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
use Application\Model\Entity\Ususarios;
use Application\Model\Entity\PruebaGrafica;
class IndexController extends AbstractActionController
{
private $adapter;
    public function indexAction()
    {
        $this->layout()->titulo="Observatorio"; 
        $this->adapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        //var_dump($this->adapter);
        //$resul = $this->adapter->query('SELECT * FROM ususarios',  Adapter::QUERY_MODE_EXECUTE);
        //$datos = $resul->toArray();
        $usser = new Usuarios($this->adapter);
        return new ViewModel(array('resultado'=>  $usser->checkUsser()));
    }
    public function resultAction(){
        $this->layout()->titulo = "highChart";
        $this->adapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $grafica = new PruebaGrafica($this->adapter);
        $graficar = $grafica->charsZF();
        $contador = count($graficar);
        $scritp = "";
        $i = 1;
        foreach ($graficar as $value){
            $scritp .= "{name : '".$value['grafica_nombre']."',";
            $scritp .=  "data : [".$value['grafica_valor1'].",".$value['grafica_valor2'].",".$value['grafica_valor3']."]}";
            if($i != $contador){
                $scritp .=  ",";
            }
            $i++;
        }
        return new ViewModel(array('graficar' =>  $scritp));
    }
}
