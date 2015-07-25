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
            $fecha = \DateTime::createFromFormat('d/m/Y', $datos["fechaIni"]);
            $proyecto_s->setProyectosaludFechainicio($fecha);
            $proyecto_s->setProyectosaludNumero($datos["numeroP"]);
            $proyecto_s->setProyectosaludNombre($datos["nombreP"]);
            $proyecto_s->setProyectosaludPlazoejecucion($datos["plazoEjec"]);
            $proyecto_s->setProyectosaludObjetivo($datos["objetivo"]);
            $proyecto_s->setProyectosaludObjetocontractual($datos["objetoC"]);
            $proyecto_s->setSegmento($segmento);
            $dbh->insertObj($proyecto_s);
            return $this->forward()->dispatch('Salud\Controller\index', array(
                        'action' => 'ver',
                        'salud' => $proyecto_s,
            ));
        } else {
            $this->layout('layout/salud');
            $this->layout()->titulo = '.::Crear Proyecto:.';
            $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $formSalud = new FormularioSalud($adapter);
            return new ViewModel(array('formSalud' => $formSalud));
        }
    }

    public function listadosaludAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::Proyectos::.';
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formSalud = new FormularioSalud($adapter);
        return new ViewModel(array('formSalud' => $formSalud));
    }

    public function actividadesAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::Actividades::.';
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formActividad = new \Salud\Form\FormularioActividad($adapter);
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
        }
        return new ViewModel(array('datos' => $datos, 'formAct' => $formActividad));
    }

    public function listadoSaludJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayPsalud = $this->arrayProySalud($dbh->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoSalud p'));
        return new JsonModel($arrayPsalud);
    }

    public function listadoActividadesJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $arrayActividades = $this->arrayActividadesProyecto($dbh->selectWhere('SELECT a FROM Login\Model\Entity\Actividad a where a.proyecto=:id', array('id' => $jsonView['Id'])));
        return new JsonModel($arrayActividades);
    }

    private function arrayProySalud($arrayPsalud) {
        $arrayJason = array();
        foreach ($arrayPsalud as $key => $value) {
            $arrayJason[$key] = array(
                'idp' => $value->getProyecto()->getProyectoId(),
                'id' => $value->getProyectosaludId(),
                'nombre' => $value->getProyectosaludNombre(),
                'presupuesto' => $value->getProyecto()->getProyectoPresupuesto(),
                'estado' => $value->getProyecto()->getEstado()->getEstadoNombre(),
                'vigencia' => $value->getProyecto()->getProyectoAnio(),
                'objetivo' => $value->getProyectosaludObjetivo(),
                'objetoContractual' => $value->getProyectosaludObjetocontractual(),
                'fechaInicio' => $value->getProyectosaludFechainicio()->format('d/m/Y'),
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

    private function arrayActividadesProyecto($arrayActividades) {
        $arrayJason = array();
        foreach ($arrayActividades as $key => $value) {
            $arrayJason[$key] = array(
                'id' => $value->getActividadId(),
                'nombre' => $value->getActividadNombre(),
                'lugar' => $value->getLugar()->getLugarNombre(),
                'fechaHora' => $value->getActividadFechahora()->format('d/m/Y H:i'),
                'objetivos' => $value->getActividadObjetivo(),
                'requisitos' => $value->getActividadRequisitos(),
            );
        }
        $arraySalud = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arraySalud;
    }

    public function deleteAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $proyecto = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\ProyectoSalud u WHERE u.proyectosaludId = :id', array('id' => $jsonView['Id']));
        if ($dbh->deleteObj($proyecto[0])) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    public function editarproyectoAction() {

        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $proyectoS = $dbh->selectWhere('SELECT s FROM \Login\Model\Entity\ProyectoSalud s WHERE s.proyectosaludId = :id', array('id' => $jsonView['Id']));
        $updateproyecto = $proyectoS[0];

        $estado = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Estado b WHERE b.estadoId = :id', array('id' => $jsonView['estado']));
        $segmento = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Segmento b WHERE b.segmentoId = :id', array('id' => $jsonView['segmento']));
        $proyecto = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Proyecto b WHERE b.proyectoId = :id', array('id' => $proyectoS[0]->getProyecto()->getProyectoId()));
        $proyecto[0]->setEstado($estado[0]);
        $proyecto[0]->setProyectoAnio($jsonView["vigencia"]);
        $proyecto[0]->setProyectoPresupuesto($jsonView["valProj"]);

        $updateproyecto->setProyecto($proyecto[0]);
        $updateproyecto->setProyectosaludEjecutor($jsonView["ejecutorP"]);
        $fecha = \DateTime::createFromFormat('d/m/Y', $jsonView["fechaIni"]);
        $updateproyecto->setProyectosaludFechainicio($fecha);
        $updateproyecto->setProyectosaludNumero($jsonView["numeroP"]);
        $updateproyecto->setProyectosaludNombre($jsonView["nombreP"]);
        $updateproyecto->setProyectosaludPlazoejecucion($jsonView["plazoEjec"]);
        $updateproyecto->setProyectosaludObjetivo($jsonView["objetivo"]);
        $updateproyecto->setProyectosaludObjetocontractual($jsonView["objetoC"]);
        $updateproyecto->setSegmento($segmento[0]);
        if ($dbh->insertObj($updateproyecto)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }


        return new JsonModel(array('Result' => 'OK'));
    }

    public function saveActivityAction() {
        if ($this->getRequest()->isPost()) {
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
            $datos = $this->getRequest()->getPost();
            $actividad = new \Login\Model\Entity\Actividad();
            if ($datos['Id']) {
                $jsonView = $this->getRequest()->getPost();
                $resultado = $dbh->selectWhere('SELECT s FROM \Login\Model\Entity\Actividad s WHERE s.actividadId = :id', array('id' => $jsonView['Id']));
                $actividad = $resultado[0];
                $lugar = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Lugar b WHERE b.lugarId = :id', array('id' => $jsonView['lugarActividad']));
                $actividad->setLugar($lugar[0]);
                $actividad->setActividadNombre($jsonView["nombreActividad"]);
                $fecha = \DateTime::createFromFormat('d/m/Y H:i', $jsonView["fechaActividad"]);
                $actividad->setActividadFechahora($fecha);
                $actividad->setActividadObjetivo($jsonView["objetivoActividad"]);
                $actividad->setActividadRequisitos($jsonView["requisitosActividad"]);
            } else {
                $lugar = $em->getRepository('\Login\Model\Entity\Lugar')->find($datos["lugarActividad"]);
                $proyecto = $em->getRepository('\Login\Model\Entity\Proyecto')->find($datos["idProyecto"]);
                $actividad->setActividadNombre($datos["nombreActividad"]);
                $fecha = \DateTime::createFromFormat('d/m/Y H:i', $datos["fechaActividad"]);
                $actividad->setActividadFechahora($fecha);
                $actividad->setActividadObjetivo($datos["objetivoActividad"]);
                $actividad->setActividadRequisitos($datos["requisitosActividad"]);
                $actividad->setLugar($lugar);
                $actividad->setProyecto($proyecto);
            }
            if ($dbh->insertObj($actividad)) {
                return new JsonModel(array('Result' => 'OK'));
            } else {
                return new JsonModel(array(
                    'Result' => 'ERROR',
                    'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
                );
            }
        }
    }

    public function deleteActivityAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $actividad = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\ActividadSalud u WHERE u.actividadsaludId = :id', array('id' => $jsonView['Id']));
        if ($dbh->deleteObj($actividad[0])) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    public function saveResultsAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
    }

}
