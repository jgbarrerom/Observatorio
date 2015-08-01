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
    
    public $observacion;
    public $nombre;
    public $apellido;
    public $tele;
    public $mail;
    public $barrios;
    protected $inputFilter;
    
    public function getInputFilter() {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'observacion',
                'required'=>true,
                'filters'=>array(
                    array('name'=> "\Zend\Validator\Db\NoRecordExists"),
                    array('name'=> "StripTags"),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'nombre',
                'required'=>true,
                'filters'=>array(
                    array('name'=> "\Zend\Validator\Db\NoRecordExists"),
                    array('name'=> "StripTags"),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'apellido',
                'required'=>true,
                'filters'=>array(
                    array('name'=> "\Zend\Validator\Db\NoRecordExists"),
                    array('name'=> "StripTags"),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'tele',
                'required'=>true,
                'filters'=>array(
                    array('name'=> "\Zend\Validator\Db\NoRecordExists"),
                    array('name'=> "StripTags"),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'mail',
                'required'=>true,
                'filters'=>array(
                    array('name'=> "\Zend\Validator\Db\NoRecordExists"),
                    array('name'=> "StripTags"),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'barrios',
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
        $this->observacion = (isset($param['observacion'])) ? $param['observacion'] : null;
        $this->nombre = (isset($param['nombre'])) ? $param['nombre'] : null;
        $this->apellido = (isset($param['apellido'])) ? $param['apellido'] : null;
        $this->tele= (isset($param['tele'])) ? $param['tele'] : null;
        $this->mail= (isset($param['mail'])) ? $param['mail'] : null;
        $this->barrios= (isset($param['barrios'])) ? $param['barrios'] : null;
        
     }
    
    
}
