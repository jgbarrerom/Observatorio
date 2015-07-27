<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Educacion\Controller;

/**
 * Description of IndexController
 *
 * @author JeissonGerardo
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Educacion\Form\FormularioEducacion;
use \Login\Model\Entity\ProyectoEducacion;
use Zend\View\Model\JsonModel;
use \Login\Model\Entity\Proyecto;
use Login\Model\Entity\ProyectoSalud;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $this->layout('layout/educacion');
        $this->layout()->titulo = '.::BIENVENIDO A EDUCACIÓN::.';
        return new ViewModel();
    }

    public function verAction() {
        $this->layout('layout/educacion');
        $educacion = $this->params()->fromRoute('educacion');
        //$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        //$salud = $em->getRepository('\Login\Model\Entity\ProyectoSalud')->find(1);
        return new ViewModel(array('educacion' => $educacion));
    }

    public function crearAction() {

        if ($this->getRequest()->isPost()) {
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
            $datos = $this->getRequest()->getPost();
            $project = new proyecto();
            $proyecto_e = new ProyectoEducacion();
            $estado = $em->getRepository('\Login\Model\Entity\Estado')->find(1);
            $eje = $em->getRepository('\Login\Model\Entity\Eje')->find(2);
            $project->setEstado($estado);
            $project->setEje($eje);
            $project->setProyectoPathfotos('pendiente');
            $project->setProyectoAnio($datos["vigencia"]);
            $project->setProyectoPresupuesto($datos["valProj"]);

            $proyecto_e->setProyecto($project);
            $proyecto_e->setProyectoeducacionEjecutor($datos["ejecutorP"]);
            $fecha = \DateTime::createFromFormat('d/m/Y', $datos["fechaIni"]);
            $proyecto_e->setProyectoeducacionFechainicio($fecha);
            $proyecto_e->setProyectoeducacionNumero($datos["numeroP"]);
            $proyecto_e->setProyectoeducacionNombre($datos["nombreP"]);
            $proyecto_e->setProyectoeducacionPlazoejecucion($datos["plazoEjec"]);
            $proyecto_e->setProyectoeducacionObjetivo($datos["objetivo"]);
            $proyecto_e->setProyectoeducacionPerfilbeneficiario($datos["perfilBen"]);
            $proyecto_e->setProyectoeducacionCupos($datos["cupos"]);
            $dbh->insertObj($proyecto_e);
            return $this->forward()->dispatch('Educacion\Controller\index', array(
                        'action' => 'ver',
                        'educacion' => $proyecto_e,
            ));
        } else {
            $this->layout('layout/educacion');
            $this->layout()->titulo = '.::Crear Proyecto:.';
            $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $formEducacion = new FormularioEducacion($adapter);
            return new ViewModel(array('formEducacion' => $formEducacion));
        }
    }

    public function listadoEducacionAction() {
        $this->layout('layout/educacion');
        $this->layout()->titulo = '.::Proyectos::.';
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formEducacion = new FormularioEducacion($adapter);
        return new ViewModel(array('formEducacion' => $formEducacion));
    }

    public function actividadesAction() {
        $this->layout('layout/educacion');
        $this->layout()->titulo = '.::Actividades::.';
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formActividad = new \Educacion\Form\FormularioActividad($adapter);
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
        }
        return new ViewModel(array('datos' => $datos, 'formAct' => $formActividad));
    }

    public function listadoEducacionJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayEducacion= $this->arrayProyEducacion($dbh->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoEducacion p'));
        return new JsonModel($arrayEducacion);
    }

    public function listadoActividadesJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $arrayActividades = $this->arrayActividadesProyecto($dbh->selectWhere('SELECT a FROM Login\Model\Entity\Actividad a where a.proyecto=:id', array('id' => $jsonView['Id'])));
        return new JsonModel($arrayActividades);
    }

    private function arrayProyEducacion($arrayPsalud) {
        $arrayJason = array();
        foreach ($arrayPsalud as $key => $value) {
            $arrayJason[$key] = array(
                'idp' => $value->getProyecto()->getProyectoId(),
                'id' => $value->getProyectoeducacionId(),
                'nombre' => $value->getProyectoeducacionNombre(),
                'presupuesto' => $value->getProyecto()->getProyectoPresupuesto(),
                'estado' => $value->getProyecto()->getEstado()->getEstadoNombre(),
                'vigencia' => $value->getProyecto()->getProyectoAnio(),
                'objetivo' => $value->getProyectoeducacionObjetivo(),
                'perfilBeneficiario' => $value->getProyectoeducacionPerfilbeneficiario(),
                'fechaInicio' => $value->getProyectoeducacionFechainicio()->format('d/m/Y'),
                'plazoEjecucion' => $value->getProyectoeducacionPlazoejecucion(),
                'numero' => $value->getProyectoeducacionNumero(),
                'ejecutor' => $value->getProyectoeducacionEjecutor(),
                'cupos' => $value->getProyectoeducacionCupos()
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
        $proyecto = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\ProyectoEducacion u WHERE u.proyectoeducacionId = :id', array('id' => $jsonView['Id']));
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
        $proyectoE = $dbh->selectWhere('SELECT s FROM \Login\Model\Entity\ProyectoEducacion s WHERE s.proyectoeducacionId = :id', array('id' => $jsonView['Id']));
        $updateproyecto = $proyectoE[0];

        $estado = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Estado b WHERE b.estadoId = :id', array('id' => $jsonView['estado']));
        $proyecto = $dbh->selectWhere('SELECT b FROM \Login\Model\Entity\Proyecto b WHERE b.proyectoId = :id', array('id' => $proyectoE[0]->getProyecto()->getProyectoId()));
        $proyecto[0]->setEstado($estado[0]);
        $proyecto[0]->setProyectoAnio($jsonView["vigencia"]);
        $proyecto[0]->setProyectoPresupuesto($jsonView["valProj"]);

        $updateproyecto->setProyecto($proyecto[0]);
        $updateproyecto->setProyectoeducacionEjecutor($jsonView["ejecutorP"]);
        $fecha = \DateTime::createFromFormat('d/m/Y', $jsonView["fechaIni"]);
        $updateproyecto->setProyectoeducacionFechainicio($fecha);
        $updateproyecto->setProyectoeducacionNumero($jsonView["numeroP"]);
        $updateproyecto->setProyectoeducacionNombre($jsonView["nombreP"]);
        $updateproyecto->setProyectoeducacionPlazoejecucion($jsonView["plazoEjec"]);
        $updateproyecto->setProyectoeducacionObjetivo($jsonView["objetivo"]);
        $updateproyecto->setProyectoeducacionPerfilbeneficiario($jsonView["perfilBen"]);
        $updateproyecto->setProyectoeducacionCupos($jsonView["cupos"]);
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
        $datos = $this->getRequest()->getPost();
        $proyectoSalud = $dbh->selectAllById(array('proyectosaludId' => $datos['id']), '\Login\Model\Entity\ProyectoSalud');
        $proyecto = $proyectoSalud[0]->getProyecto();
        $proyecto->setProyectoResultados($datos['resultados']);
        if ($dbh->insertObj($proyecto)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    public function resultadosconsAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $datos = $this->getRequest()->getPost();
        $resultado = $dbh->selectWhere('SELECT a.proyectoResultados FROM Login\Model\Entity\Proyecto a where a.proyectoId=:id', array('id' => $datos['id']));
        $arrayR = array(
            'Result' => 'OK',
            'Records' => $resultado[0]
        );
        return new JsonModel($arrayR);
    }

}
