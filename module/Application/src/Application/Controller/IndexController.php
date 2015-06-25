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

class IndexController extends AbstractActionController
{
    public function indexAction(){
        $this->layout('layout/anonimus');
        $this->layout()->titulo="Observatorio";
        
        return new ViewModel();
    }
    
    public function noticiasSaludAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo=".::Noticias Salud::.";
        return new ViewModel();
    }
    
    public function reporteViaAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo=".::Reporte Vial::.";
        $formReporte = new \Application\Form\Formularios();
        return new ViewModel(array('formReporte'=>$formReporte));
    }
}
