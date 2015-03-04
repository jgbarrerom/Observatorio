<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Administracion\Model;

/**
 * Description of FormAdminAuth
 *
 * @author JeissonGerardo
 */
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

class FormAdminAuth implements InputFilterAwareInterface{
    public function getInputFilter() {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("error de autenticacion");
    }


}
