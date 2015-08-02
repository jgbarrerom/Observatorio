<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Administrador\Controller;

/**
 * Description of AdministracionUsuarioController
 *
 * @author JeissonGerardo
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Administrador\Form\FormAdmin;
use Administrador\Form\FormLugar;

class IndexController extends AbstractActionController {

    /**
     * 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Crear Usuarios::.';
        $formAddUser = new FormAdmin($this->em());
        $url = $this->getRequest()->getBaseUrl() . '/admin/confirmSave';
        return new ViewModel(array("formAdd" => $formAddUser, 'url' => $url));
    }

    public function listadolugaresAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Editar Lugares::.';
        $formLugar = new FormLugar($this->em());
        return new ViewModel(array("formLugar" => $formLugar));
    }

    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addlugarAction() {
        if ($this->getRequest()->isPost()) {
            $datos = $this->getRequest()->getPost();
            $lugar = new \Login\Model\Entity\Lugar();
            $lugar->setLugarNombre($datos['nombre']);
            $lugar->setLugarDireccion($datos['direccion']);
            $lugar->setLugarCoordenadas($datos['coordenadas']);
            $lugar->setLugarTelefono($datos['telefono']);
            $barrio = $this->dbh()->selectWhere("SELECT p FROM \Login\Model\Entity\Barrio p WHERE p.barrioId =:id", array('id' => $datos['barrio']));
            $tipoLugar = $this->dbh()->selectWhere("SELECT p FROM \Login\Model\Entity\TipoLugar p WHERE p.tipolugarId =:id", array('id' => $datos['tipoLugar']));
            $lugar->setBarrio($barrio[0]);
            $lugar->setTipolugar($tipoLugar[0]);
            if ($this->dbh()->insertObj($lugar)) {
                return new JsonModel(array('Result' => 'OK'));
            } else {
                return new JsonModel(array(
                    'Result' => 'ERROR',
                    'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
                );
            }
        } else {
            $this->layout('layout/admin');
            $this->layout()->titulo = '.::Crear Lugar::.';
            $formAddLugar = new FormLugar($this->em());
            $url = $this->getRequest()->getBaseUrl() . '/admin/addlugar';
            return new ViewModel(array("formLugar" => $formAddLugar, 'url' => $url));
        }
    }

    /**
     * Metodo para cargar la vista de edicion de usuarios
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function consultarUsuarioAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Lista De Usuarios::.';
        $formEdit = new FormAdmin($this->em());
        return new ViewModel(array("formEdit" => $formEdit));
    }

    /**
     * Metodo para listar los usuarios de la DB
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function listaUsuarioAction() {
        $arrayUser = $this->arrayUser($this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId <> 1'));
        return new JsonModel($arrayUser);
    }

    /**
     * Metodo para la vista de bienvenida del admin
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Administrador::.';
        return new ViewModel();
    }

    /**
     * Metodo que realiza la creacion de usuarios
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function confirmSaveAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Confimar Creacion::.';
        $data = $this->getRequest()->getPost();
        $arrayPermiso = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);
        foreach ($data->permisos as $key => $value) {
            $arrayPermiso[$key + 1] = $value;
        }
        $objPermisos = $this->dbh()->selectWhere("SELECT p FROM \Login\Model\Entity\Permiso p WHERE p.permisoId IN (?1,?2,?3,?4)", $arrayPermiso);
        $perfil = $this->serchPerfil(array('id' => $data['perfil']));
        $usuario = new \Login\Model\Entity\Usuario();
        $usuario->setUsuarioNombre($data['nombre']);
        $usuario->setUsuarioApellido($data['apellido']);
        $usuario->setUsuarioCorreo($data['correo']);
        $usuario->setPerfil($perfil);
        foreach ($objPermisos as $value) {
            $usuario->addPermiso($value);
            $value->addUsuario($usuario);
        }
        $pass = substr(md5(microtime()), 1, 8);
        $usuario->setUsuarioPassword(md5($pass));
        if ($this->dbh()->insertObj($usuario)) {
            $usuario->setUsuarioPassword($pass);
            return new ViewModel(array('objUsuario' => $usuario));
        } else {
            return new ViewModel(array('msg' => 'Ha ocurrido un error al insertar el usuario por favor intente mas tarde'));
        }
    }

    /**
     * Metodo para editar la informacion de un usuario
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function editAction() {
        $jsonView = $this->getRequest()->getPost();
        $usuario = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId = :id', array('id' => $jsonView['Id']));
        $updateUser = $usuario[0];
        $updateUser->setUsuarioNombre($jsonView['nombre']);
        $updateUser->setUsuarioApellido($jsonView['apellido']);
        $updateUser->setUsuarioCorreo($jsonView['correo']);
        $updateUser->setPerfil($this->serchPerfil(array('id' => $jsonView['perfil'])));
        foreach ($updateUser->getPermiso() as $value) {
            $value->removeUsuario($updateUser);
        }
        $updateUser->getPermiso()->clear();
        $arrayPermiso = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);
        foreach ($jsonView['permisos'] as $key => $value) {
            $arrayPermiso[$key + 1] = $value;
        }
        $permisos = $this->dbh()->selectWhere("SELECT p FROM \Login\Model\Entity\Permiso p WHERE p.permisoId IN (?1,?2,?3,?4)", $arrayPermiso);
        foreach ($permisos as $value) {
            $updateUser->addPermiso($value);
            $value->addUsuario($updateUser);
        }
        if ($this->dbh()->insertObj($updateUser)) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    /**
     * Metodo para borrar los usuarios de la BD
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteAction() {
        $jsonView = $this->getRequest()->getPost();
        $usuario = $this->dbh()->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId = :id', array('id' => $jsonView['Id']));
        if ($this->dbh()->deleteObj($usuario[0])) {
            return new JsonModel(array('Result' => 'OK'));
        } else {
            return new JsonModel(array(
                'Result' => 'ERROR',
                'Message' => 'Estamos presentando inconvenientes, por favor intente mas tarde')
            );
        }
    }

    /**
     * Metodo que funciona para buscar perfiles por el ID
     * 
     * @param array $idPerfil
     * @return \Login\Model\Entity\Perfil
     */
    private function serchPerfil(array $idPerfil) {
        $perfil = $this->dbh()->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId = :id', $idPerfil);
        return $perfil[0];
    }

    /**
     * Metodo que funciona para buscar perfiles dependiendo del ID
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function serchPerfilAction() {
        $perfil = $this->dbh()->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId <> 1');
        $arrayPerfil = array();
        foreach ($perfil as $key => $value) {
            $arrayPerfil[$key] = array(
                'DisplayText' => $value->getPerfilNombre(),
                'Value' => $value->getPerfilId()
            );
        }
        $arrayJson = array(
            'Result' => 'OK',
            'Options' => $arrayPerfil
        );
        return new JsonModel($arrayJson);
    }

    /**
     * Metodo para listar todos los usuario con la estructura de la DataTable jQuery
     * 
     * @param array $usuarioArray
     * @return array
     */
    private function arrayUser(array $usuarioArray) {
        $arrayJason = array();
        foreach ($usuarioArray as $key => $value) {
            $arrayJason[$key] = array(
                'Id' => $value->getUsuarioId(),
                'Nombre' => $value->getUsuarioNombre(),
                'Apellido' => $value->getUsuarioApellido(),
                'Correo' => $value->getUsuarioCorreo(),
                'perfil' => $value->getPerfil()->getPerfilNombre(),
                'permisos' => $value->getArrayPermiso()
            );
        }
        $arrayUser = array(
            'Result' => 'OK',
            'Records' => $arrayJason
        );
        return $arrayUser;
    }

    public function editarlugarAction() {
        $datos = $this->getRequest()->getPost();
        $lugarArr = $this->dbh()->selectAllById(array('lugarId' => $datos['id']), '\Login\Model\Entity\Lugar');
        $barrio = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\Barrio b WHERE b.barrioId = :id', array('id' => $datos['barrio']));
        $tipo = $this->dbh()->selectWhere('SELECT b FROM \Login\Model\Entity\TipoLugar b WHERE b.tipolugarId = :id', array('id' => $datos['tipoLugar']));
        $lugar = $lugarArr[0];
        $lugar->setBarrio($barrio[0]);
        $lugar->setTipolugar($tipo[0]);
        $lugar->setLugarCoordenadas($datos['coordenadas']);
        $lugar->setLugarDireccion($datos['direccion']);
        $lugar->setLugarNombre($datos['nombre']);
        $lugar->setLugartelefono($datos['telefono']);
        if ($this->dbh()->insertObj($lugar)) {
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
    public function jsonlugaresAction() {
        $resultSelect = $this->dbh()->selectAll('\Login\Model\Entity\Lugar');
        $json = $this->lugares_json($resultSelect);
        return new JsonModel($json);
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
     * Mostrar Vista de Sugerencias
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function sugerenciaAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Sugerencias::.';
        return new ViewModel();
    }

    /**
     * Json que retorne lista de sugerencias
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function listSugerenciaAction() {
        $listSuge = $this->sugerencia($this->dbh()->selectWhere('SELECT s FROM \Login\Model\Entity\Sugerencia s'));
        return new JsonModel(array('sug' => $listSuge));
    }

    /**
     * Crea array para el retorno a la vista de sugerencias
     * 
     * @param array $lista
     * @return type
     */
    private function sugerencia(array $lista) {
        $arraySugeren = array();
        foreach ($lista as $value) {
            $arraySugeren[] = array(
                'id' => $value->getSugerenciaId(),
                'nombre' => $value->getSugerenciaNombre(),
                'apellido' => $value->getSugerenciaApellido(),
                'tele' => $value->getSugerenciaTelefono(),
                'fecha' => $value->getSugerenciaFecha(),
                'mail' => $value->getSugerenciaCorreo(),
                'coment' => $value->getSugerenciaComentario(),
                'leido' => $value->getSugerenciaLeido(),
                'barrio' => $value->getBarrio()->getBarrioNombre(),
            );
        }
        return $arraySugeren;
    }

    /**
     * Metodo que actualiza estado de sugerencia
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function updateSugeAction() {
        $datos = $this->getRequest()->getPost();
        $sugerencia = $this->dbh()->selectAllById(array('sugerenciaId'=>$datos['id']),'\Login\Model\Entity\Sugerencia');
        $sugerencia[0]->setSugerenciaLeido(true);
        if ($this->dbh()->insertObj($sugerencia[0])) {
            $container = new \Zend\Session\Container('cbol');
            $container->sugerencias--; 
            return new JsonModel(array('Status'=>'OK'));
        } else {
            return new JsonModel(array('Status'=>'NOK'));
        }
    }

}
