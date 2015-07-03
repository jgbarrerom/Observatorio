<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\Query\ResultSetMapping;
use Login\Model\Entity\TipoLugar;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = "Observatorio";

        return new ViewModel();
    }

    public function listadoViasAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Lista Obras Viales::.';
        return new ViewModel();
    }

    /*
     * consuta todas los proyectos de vias existentes y retorna a la vista un json 
     */

    public function listadoViasJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayPvias = $this->arrayProyVias($dbh->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoVias p'));
        return new JsonModel($arrayPvias);
    }

    private function arrayProyVias(array $arrayPvias) {
        $arrayJason = array();
         $json_imagenes ="";
        foreach ($arrayPvias as $key => $value) {
            $ruta = './public/fotografias/' . $value->getProyecto()->getProyectoId() . '/';
            $imagenes = array();
            if (is_dir($ruta)) {
                if ($dh = opendir($ruta)) {

                    while (($file = readdir($dh)) !== false) {
                        if (is_file($ruta . '/' . $file)) {
                            array_push($imagenes, '/fotografias/' . $value->getProyecto()->getProyectoId() . '/' . $file);
                        }
                    }
                    $json_imagenes = implode(",", $imagenes);
                }
            }

            $arrayJason[$key] = array(
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
                'upz' => $value->getBarrio()->getUpz()->getUpzNombre(),
                'tipo' => $value->getTipoobra()->getTipoobraNombre(),
                'imagenes' => $json_imagenes
            );
        }
        $arrayVias = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arrayVias;
    }

    public function estadisticasViasAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Estadisticas::.";
    }

    public function estjsonAction() {
        $em = $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')->getConnection();
        // prepare statement
        $sth = $em->prepare("CALL viaUpzAnio()");
        // execute and fetch
        $sth->execute();
        $result = $sth->fetch();
        $json = json_decode($result['datos']);
        return new JsonModel(array('resultado' => $json));
    }

    public function noticiasSaludAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Noticias Salud::.";
        return new ViewModel();
    }

    public function reporteViaAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Reporte Vial::.";
        $formReporte = new \Application\Form\Formularios($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        return new ViewModel(array('formReporte' => $formReporte));
    }

    public function lugaresAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Lugares::.";
        return new ViewModel();
    }

    public function jsonlugaresAction() {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $dbh = new \Login\Model\DataBaseHelper($em);
        $resultSelect = $dbh->selectAll('\Login\Model\Entity\Lugar');
        $json = $this->lugares_json($resultSelect);
        return new JsonModel(array('resultado' => $json));
    }

    private function lugares_json(array $arraylugares) {
        $arrayJason = array();
        foreach ($arraylugares as $key => $value) {
            $arrayJason[$key] = array(
                'id' => $value->getLugarId(),
                'nombre' => $value->getLugarNombre(),
                'direccion' => $value->getLugarDireccion(),
                'coordenadas' => $value->getLugarCoordenadas(),
                'telefono' => $value->getLugarTelefono(),
                'tipo' => $value->getTipolugar()->getTipolugarNombre(),
                'barrio' => $value->getBarrio()->getBarrioNombre()
            );
        }
        $arrayJason = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arrayJason;
    }

}
