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

    /**
     * pagina de inicio del modulo de educacion
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        $this->layout('layout/educacion');
        $this->layout()->titulo = '.::BIENVENIDO A EDUCACIÓN::.';
        return new ViewModel();
    }

    /**
     * pagina para ver los datos del proyecto despues de ser creado
     * @return \Zend\View\Model\ViewModel
     */
    public function verAction() {
        $this->layout('layout/educacion');
        $educacion = $this->params()->fromRoute('educacion');
        $ruta = './public/fotografias/' . $educacion->getProyecto()->getProyectoId() . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $educacion->getProyecto()->getProyectoId() . '/' . $file);
                    }
                }
            }
        }
        return new ViewModel(array('educacion' => $educacion, "imagenes" => $imagenes));
    }

    /**
     * carga la vista de crear proyecto y recibe los datos post para crear proyecto
     * @return \Zend\View\Model\ViewModel
     */
    public function crearAction() {

        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            $project = new proyecto();
            $proyecto_e = new ProyectoEducacion();
            $estado = $this->em()->getRepository('\Login\Model\Entity\Estado')->find(1);
            $eje = $this->em()->getRepository('\Login\Model\Entity\Eje')->find(2);
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
            $this->dbh()->insertObj($proyecto_e);
            $files = $this->getRequest()->getFiles()->toArray();
            $ruta = './public/fotografias/' . $project->getProyectoId() . '/';
            if (!file_exists($ruta)) {
                mkdir($ruta);
            }
            $filter = new \Zend\Filter\File\RenameUpload($ruta);
            $filter->setUseUploadName(true);
            foreach ($files['proyecto-fotos'] as $file) {
                $filter->filter($file);
            }
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

    /**
     * Carga la vista de la lista de proyectos de educacion
     * @return \Zend\View\Model\ViewModel
     */
    public function listadoEducacionAction() {
        $this->layout('layout/educacion');
        $this->layout()->titulo = '.::Proyectos::.';
        $formEducacion = new FormularioEducacion($this->em());
        return new ViewModel(array('formEducacion' => $formEducacion));
    }

    /**
     * carga la vista del listado de actividades 
     * @return \Zend\View\Model\ViewModel
     */
    public function actividadesAction() {
        $this->layout('layout/educacion');
        $this->layout()->titulo = '.::Actividades::.';
        $formActividad = new \Educacion\Form\FormularioActividad($this->em());
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
        }
        return new ViewModel(array('datos' => $datos, 'formAct' => $formActividad));
    }

    /**
     * obtiene el listado de proyectos de educacion y los retormna como json
     * @return \Zend\View\Model\JsonModel
     */
    public function listadoEducacionJsonAction() {
        $arrayEducacion = $this->arrayProyEducacion($this->dbh()->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoEducacion p'));
        return new JsonModel($arrayEducacion);
    }

    /**
     * 
     */
    public function listadoActividadesJsonAction() {
        $jsonView = $this->getRequest()->getPost();
        $arrayActividades = $this->arrayActividadesProyecto($this->dbh()->selectWhere('SELECT a FROM Login\Model\Entity\Actividad a where a.proyecto=:id', array('id' => $jsonView['Id'])));
        return new JsonModel($arrayActividades);
    }

    /**
     * 
     * @param type $arrayPsalud
     * @return string
     */
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

    /**
     * 
     * @param type $arrayActividades
     * @return type
     */
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

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteAction() {
        $jsonView = $this->getRequest()->getPost();
        $proyecto = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\ProyectoEducacion u WHERE u.proyectoeducacionId = :id', array('id' => $jsonView['Id']));
        if ($dbh->deleteObj($proyecto[0])) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function editarproyectoAction() {
        $jsonView = $this->getRequest()->getPost();
        $proyectoE = $this->dbh()->selectWhere('SELECT s FROM \Login\Model\Entity\ProyectoEducacion s WHERE s.proyectoeducacionId = :id', array('id' => $jsonView['Id']));
        $updateproyecto = $proyectoE[0];

        $estado = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Estado b WHERE b.estadoId = :id', array('id' => $jsonView['estado']));
        $proyecto = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Proyecto b WHERE b.proyectoId = :id', array('id' => $proyectoE[0]->getProyecto()->getProyectoId()));
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
        if ($this->dbh()->insertObj($updateproyecto)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function saveActivityAction() {
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            $actividad = new \Login\Model\Entity\Actividad();
            if ($datos['Id']) {
                $jsonView = $this->getRequest()->getPost();
                $resultado = $this->dbh()->selectWhere('SELECT s FROM \Login\Model\Entity\Actividad s WHERE s.actividadId = :id', array('id' => $jsonView['Id']));
                $actividad = $resultado[0];
                $lugar = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Lugar b WHERE b.lugarId = :id', array('id' => $jsonView['lugarActividad']));
                $actividad->setLugar($lugar[0]);
                $actividad->setActividadNombre($jsonView["nombreActividad"]);
                $fecha = \DateTime::createFromFormat('d/m/Y H:i', $jsonView["fechaActividad"]);
                $actividad->setActividadFechahora($fecha);
                $actividad->setActividadObjetivo($jsonView["objetivoActividad"]);
                $actividad->setActividadRequisitos($jsonView["requisitosActividad"]);
            } else {
                $lugar = $this->em()->getRepository('\Login\Model\Entity\Lugar')->find($datos["lugarActividad"]);
                $proyecto = $this->em()->getRepository('\Login\Model\Entity\Proyecto')->find($datos["idProyecto"]);
                $actividad->setActividadNombre($datos["nombreActividad"]);
                $fecha = \DateTime::createFromFormat('d/m/Y H:i', $datos["fechaActividad"]);
                $actividad->setActividadFechahora($fecha);
                $actividad->setActividadObjetivo($datos["objetivoActividad"]);
                $actividad->setActividadRequisitos($datos["requisitosActividad"]);
                $actividad->setLugar($lugar);
                $actividad->setProyecto($proyecto);
            }
            if ($this->dbh()->insertObj($actividad)) {
                return new JsonModel(array('Result' => 'OK'));
            } else {
                return new JsonModel(array(
                    'Result' => 'ERROR',
                    'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
                );
            }
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteActivityAction() {
        $jsonView = $this->getRequest()->getPost();
        $actividad = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\Actividad u WHERE u.actividadId = :id', array('id' => $jsonView['Id']));
        if ($this->dbh()->deleteObj($actividad[0])) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function saveResultsAction() {
        $datos = $this->getRequest()->getPost();
        $proyectoSalud = $this->dbh()->selectAllById(array('proyectoeducacionId' => $datos['id']), '\Login\Model\Entity\ProyectoEducacion');
        $proyecto = $proyectoSalud[0]->getProyecto();
        $proyecto->setProyectoResultados($datos['resultados']);
        if ($this->dbh()->insertObj($proyecto)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function resultadosconsAction() {
        $datos = $this->getRequest()->getPost();
        $resultado = $this->dbh()->selectWhere('SELECT a.proyectoResultados FROM Login\Model\Entity\Proyecto a where a.proyectoId=:id', array('id' => $datos['id']));
        $arrayR = array(
            'Result' => 'OK',
            'Records' => $resultado[0]
        );
        return new JsonModel($arrayR);
    }

}
