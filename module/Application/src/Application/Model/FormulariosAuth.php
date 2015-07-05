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
    
    public $direccion;
    public $observacion;
    protected $inputFilter;
    
    public function getInputFilter() {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'direccion',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StringTrim'),
                ),
            ));
            $inputFilter->add(array(
                'name' => 'observacion',
                'required'=>true,
                'filters'=>array(
                    array('name'=> "\Zend\Validator\Db\NoRecordExists"),
                    array('name'=> "StripTags"),
                ),
            ));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter){
         throw new \Exception("error de autenticated.");
    }

     public function exchangeArray($param) {
        $this->direccion = (isset($param['direccion'])) ? $param['direccion'] : null;
        $this->observacion = (isset($param['observacion'])) ? $param['observacion'] : null;
        
     }
    
    
}
