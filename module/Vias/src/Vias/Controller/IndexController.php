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
use Vias\Form\FormCargarVia;
use Login\Model\Entity\ProyectoVias as proyectoV;
use Login\Model\Entity\Proyecto as proyecto;

class IndexController extends AbstractActionController {

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function cargarAction() {
        $this->layout('layout/layoutV1');
        $via = $this->params()->fromRoute('via');
        //$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        //$via = $em->getRepository('\Login\Model\Entity\ProyectoVias')->find(2);
        $formCargarVia = new FormCargarVia($via);

        $ruta = './public/fotografias/' . $via->getProyecto()->getProyectoId() . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $via->getProyecto()->getProyectoId() . '/' . $file);
                    }
                }
            }
        }

        return new ViewModel(array("formVerVia" => $formCargarVia, "imagenes" => $imagenes));
    }

    public function crearAction() {

        if ($this->getRequest()->isPost()) {
            $this->layout('layout/layoutV1');
            $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $datos = $this->getRequest()->getPost();
            $files = $this->getRequest()->getFiles()->toArray();
            $projectV = new proyectoV();
            $project = new proyecto();
            $estado = $em->getRepository('\Login\Model\Entity\Estado')->find($datos["estado"]);
            $eje = $em->getRepository('\Login\Model\Entity\Eje')->find(3);
            $tipoObra = $em->getRepository('\Login\Model\Entity\TipoObra')->find($datos["tipoObra"]);
            $barrio = $em->getRepository('\Login\Model\Entity\Barrio')->find($datos["barrio"]);
            $project->setEstado($estado);
            $project->setEje($eje);
            $project->setProyectoPathfotos('pendiente');
            $project->setProyectoPresupuesto($datos["presupuesto"]);
            $projectV->setProyecto($project);
            $projectV->setProyectoviasTramo($datos["tramo"]);
            $projectV->setProyectoviasDirinicio($datos["dirInicio"]);
            $projectV->setProyectoviasDirfinal($datos["dirFinal"]);
            $projectV->setProyectoviasCiv($datos["civ"]);
            $projectV->setTipoobra($tipoObra);
            $projectV->setBarrio($barrio);
            $projectV->setProyectoviasLargo($datos["largo"]);
            $projectV->setProyectoviasCoordenadas($datos["coordenadas"]);
            $dbh->insertObj($projectV);
            $ruta = './public/fotografias/' . $project->getProyectoId() . '/';
            if (!file_exists($ruta)) {
                mkdir($ruta);
            }
            $filter = new \Zend\Filter\File\RenameUpload($ruta);
            $filter->setUseUploadName(true);
            foreach ($files['fotos'] as $file) {
                $filter->filter($file);
            }
            return $this->forward()->dispatch('Vias\Controller\index', array(
                        'action' => 'cargar',
                        'via' => $projectV,
            ));
        } else {
            $this->layout('layout/layoutV1');
            $this->layout()->titulo = '.::Crear Proyecto Vial::.';
            $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $formCrearProyVia = new FormGuardarVia($adapter);
            return new ViewModel(array("formCrearProyVia" => $formCrearProyVia, "url" => $this->getRequest()->getBaseUrl()));
        }
    }

    public function indexAction() {
        $this->layout('layout/layoutV1');
        $this->layout()->titulo = '.::Bienvenido Modulo Vias::.';
        return new ViewModel();
    }

    public function listadoViasAction() {
        $this->layout('layout/layoutV1');
        $this->layout()->titulo = '.::Lista Obras Viales::.';
        return new ViewModel();
    }
    public function listadoViasJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $proyectos = $dbh->selectWhereArray('SELECT p.proyectoviasCiv,p.proyectoviasTramo,p.proyectoviasDirinicio,p.proyectoviasDirfinal FROM Login\Model\Entity\ProyectoVias p');   
        $respuesta=array('Result'=>'OK','Records'=>$proyectos);
        return new \Zend\View\Model\JsonModel($respuesta);
    }

}
