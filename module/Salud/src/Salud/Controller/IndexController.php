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
use Zend\View\Model\JsonModel;
use \Login\Model\Entity\Proyecto;
use Login\Model\Entity\ProyectoSalud;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::BIENVENIDO A SALUD::.';
        return new ViewModel();
    }

    public function verAction() {
        $this->layout('layout/salud');
        $salud = $this->params()->fromRoute('salud');
        //$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        //$salud = $em->getRepository('\Login\Model\Entity\ProyectoSalud')->find(1);
        return new ViewModel(array('salud' => $salud));
    }

    public function crearAction() {

        if ($this->getRequest()->isPost()) {
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
            $datos = $this->getRequest()->getPost();
            $project = new proyecto();
            $proyecto_s = new proyectosalud();
            $estado = $em->getRepository('\Login\Model\Entity\Estado')->find(1);
            $segmento = $em->getRepository('\Login\Model\Entity\Segmento')->find($datos["segmento"]);
            $eje = $em->getRepository('\Login\Model\Entity\Eje')->find(4);
            $project->setEstado($estado);
            $project->setEje($eje);
            $project->setProyectoPathfotos('pendiente');
            $project->setProyectoAnio($datos["vigencia"]);
            $project->setProyectoPresupuesto($datos["valProj"]);

            $proyecto_s->setProyecto($project);
            $proyecto_s->setProyectosaludEjecutor($datos["ejecutorP"]);
            $fecha = \DateTime::createFromFormat('d-m-Y', $datos["fechaIni"]);
            var_dump($fecha);
            $proyecto_s->setProyectosaludFechainicio($fecha);
            $proyecto_s->setProyectosaludNumero($datos["numeroP"]);
            $proyecto_s->setProyectosaludPlazoejecucion($datos["plazoEjec"]);
            $proyecto_s->setProyectosaludObjetivo($datos["objetivo"]);
            $proyecto_s->setProyectosaludObjetocontractual($datos["objetoC"]);
            $proyecto_s->setSegmento($segmento);
            var_dump($proyecto_s);
            $dbh->insertObj($proyecto_s);
//            return $this->forward()->dispatch('Salud\Controller\index', array(
//                        'action' => 'ver',
//                        'salud' => $proyecto_s,
//            ));
        } else {
            $this->layout('layout/salud');
            $this->layout()->titulo = '.::BIENVENIDO A SALUD::.';
            $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $formSalud = new FormularioSalud($adapter);

            return new ViewModel(array('formSalud' => $formSalud));
        }
    }

    public function listadosaludAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::PROYECTOS::.';
        return new ViewModel();
    }

    public function listadoSaludJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayPsalud = $this->arrayProySalud($dbh->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoSalud p'));
        return new JsonModel($arrayPsalud);
    }

    private function arrayProySalud($arrayPsalud) {
        $arrayJason = array();
        foreach ($arrayPsalud as $key => $value) {
            $arrayJason[$key] = array(
                'presupuesto' => $value->getProyecto()->getProyectoPresupuesto(),
                'estado' => $value->getProyecto()->getEstado()->getEstadoNombre(),
                'vigencia' => $value->getProyecto()->getProyectoAnio(),
                'objetivos' => $value->getProyectosaludObjetivo(),
                'objetoContractual' => $value->getProyectosaludObjetocontractual(),
                'fechaInicio' => $value->getProyectosaludFechainicio(),
                'plazoEjecucion' => $value->getProyectosaludPlazoejecucion(),
                'numero' => $value->getProyectosaludNumero(),
                'ejecutor' => $value->getProyectosaludEjecutor(),
                'segmento' => $value->getSegmento()->getSegmentoNombre()
            );
        }
        $arraySalud = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arraySalud;
    }

}
