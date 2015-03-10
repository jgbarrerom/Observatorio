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
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formCrearProyVia = new FormCrearProyectoVia($adapter);
        return new ViewModel(array("formCrearProyVia" => $formCrearProyVia, "url" => $this->getRequest()->getBaseUrl()));
    }

    public function guardarAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            $projectV = new proyectoV();
            $project = new proyecto();
            $tipoObra = $dbh->selectWhere('SELECT t FROM \Login\Model\Entity\TipoObra t WHERE t.tipoObra_Id = :id', array('id' => $datos["tipoObra"]));
            $eje = $dbh->selectWhere('SELECT t FROM \Login\Model\Entity\Eje t WHERE  t.eje_id = :id', array('id' => 1));
            $estado = $dbh->selectWhere('SELECT t FROM \Login\Model\Entity\Estado t WHERE t.estado_id = :id', array('id' => $datos["estado"]));
            $project->setEstado($estado);
            $project->setEje($eje);
            $project->setProyectoPathfotos('pendiente');
            $project->setProyectoPresupuesto($datos["presupuesto"]);
            $projectV->setProyecto($project);
            $projectV->setProyectoviasDirinicio($datos["dirInicio"]);
            $projectV->setProyectoviasDirfinal($datos["dirFinal"]);
            $projectV->setProyectoviasCiv($datos["civ"]);
            $projectV->setTipoobra($tipoObra);
            $projectV->setProyectoviasLargo($datos["largo"]);
            $projectV->setCoordenadas($datos["coordenadas"]);
            var_dump($datos["dirInicio"]);
            //  $dbh->insertObj($projectV);
        }
    }

}
