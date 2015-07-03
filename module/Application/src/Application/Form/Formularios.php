<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Form;

use Zend\Form\Form;
use Login\Model\DataBaseHelper;
/**
 * Description of Formularios
 *
 * @author Jeisson
 */
class Formularios extends Form {
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct("reporteVia");
        
        $this->add(array(
            "type"=> 'Zend\Form\Element\Select',
            "name"=>"tipoCalle",
            "options"=>array(
                "label"=>"Direccion: ",
                "value_options"=>array(
                    "Calle",
                    "Carrera",
                    "Diagonal",
                    "Transversal",
                )
            ),
            "attributes"=>array(
                "id"=>"tipoCalle",
                "required"=>"required",
                "class"=>"form-control span2"
            )
        ));
        
        $this->add(array(
            "name"=>"firsthNum",
            "options"=>array(
                "label"=>""
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"right span1"
            )
        ));
        
        $this->add(array(
            "name"=>"secondNum",
            "options"=>array(
                "label"=>""
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"right span1"
            )
        ));
        
        $this->add(array(
            "name"=>"lastNum",
            "options"=>array(
                "label"=>""
            ),
            "attributes"=>array(
                "type"=>"text",
                "required"=>"required",
                "class"=>"right span1"
            )
        ));
        
        $this->add(array(
            "type"=> "Zend\Form\Element\Select",
            "name"=>"letraFirNum",
            "options"=>array(
                "value_options"=>  $this->abcDario()
            ),
            "attributes"=>array(
                "required"=>"required",
                "class"=>"right span1"
            )
        ));        
        
        $this->add(array(
            "name"=>"bis",
            "type"=> "Zend\Form\Element\Checkbox",
            "options"=>array(
                "label"=>"Bis",
                'use_hidden_element' => true,
                'checked_value' => 'bis',
                'unchecked_value' => ''
            ),
            "attributes"=>array(
                "class"=>"right"
            )
        ));
        
        $this->add(array(
            "type"=> "Zend\Form\Element\Select",
            "name"=>"letraSecNum",
            "options"=>array(
                "value_options"=>  $this->abcDario()
            ),
            "attributes"=>array(
                "required"=>"required",
                "class"=>"right span1"
            )
        ));
        
        $this->add(array(
            "type"=> "Zend\Form\Element\Select",
            "name"=>"barrios",
            "options"=>array(
                "label"=>"Barrio: ",
                "value_options"=>  $this->allBarrio($em)
            ),
            "attributes"=>array(
                "required"=>"required",
                "class"=>"right"
            )
        ));
        
        $this->add(array(
            "type"=> "Zend\Form\Element\Textarea",
            "name"=>"observacion",
            "options"=>array(
                "label"=>  "Observacion: "
            )
        ));
        
        $this->add(array(
            "name"=>"enviar",
            "attributes"=>array(
                "type"=>"submit",
                "class"=>"btn btn-primary",
                "value"=>"Enviar"
            )
        ));
    }
    private function abcDario() {
        $abcDario = array('');
        for($i=65;$i<=90;$i++){
            $abcDario[chr($i)]= chr($i);
        }
        return $abcDario;
    }
    private function allBarrio(\Doctrine\ORM\EntityManager $em){
        $dbh = new DataBaseHelper($em);
        $bObj = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Barrio b ORDER BY b.barrioNombre ASC');
        $barrios = array("--Seleccione el Barrio--");
        foreach ($bObj as $value) {
            $barrios[$value->getBarrioId()] = $value->getBarrioNombre();
        }
        return $barrios;
    }
}
