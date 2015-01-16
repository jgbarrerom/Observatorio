<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
/**
 * Description of fornularioAuth
 *
 * @author JeissonGerardo
 */
class FormulariosAuth implements InputFilterAwareInterface{
    
    public $name;
    public $password;
    protected $inputFilter;
    
    public function exchangeArray($param) {
        $this->name = (isset($param['nombre'])) ? $param['nombre'] : null;
        $this->password = (isset($param['password'])) ? $param['password'] : null;
        
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter){
         throw new \Exception("Not used");
     }

    
    public function getInputFilter() {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'nombre',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StringTrim'),
                ),
            ));
            $inputFilter->add(array(
                'name' => 'password',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StringTrim'),
                ),
            ));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
