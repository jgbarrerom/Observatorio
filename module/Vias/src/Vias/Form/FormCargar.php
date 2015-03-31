<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormCargarVia
 *
 * @author NATHALY
 */

namespace Vias\Form;

use Zend\Form\Form;

class FormCargarVia extends Form {

    public function __construct($proyectoVia) {
        parent::__construct('FormGuardarVia');

        $this->add(array(
            "name" => "dirInicio",
            "options" => array(
                "label" => "Direccion Inicio :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasDirinicio(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));

        $this->add(array(
            "name" => "barrio",
            "options" => array(
                "label" => "Barrio :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getBarrio()->getBarrioNombre(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "dirFinal",
            "options" => array(
                "label" => "Dirección Final :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasDirfinal(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));

        $this->add(array(
            "name" => "dirInicio",
            "options" => array(
                "label" => "Dirección Inicio :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasDirinicio(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));

        $this->add(array(
            "name" => "dirInicio",
            "options" => array(
                "label" => "Direccion Inicio :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasDirinicio(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));

        $this->add(array(
            "name" => "dirInicio",
            "options" => array(
                "label" => "Direccion Inicio :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasDirinicio(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "civ",
            "options" => array(
                "label" => "CIV :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasCiv(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "presupuesto",
            "options" => array(
                "label" => "Presupuesto :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyecto()->getProyectoPresupuesto(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "tipoObra",
            "options" => array(
                "label" => "Tipo de Obra :"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getTipoobra()->getTipoobraNombre(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "estado",
            "options" => array(
                "label" => "Estado:"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyecto()->getEstado()->getEstadoNombre(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "largo",
            "options" => array(
                "label" => "Largo:"
            ),
            "attributes" => array(
                "type" => "text",
                "value" => $proyectoVia->getProyectoviasLargo(),
                "disabled" => "disabled",
                "class" => "form-control espacio"
            )
        ));
        $this->add(array(
            "name" => "coordenadas",
            "attributes" => array(
                "value" => $proyectoVia->getProyectoviasCoordenadas(),
                "type" => "hidden",
                "id" => "coordenadas",
            )
        ));
    }

}
