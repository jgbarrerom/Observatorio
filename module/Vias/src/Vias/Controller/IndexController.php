<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Vias\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vias\Form\FormCrearProyectoVia;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $formCrearProyVia = new FormCrearProyectoVia();
        return new ViewModel(array("formCrearProyVia" => $formCrearProyVia, "url" => $this->getRequest()->getBaseUrl()));
    }

    public function guardarAction() {
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            var_dump($datos);
            //return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/vias/index');
        }
    }

}
