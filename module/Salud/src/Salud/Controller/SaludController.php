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

class SaludController extends AbstractActionController {

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::Bienvenida al modulo de Salud::.';
        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function verAction() {
        $this->layout('layout/salud');
        $salud = $this->params()->fromRoute('salud');
        $ruta = './public/fotografias/' . $salud->getProyecto()->getProyectoId() . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $salud->getProyecto()->getProyectoId() . '/' . $file);
                    }
                }
            }
        }
        return new ViewModel(array('salud' => $salud, "imagenes" => $imagenes));
    }

    public function fotografiasAction() {
        $datos = $this->getRequest()->getPost();
        $ruta = './public/fotografias/' . $datos['id'] . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $datos['id'] . '/' . $file);
                    }
                }
            }
        }
        $resulFotos = $this->fotografiasJson($imagenes);
        return new JsonModel($resulFotos);
    }

    private function fotografiasJson(array $arrayFotografias) {
        $arrayJason = array();
        foreach ($arrayFotografias as $key => $value) {
            $arrayJason[$key] = array(
                'fotografia' => $value,
            );
        }
        $arrayFotos = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arrayFotos;
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function crearAction() {

        if ($this->getRequest()->isPost()) {
            $this->layout('layout/salud');
            $this->layout()->titulo = '.::Nuevo Proyecto::.';
            $datos = $this->getRequest()->getPost();
            $project = new Proyecto();
            $proyecto_s = new ProyectoSalud();
            $files = $this->getRequest()->getFiles()->toArray();
            $estado = $this->em()->getRepository('\Login\Model\Entity\Estado')->find(1);
            $segmento = $this->em()->getRepository('\Login\Model\Entity\Segmento')->find($datos["segmento"]);
            $eje = $this->em()->getRepository('\Login\Model\Entity\Eje')->find(4);
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
            $this->dbh()->insertObj($proyecto_s);
            $ruta = './public/fotografias/' . $project->getProyectoId() . '/';
            if (!file_exists($ruta)) {
                mkdir($ruta);
            }
            $nombrePhoto = '';
            $filter = new \Zend\Filter\File\RenameUpload($ruta);
            $filter->setUseUploadName(true);
            foreach ($files['proyecto-fotos'] as $file) {
                switch ($file['type']) {
                    case 'image/jpeg':
                        $nombrePhoto = date('Ymd_Gis') . 'jpg';
                        break;
                    case 'image/png':
                        $nombrePhoto = date('Ymd_Gis') . 'png';
                        break;
                }
                $file['name'] = $nombrePhoto;
                $filter->filter($file);
            }
            return $this->forward()->dispatch('Salud\Controller\salud', array(
                        'action' => 'ver',
                        'salud' => $proyecto_s,
            ));
        } else {
            $this->allowIn(1);
            $this->layout('layout/salud');
            $this->layout()->titulo = '.::Crear Proyecto:.';
            $formSalud = new FormularioSalud($this->em());
            return new ViewModel(array('formSalud' => $formSalud));
        }
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function listadosaludAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::Proyectos::.';
        $formSalud = new FormularioSalud($this->em());
        return new ViewModel(array('formSalud' => $formSalud));
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function actividadesAction() {
        $this->layout('layout/salud');
        $this->layout()->titulo = '.::Actividades::.';
        $formActividad = new \Salud\Form\FormularioActividad($this->em());
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
        }
        return new ViewModel(array('datos' => $datos, 'formAct' => $formActividad));
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function listadoSaludJsonAction() {
        $arrayPsalud = $this->arrayProySalud($this->dbh()->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoSalud p'));
        return new JsonModel($arrayPsalud);
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
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

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteAction() {
        $jsonView = $this->getRequest()->getPost();
        $proyecto = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\ProyectoSalud u WHERE u.proyectosaludId = :id', array('id' => $jsonView['Id']));
        if ($this->dbh()->deleteObj($proyecto[0])) {
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
        $proyectoS = $this->dbh()->selectWhere('SELECT s FROM \Login\Model\Entity\ProyectoSalud s WHERE s.proyectosaludId = :id', array('id' => $jsonView['Id']));
        $updateproyecto = $proyectoS[0];

        $estado = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Estado b WHERE b.estadoId = :id', array('id' => $jsonView['estado']));
        $segmento = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Segmento b WHERE b.segmentoId = :id', array('id' => $jsonView['segmento']));
        $proyecto = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Proyecto b WHERE b.proyectoId = :id', array('id' => $proyectoS[0]->getProyecto()->getProyectoId()));
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
        if ($this->dbh()->insertObj($updateproyecto)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }


        return new JsonModel(array('Result' => 'OK'));
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
        $proyectoSalud = $this->dbh()->selectAllById(array('proyectosaludId' => $datos['id']), '\Login\Model\Entity\ProyectoSalud');
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

    public function deleteImageAction() {
        $datos = $this->getRequest()->getPost();
        $imagen = $datos['imagen'];
        if (is_file('./public' . $imagen)) {
            unlink('./public' . $imagen);
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    public function saveeditphotosAction() {
        $datos=$this->getRequest()->getPost();
        $dir=$datos['dir'];
        $files = $this->getRequest()->getFiles()->toArray();
        $ruta = './public/fotografias/'.$dir.'/';
        if (!file_exists($ruta)) {
            mkdir($ruta);
        }
        $nombrePhoto = '';
        $filter = new \Zend\Filter\File\RenameUpload($ruta);
        $filter->setUseUploadName(true);
        $cont = 0;
        foreach ($files['proyecto-fotos'] as $file) {
            switch ($file['type']) {
                case 'image/jpeg':
                    $nombrePhoto = date('Ymd_Gis') . $cont . 'jpg';
                    break;
                case 'image/png':
                    $nombrePhoto = date('Ymd_Gis') . $cont . 'png';
                    break;
            }
            $file['name'] = $nombrePhoto;
            $filter->filter($file);
            $cont+=1;
        }
        return new JsonModel(array('Result' => 'OK'));
    }

}
