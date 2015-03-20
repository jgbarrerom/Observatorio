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
    public function cargarViaAction() {
        //$via = $this->params()->fromRoute('via');
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $proyectoVia = $em->getRepository('\Login\Model\Entity\ProyectoVias')->find(26);
        $formCargarVia = new FormCargarVia($proyectoVia);
        $ruta = './data/' . $proyectoVia->getProyecto()->getProyectoId() . '/';
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        echo "<br> $ruta$file ";
                    }
                }
            }
        }   
        $images = array();
        return new ViewModel(array("formVerVia" => $formCargarVia));
    }

    public function guardarViaAction() {

        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formCrearProyVia = new FormGuardarVia($adapter);
        return new ViewModel(array("formCrearProyVia" => $formCrearProyVia, "url" => $this->getRequest()->getBaseUrl()));
    }

    public function guardarAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            $files = $this->getRequest()->getFiles()->toArray();
            $projectV = new proyectoV();
            $project = new proyecto();
            $estado = $em->getRepository('\Login\Model\Entity\Estado')->find($datos["estado"]);
            $eje = $em->getRepository('\Login\Model\Entity\Eje')->find(1);
            $tipoObra = $em->getRepository('\Login\Model\Entity\TipoObra')->find($datos["tipoObra"]);
            $barrio = $em->getRepository('\Login\Model\Entity\Barrio')->find($datos["barrio"]);
            $project->setEstado($estado);
            $project->setEje($eje);
            $project->setProyectoPathfotos('pendiente');
            $project->setProyectoPresupuesto($datos["presupuesto"]);
            $projectV->setProyecto($project);
            $projectV->setProyectoviasDirinicio($datos["dirInicio"]);
            $projectV->setProyectoviasDirfinal($datos["dirFinal"]);
            $projectV->setProyectoviasCiv($datos["civ"]);
            $projectV->setTipoobra($tipoObra);
            $projectV->setBarrio($barrio);
            $projectV->setProyectoviasLargo($datos["largo"]);
            $projectV->setCoordenadas($datos["coordenadas"]);
            $dbh->insertObj($projectV);
            $ruta = './data/' . $project->getProyectoId() . '/';
            if (!file_exists($ruta)) {
                mkdir($ruta);
            }
            $filter = new \Zend\Filter\File\RenameUpload($ruta);
            $filter->setUseUploadName(true);
            foreach ($files['fotos'] as $file) {
                $filter->filter($file);
            }
            return $this->forward()->dispatch('Vias\Controller\index', array(
                        'action' => 'cargarvia',
                        'via' => $projectV,
            ));
        }
    }

}
