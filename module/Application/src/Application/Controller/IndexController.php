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

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = "Observatorio";

        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function listadoViasAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Lista Obras Viales::.';
        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function listadoEducacionAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Lista de Proyectos::.';
        return new ViewModel();
    }

    /**
     * consuta todas los proyectos de vias existentes y retorna a la vista un json 
     */

    public function listadoViasJsonAction() {
        $arrayPvias = $this->arrayProyVias($this->dbh()->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoVias p'));
        return new JsonModel($arrayPvias);
    }

    /**
     * 
     * @param array $arrayPvias
     * @return type
     */
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

    /**
     * 
     */
    public function estadisticasViasAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Estadisticas::.";
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function estjsonAction() {
        $em = $this->em()->getConnection();

        // prepare statement
        $sth = $em->prepare("CALL viaUpzAnio()");
        // execute and fetch
        $sth->execute();
        $result = $sth->fetch();
        $json = json_decode($result['datos']);
        return new JsonModel(array('resultado' => $json));
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function noticiasAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Noticias::.';
        $listaActividades = $this->dbh()->selectAll('\Login\Model\Entity\Actividad');
        return new ViewModel(array('listado' => $listaActividades));
    }

    /**
     * 
     * @param array $arrayNoticias
     * @return type
     */
    public function noticiasJsonAction(array $arrayNoticias) {
        $arrayNoticias = array();
        foreach ($arrayNoticias as $key => $value) {
            $arrayJason[$key] = array(
                'nombre' => $value->getActividadNombre(),
                'lugar' => $value->getLugar()->getLugarNombre(),
                'fechaHora' => $value->getLugarDireccion(),
                'objetivo' => $value->getLugarCoordenadas(),
                'Requisitos' => $value->getLugarTelefono(),
                'barrio' => $value->getTipolugar()->getTipolugarNombre(),
                'direccion' => $value->getBarrio()->getBarrioNombre(),
                'telefono' => $value->getBarrio()->getBarrioNombre()
            );
        }
        $arrayJason = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arrayJason;
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function reporteViaAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Reporte Vial::.";
        $formReporte = new \Application\Form\Formularios($this->em());
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
        $barrio = $this->dbh()->selectAllById(array("barrioId" => $formulario['barrios']), '\Login\Model\Entity\Barrio');
        $reporte->setReporteviaDireccion($formulario['direccion']);
        $reporte->setReporteviaObservacion($formulario['observacion']);
        $reporte->setBarrio($barrio[0]);
        $reporte->setReporteviasFotos($nameFile);
        $reporte->setReporteviaFecha(new \DateTime(date('Y-m-d h:i:s')));
        if ($this->dbh()->insertObj($reporte)) {
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
        $objSelecRepo = $this->dbh()->selectAllById(array('reporteviaId' => $leido['read']), '\Login\Model\Entity\ReporteVia');
        $objRepo = $objSelecRepo[0];
        $objRepo->setReporteviaLeido(true);
        if ($this->dbh()->insertObj($objRepo)) {
            $contenido->reportesVias--;
            return new JsonModel(array('result' => 'OK'));
        } else {
            return new JsonModel(array('result' => 'NOK'));
        }
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function lugaresAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Lugares::.";
        return new ViewModel();
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function proyectoSaludAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Detalle proyecto::.";
        $datos = $this->getRequest()->getPost();
        $proySalud = $this->dbh()->selectWhere('select r from \Login\Model\Entity\ProyectoSalud r where r.proyecto =:id', array('id' => $datos['id']));
        $resultado = $proySalud[0]->getProyecto()->getProyectoResultados();
        $ruta = './public/fotografias/' . $proySalud[0]->getProyecto()->getProyectoId() . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $proySalud[0]->getProyecto()->getProyectoId() . '/' . $file);
                    }
                }
            }
        }
        if ($proySalud[0]->getProyecto()->getEstado()->getEstadoId() == 3) {
            return new ViewModel(array('validacion' => true, 'resultado' => $resultado, 'proySalud' => $proySalud[0], 'imagenes' => $imagenes));
        } else {
            return new ViewModel(array('validacion' => false, 'proySalud' => $proySalud[0], 'imagenes' => $imagenes));
        }
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function proyectoEducacionAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = ".::Detalle proyecto::.";
        $datos = $this->getRequest()->getPost();
        $proyEducacion = $this->dbh()->selectWhere('select r from \Login\Model\Entity\ProyectoEducacion r where r.proyecto =:id', array('id' => $datos['id']));
        $resultado = $proyEducacion[0]->getProyecto()->getProyectoResultados();
        $ruta = './public/fotografias/' . $proyEducacion[0]->getProyecto()->getProyectoId() . '/';
        $imagenes = array();
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {

                while (($file = readdir($dh)) !== false) {
                    if (is_file($ruta . '/' . $file)) {
                        array_push($imagenes, '/fotografias/' . $proyEducacion[0]->getProyecto()->getProyectoId() . '/' . $file);
                    }
                }
            }
        }
        if ($proyEducacion[0]->getProyecto()->getEstado()->getEstadoId() == 3) {
            return new ViewModel(array('validacion' => true, 'resultado' => $resultado, 'proyEducacion' => $proyEducacion[0], 'imagenes' => $imagenes));
        } else {
            return new ViewModel(array('validacion' => false, 'proyEducacion' => $proyEducacion[0], 'imagenes' => $imagenes));
        }
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function jsonlugaresAction() {
        $resultSelect = $this->dbh()->selectAll('\Login\Model\Entity\Lugar');
        $json = $this->lugares_json($resultSelect);
        return new JsonModel(array('resultado' => $json));
    }

    /**
     * 
     * @param array $arraylugares
     * @return string
     */
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

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function listadosaludAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Proyectos Salud::.';
        $formSalud = new FormularioSalud($this->em());
        return new ViewModel(array('formSalud' => $formSalud));
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
                'id' => $value->getProyecto()->getProyectoId(),
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

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function listadoEducacionJsonAction() {
        $arrayEducacion = $this->arrayProyEducacion($this->dbh()->selectWhere('SELECT p FROM Login\Model\Entity\ProyectoEducacion p'));
        return new JsonModel($arrayEducacion);
    }

    /**
     * 
     * @param type $arrayPsalud
     * @return type
     */
    private function arrayProyEducacion($arrayPsalud) {
        $arrayJason = array();
        foreach ($arrayPsalud as $key => $value) {
            $arrayJason[$key] = array(
                'id' => $value->getProyecto()->getProyectoId(),
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
        $arrayActividades = $this->arrayActividadesProyecto($this->dbh()->selectWhere('SELECT a FROM Login\Model\Entity\ActividadSalud a where a.proyecto=:id', array('id' => $jsonView['Id'])));
        return new JsonModel($arrayActividades);
    }

    /**
     * 
     * @param type $arrayActividades
     * @return string
     */
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
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function sugerenciasAction() {
        $this->layout('layout/anonimus');
        $this->layout()->titulo = '.::Sugerencias::.';
        return new ViewModel(array('formSugerencia' => new \Application\Form\Formularios($this->em())));
    }

    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function saveSugerenciaAction() {
        $formSugerencia = new \Application\Form\Formularios($this->em());
        $formAuth = new \Application\Model\FormulariosAuth();
        $formSugerencia->setInputFilter($formAuth->getInputFilter());
        $dataSugeren = $this->getRequest()->getPost();
        $formSugerencia->setData($dataSugeren);
        if ($formSugerencia->isValid()) {
            $barrio = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Barrio b WHERE b.barrioId =:id',array('id' => $dataSugeren['barrios']));
            $sugerencia = new \Login\Model\Entity\Sugerencia();
            $sugerencia->setSugerenciaNombre($dataSugeren['nombre']);
            $sugerencia->setSugerenciaApellido($dataSugeren['apellido']);
            $sugerencia->setSugerenciaTelefono($dataSugeren['tele']);
            $sugerencia->setSugerenciaCorreo($dataSugeren['mail']);
            $sugerencia->setBarrio($barrio[0]);
            $sugerencia->setSugerenciaComentario($dataSugeren['observacion']);
            if ($this->dbh()->insertObj($sugerencia)) {
                return new JsonModel(array('OK'));
            } else {
                $this->getResponse()->setStatusCode(500);
                return new JsonModel(array('NOK'));
            }
        }else{
            $this->getResponse()->setStatusCode(500);
            return new JsonModel(array('NOK'));
        }
    }

}
