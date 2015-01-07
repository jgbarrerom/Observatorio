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

 class TrabajoController extends AbstractActionController{
     
     public function indexAction() {
         $this->layout()->titulo="Trabajo";
         return new ViewModel();
     }
     public function formularioAction() {
         $this->layout()->titulo="Formulario";
         
         $formularioIng = new Formularios("form");
         return new ViewModel(array("cargaForm"=>$formularioIng,"url"=>$this->getRequest()->getBaseUrl()));
     }
     public function obtenerAction() {
         return new ViewModel();
     }
 }