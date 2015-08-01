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
            "name"=>"direccion",
            "options"=>array(
                "label"=>"Direccion: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes"=>array(
                "type"=>"text",
                "class"=>"span7",
                "id"=>"direccion"
            )
        ));        
        
        $this->add(array(
            "name"=>"nombre",
            "attributes"=>array(
                "type"=>"text",
                "class"=>"span4",
                "id"=>"nombre"
            )
        ));        
        
        $this->add(array(
            "name"=>"apellido",
            "attributes"=>array(
                "type"=>"text",
                "id"=>"apellido"
            )
        ));        
        
        $this->add(array(
            "name"=>"tele",
            "attributes"=>array(
                "type"=>"text",
                "class"=>"span7",
                "id"=>"tele"
            )
        ));        
        
        $this->add(array(
            "name"=>"mail",
            "attributes"=>array(
                "type"=>"text",
                "class"=>"span7",
                "id"=>"mail"
            )
        ));
        //*-*-*-*-*-*-*-*-*-*-*-*-
             
        $this->add(array(
            "type"=> "Zend\Form\Element\Select",
            "name"=>"barrios",
            "options"=>array(
                "label"=>"Barrio: ",
                "value_options"=>  $this->allBarrio($em),
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"span7",
                "id"=>"barrios"
            )
        ));
        
        $this->add(array(
            "type"=> "Zend\Form\Element\Textarea",
            "name"=>"observacion",
            "options"=>array(
                "label"=>  "Observacion: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes"=>array(
                "id"=>"observacion",
                "class"=>"span7"
            )
        ));
        
        $this->add(array(
            "type"=> "Zend\Form\Element\File",
            "name"=>"photo",
            "options"=>array(
                "label"=>  "Agregar Fotografia: ",
                "label_attributes" => array(
                    "class" => "control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-element",
                "id"=>"photo"
            )
        ));
        
        $this->add(array(
            "name"=>"enviar",
            "attributes"=>array(
                "type"=>"submit",
                "class"=>"btn btn-primary",
                "value"=>"Enviar Reporte"
            )
        ));
        
        $this->add(array(
            "name"=>"sugerir",
            "attributes"=>array(
                "type"=>"submit",
                "class"=>"btn btn-primary",
                "value"=>"Enviar Sugerencia"
            )
        ));
    }
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     * @return array
     */
    private function allBarrio(\Doctrine\ORM\EntityManager $em){
        $dbh = new DataBaseHelper($em);
        $bObj = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Barrio b ORDER BY b.barrioNombre ASC');
        $barrios = array(""=>"--Seleccione el Barrio--");
        foreach ($bObj as $value) {
            $barrios[$value->getBarrioId()] = $value->getBarrioNombre();
        }
        return $barrios;
    }
}
