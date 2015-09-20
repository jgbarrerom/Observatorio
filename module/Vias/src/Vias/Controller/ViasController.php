<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Vias\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vias\Form\FormGuardarVia;
use Login\Model\Entity\ProyectoVias as proyectoV;
use Login\Model\Entity\Proyecto as proyecto;
use Zend\View\Model\JsonModel;

class ViasController extends AbstractActionController {

    /**
     * Se encarga de mostrar los datos y fotografias de un proyecto vial almacenado 
     * @return \Zend\View\Model\ViewModel
     */
    public function cargarAction() {
        $this->layout('layout/layoutV1');
        $via = $this->params()->fromRoute('via');
        //  $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        // $via = $em->getRepository('\Login\Model\Entity\ProyectoVias')->find(16);
        //$formCargarVia = new FormCargarVia($via);

        $ruta = './public/fotografias/' . $via->getProyecto()->getProyectoId() . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if (($dh = opendir($ruta))) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $via->getProyecto()->getProyectoId() . '/' . $file);
                    }
                }
            }
        }

        return new ViewModel(array("via" => $via, "imagenes" => $imagenes));
    }

    /**
     * Carga el formulario para ingresar el nuevo proyecto vial , cuando la peticion es post guarda la los datos del proyecto
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function crearAction() {

        if ($this->getRequest()->isPost()) {
            $this->layout('layout/layoutV1');
            $datos = $this->getRequest()->getPost();
            $files = $this->getRequest()->getFiles()->toArray();
            $projectV = new proyectoV();
            $project = new proyecto();
            $estado = $this->em()->getRepository('\Login\Model\Entity\Estado')->find($datos["estado"]);
            $eje = $this->em()->getRepository('\Login\Model\Entity\Eje')->find(3);
            $tipoObra = $this->em()->getRepository('\Login\Model\Entity\TipoObra')->find($datos["tipoObra"]);
            $barrio = $this->em()->getRepository('\Login\Model\Entity\Barrio')->find($datos["barrio"]);
            $ejecutor = $this->em()->getRepository('\Login\Model\Entity\Ejecutor')->find($datos["ejecutor"]);
            $project->setEstado($estado);
            $project->setEje($eje);
            $project->setProyectoPathfotos('pendiente');
            $project->setProyectoAnio($datos["anio"]);
            $project->setProyectoPresupuesto($datos["presupuesto"]);
            $projectV->setProyecto($project);
            $projectV->setProyectoviasTramo($datos["tramo"]);
            $projectV->setProyectoviasDirinicio($datos["dirInicio"]);
            $projectV->setProyectoviasDirfinal($datos["dirFinal"]);
            $projectV->setProyectoviasCiv($datos["civ"]);
            $projectV->setTipoobra($tipoObra);
            $projectV->setBarrio($barrio);
            $projectV->setProyectoviasLargo($datos["largo"]);
            $projectV->setProyectoviasAncho($datos["ancho"]);
            $projectV->setProyectoviasInterventor($datos["interventor"]);
            $projectV->setProyectoviasEjecutor($ejecutor);
            $projectV->setProyectoviasCoordenadas($datos["coordenadas"]);
            $this->dbh()->insertObj($projectV);
            $ruta = './public/fotografias/' . $project->getProyectoId() . '/';
            if (!file_exists($ruta)) {
                mkdir($ruta);
            }
            $filter = new \Zend\Filter\File\RenameUpload($ruta);
            $filter->setUseUploadName(true);
            foreach ($files['proyecto-fotos'] as $file) {
                $filter->filter($file);
            }
            return $this->forward()->dispatch('Vias\Controller\vias', array(
                        'action' => 'cargar',
                        'via' => $projectV,
            ));
        } else {
            $this->allowIn(1);
            $this->layout('layout/layoutV1');
            $this->layout()->titulo = '.::Crear Proyecto Vial::.';
            $formCrearProyVia = new FormGuardarVia($this->em());
            return new ViewModel(array("formCrearProyVia" => $formCrearProyVia, "url" => $this->getRequest()->getBaseUrl()));
        }
    }

    /*
     * index del modulo de vias  
     */

    public function indexAction() {
        $this->layout('layout/layoutV1');
        $this->layout()->titulo = '.::Bienvenido Modulo Vias::.';
        return new ViewModel();
    }

    /*
     * Carga la vista de el listado de las vias existentes y las opciones 
     */

    public function listadoViasAction() {
        $this->layout('layout/layoutV1');
        $this->layout()->titulo = '.::Lista Obras Viales::.';
        $formEditarProyVia = new FormGuardarVia($this->em());
        $container = new \Zend\Session\Container('cbol');

        return new ViewModel(array('formEditarProyVia' => $formEditarProyVia, 'permission' => $container->permisosUser));
    }

    /*
     * consuta todas los proyectos de vias existentes y retorna a la vista un json 
     */

    public function listadoViasJsonAction() {
        $arrayPvias = $this->arrayProyVias($this->dbh()->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoVias p'));
        return new JsonModel($arrayPvias);
    }

    /*
     * Construye el Json de la lista de vias que recibe en un array 
     */

    private function arrayProyVias(array $arrayPvias) {
        $arrayJason = array();
        foreach ($arrayPvias as $key => $value) {
            $arrayJason[$key] = array(
                'idp' => $value->getProyecto()->getProyectoId(),
                'id' => $value->getProyectoviasId(),
                'civ' => $value->getProyectoviasCiv(),
                'dirInicio' => $value->getProyectoviasDirinicio(),
                'dirFinal' => $value->getProyectoviasDirfinal(),
                'ancho' => $value->getProyectoviasAncho(),
                'largo' => $value->getProyectoviasLargo(),
                'tramo' => $value->getProyectoviasTramo(),
                'ejecutor' => $value->getProyectoviasEjecutor()->getEjecutorNombre(),
                'interventor' => $value->getProyectoviasInterventor(),
                'coordenadas' => $value->getProyectoviasCoordenadas(),
                'anio' => $value->getProyecto()->getProyectoAnio(),
                'estado' => $value->getProyecto()->getEstado()->getEstadoNombre(),
                'presupuesto' => $value->getProyecto()->getProyectoPresupuesto(),
                'barrio' => $value->getBarrio()->getBarrioNombre(),
                'tipo' => $value->getTipoobra()->getTipoobraNombre(),
            );
        }
        $arrayVias = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arrayVias;
    }

    /*
     * Funcion que edita los datos de un proyecto existente 
     */

    public function editarproyectoAction() {

        $jsonView = $this->getRequest()->getPost();
        $via = $this->dbh()->selectWhere('SELECT v FROM \Login\Model\Entity\ProyectoVias v WHERE v.proyectoviasId = :id', array('id' => $jsonView['Id']));
        $updateVia = $via[0];
        //$dbh->selectWhere("UPDATE Login\Model\Entity\ProyectoVias p SET p.proyectoviasDirinicio = 'prueba' WHERE p.proyectoviasId=:id", array('id' => 1));
        $updateVia->setProyectoviasDirinicio($jsonView['dirInicio']);
        $updateVia->setProyectoviasDirfinal($jsonView['dirFinal']);
        $updateVia->setProyectoviasTramo($jsonView['tramo']);
        $updateVia->setProyectoviasCiv($jsonView['civ']);
        $updateVia->setProyectoviasAncho($jsonView['ancho']);
        $updateVia->setProyectoviasLargo($jsonView['largo']);
        $updateVia->setProyectoviasCoordenadas($jsonView['coordenadas']);
        $updateVia->setProyectoviasInterventor($jsonView['interventor']);
        $updateVia->getProyecto()->getProyectoId();
        //$barrio = new \Login\Model\Entity\Barrio();
        $barrio = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Barrio b WHERE b.barrioId = :id', array('id' => $jsonView['barrio']));
        $proyecto = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Proyecto b WHERE b.proyectoId = :id', array('id' => $via[0]->getProyecto()->getProyectoId()));
        $estado = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\estado b WHERE b.estadoId = :id', array('id' => $jsonView['estado']));
        $proyecto[0]->setEstado($estado[0]);
        $proyecto[0]->setProyectoAnio($jsonView['anio']);
        $proyecto[0]->setProyectoPresupuesto($jsonView['presupuesto']);

        $ejecutor = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Ejecutor b WHERE b.ejecutorId = :id', array('id' => $jsonView['ejecutor']));
        $tipoObra = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\TipoObra b WHERE b.tipoobraId = :id', array('id' => $jsonView['tipoObra']));

        $updateVia->setBarrio($barrio[0]);
        $updateVia->setProyecto($proyecto[0]);
        $updateVia->setProyectoviasEjecutor($ejecutor[0]);
        $updateVia->setTipoobra($tipoObra[0]);
        if ($this->dbh()->insertObj($updateVia)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }


        return new JsonModel(array('Result' => 'OK'));
    }

    public function deleteAction() {
        $jsonView = $this->getRequest()->getPost();
        $via = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\ProyectoVias u WHERE u.proyectoviasId = :id', array('id' => $jsonView['Id']));
        $ruta = './public/fotografias/' . $via[0]->getProyecto()->getProyectoId();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        unlink($ruta . '/' . $file);
                    }
                }
            }
        }
        // rmdir($ruta);
        if ($this->dbh()->deleteObj($via[0])) {
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
     * @return \Zend\View\Model\ViewModel
     */
    public function listaReportesViasAction() {
        $this->layout('layout/layoutV1');
        $this->layout()->titulo = '.::Lista Obras Viales::.';
        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function cargarListaAction() {
        $reporte_via = $this->dbh()->selectWhere('SELECT '
                . 'r.reporteviaId ID,r.reporteviaDireccion DIRECC,'
                . 'r.reporteviaObservacion OBSV,r.reporteviasFotos PHOTO,'
                . 'r.reporteviaLeido READ,r.reporteviaFecha FECHA,'
                . 'b.barrioNombre BARRIO,u.upzNombre UPZ '
                . 'FROM \Login\Model\Entity\ReporteVia r INNER JOIN r.barrio b INNER JOIN b.upz u');
        return new JsonModel(array('result' => $reporte_via));
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
        $datos = $this->getRequest()->getPost();
        $dir = $datos['dir'];
        $files = $this->getRequest()->getFiles()->toArray();
        $ruta = './public/fotografias/' . $dir . '/';
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
