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
use Salud\Form\FormularioSalud;

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
        $arrayPvias = $this->arrayProyVias($this->dataBaseHelperMethod()->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoVias p'));
        return new JsonModel($arrayPvias);
    }

    private function arrayProyVias(array $arrayPvias) {
        $arrayJason = array();
        $json_imagenes = "";
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
        $em = $this->entityManager()->getConnection();

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

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function reporteViaAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Reporte Vial::.";
        $formReporte = new \Application\Form\Formularios($this->entityManager());
        return new ViewModel(array('formReporte' => $formReporte));
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function saveReporteViaAction() {
        $formulario = $this->getRequest()->getPost();
        $foto = $this->getRequest()->getFiles()->toArray();
        $type = $foto['photo']['type'];
        $nameFile = '';
        switch ($type) {
            case 'image/png':
                $nameFile = date('Ymd_Gis') . '.png';
                break;
            case 'image/jpeg':
                $nameFile = date('Ymd_Gis') . '.jpg';
                break;
        }
        $reporte = new \Login\Model\Entity\ReporteVia();
        $barrio = $this->dataBaseHelperMethod()->selectAllById(array("barrioId" => $formulario['barrios']), '\Login\Model\Entity\Barrio');
        $reporte->setReporteviaDireccion($formulario['direccion']);
        $reporte->setReporteviaObservacion($formulario['observacion']);
        $reporte->setBarrio($barrio[0]);
        $reporte->setReporteviasFotos($nameFile);
        $reporte->setReporteviaFecha(new \DateTime(date('Y-m-d h:i:s')));
        if ($this->dataBaseHelperMethod()->insertObj($reporte)) {
            $foto['photo']['name'] = $nameFile;
            $filter = new \Zend\Filter\File\RenameUpload('./public/fotografias/Reports/');
            $filter->setUseUploadName(true);
            $filter->filter($foto['photo']);
            return new JsonModel(array("Result" => "OK"));
        } else {
            return new JsonModel(array("Result" => "NOK"));
        }
    }

    /**
     * Actualizar estado de lectura en reportes viales
     * @return \Zend\View\Model\JsonModel
     */
    public function updateLeidoAction() {
        $contenido = new \Zend\Session\Container('cbol');
        $leido = $this->getRequest()->getPost();
        $objRepo = new \Login\Model\Entity\ReporteVia();
        $objSelecRepo = $this->dataBaseHelperMethod()->selectAllById(array('reporteviaId' => $leido['read']), '\Login\Model\Entity\ReporteVia');
        $objRepo = $objSelecRepo[0];
        $objRepo->setReporteviaLeido(true);
        if ($this->dataBaseHelperMethod()->insertObj($objRepo)) {
            $contenido->reportesVias--;
            return new JsonModel(array('result' => 'OK'));
        } else {
            return new JsonModel(array('result' => 'NOK'));
        }
    }

    public function lugaresAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Lugares::.";
        return new ViewModel();
    }

    public function jsonlugaresAction() {
        $resultSelect = $this->dataBaseHelperMethod()->selectAll('\Login\Model\Entity\Lugar');
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

    public function listadosaludAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Proyectos Salud::.';
        $adapter = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $formSalud = new FormularioSalud($adapter);
        return new ViewModel(array('formSalud' => $formSalud));
    }

    private function arrayProySalud($arrayPsalud) {
        $arrayJason = array();
        foreach ($arrayPsalud as $key => $value) {
            $arrayJason[$key] = array(
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

    public function listadoSaludJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $arrayPsalud = $this->arrayProySalud($dbh->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoSalud p'));
        return new JsonModel($arrayPsalud);
    }

    public function listadoActividadesJsonAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $arrayActividades = $this->arrayActividadesProyecto($dbh->selectWhere('SELECT a FROM Login\Model\Entity\ActividadSalud a where a.proyecto=:id', array('id' => $jsonView['Id'])));
        return new JsonModel($arrayActividades);
    }

    private function arrayActividadesProyecto($arrayActividades) {
        $arrayJason = array();
        foreach ($arrayActividades as $key => $value) {
            $arrayJason[$key] = array(
                'id' => $value->getActividadsaludId(),
                'nombre' => $value->getActividadsaludNombre(),
                'lugar' => $value->getLugar()->getLugarNombre(),
                'fechaHora' => $value->getActividadsaludFechahora()->format('d/m/Y H:i'),
                'objetivos' => $value->getActividadsaludObjetivo(),
                'requisitos' => $value->getActividadsaludRequisitos(),
            );
        }
        $arraySalud = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arraySalud;
    }

    /**
     * Crea instancia de dataBaseHelper
     * @return \Login\Model\DataBaseHelper
     */
    protected function dataBaseHelperMethod() {
        $dbh = new \Login\Model\DataBaseHelper($this->entityManager());
        return $dbh;
    }

    protected function entityManager() {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

}
