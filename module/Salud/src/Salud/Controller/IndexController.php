<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Salud\Controller;
/**
 * Description of IndexController
 *
 * @author JeissonGerardo
 */

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Salud\Form\FormularioSalud;

class IndexController extends AbstractActionController{
    
    public function indexAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::BIENVENIDO A SALUD::.';
        $formSalud = new FormularioSalud();
        
        return new ViewModel(array('formSalud'=>$formSalud));
    }
}