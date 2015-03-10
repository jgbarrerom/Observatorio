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
use Vias\Form\FormCrearProyectoVia;
use Login\Model\Entity\ProyectoVias as proyectoV;
use Login\Model\Entity\Proyecto as proyecto;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $formCrearProyVia = new FormCrearProyectoVia();
        return new ViewModel(array("formCrearProyVia" => $formCrearProyVia, "url" => $this->getRequest()->getBaseUrl()));
    }

    public function guardarAction() {
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            $projectV = new proyectoV();
            $project = new proyecto();
            $eje = new \Login\Model\Entity\Eje();
            
            $project->setEje($eje);
            $project->setEstado();
            $project->setProyectoPathfotos();
            $project->setProyectoPresupuesto();

            $projectV->setProyecto($project);
            $projectV->setProyectoviasDirinicio($datos["dirInicio"]);
            $projectV->setProyectoviasDirfinal($datos["dirFinal"]);
            $projectV->setProyectoviasCiv($datos["civ"]);
            $projectV->setPr($datos["civ"]);
//            var_dump($datos["dirInicio"]);

            $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get("doctrine.entitymanager.orm.default"));
            $dbh->insertObj($projectV);
        }
    }

}
