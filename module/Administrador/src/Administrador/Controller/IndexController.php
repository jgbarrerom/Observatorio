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
use Zend\Json\Json;

class IndexController extends AbstractActionController {
    
    
    public function addAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Crear Usuarios::.';
        $formAddUser = new FormAdmin($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $url = $this->getRequest()->getBaseUrl() . '/admin/confirmSave';
        return new ViewModel(array("formAdd" => $formAddUser, 'url' => $url));
    }

    public function consultarUsuarioAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Lista De Usuarios::.';
//        $this->setUsuario();
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $perfiles = $dbh->selectWhereJson('SELECT p.perfilNombre label,p.perfilId value FROM \Login\Model\Entity\Perfil p WHERE p.perfilId <> 1');
        $usuarioArray = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId <> 1');//selectAll('\Login\Model\Entity\Usuario');
        $arrayUser = $this->arrayUser($usuarioArray);
        
        return new ViewModel(array('listUser'=>Json::encode($arrayUser),'listaPerfil'=>$perfiles));
    }

    public function indexAction() {
       $this->layout('layout/admin');
       $this->layout()->titulo = '.::Administrador::.';
       return new ViewModel();
       
    }

    public function confirmSaveAction() {
        $this->layout('layout/admin');
        $this->layout()->titulo = '.::Confimar Creacion::.';
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $data = $this->getRequest()->getPost();
        $perfil = $this->serchPerfil($data['perfil']);
        $usuario = new \Login\Model\Entity\Usuario();
        $usuario->setUsuarioNombre($data['nombre']);
        $usuario->setUsuarioApellido($data['apellido']);
        $usuario->setUsuarioCorreo($data['correo']);
        $usuario->setPerfil($perfil);
        $pass = substr(md5(microtime()), 1, 8);
        $usuario->setUsuarioPassword(md5($pass));
        if ($dbh->insertObj($usuario)) {
            $usuario->setUsuarioPassword($pass);
//            $mail = new \Administrador\SendMail();
//            $mail->contruirCorreo();
            return new ViewModel(array('objUsuario' => $usuario));
        } else {
            return new ViewModel(array('msg' => 'Ha ocurrido un error al insertar el usuario'));
        }
    }

    public function editAction() {
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $jsonView = $this->getRequest()->getPost();
        $usuario = $dbh->selectWhere('SELECT u FROM \Login\Model\Entity\Usuario u WHERE u.usuarioId = :id', array('id'=>$jsonView['id']));
        if($jsonView['action'] == 'edit'){
            $dataUp = $jsonView['data'];
            $updateUser = $usuario[0];
            $updateUser->setUsuarioNombre($dataUp['nombre']);
            $updateUser->setUsuarioApellido($dataUp['apellido']);
            $updateUser->setUsuarioCorreo($dataUp['mail']);
            $perfil = $this->serchPerfil($dataUp['perfil']);
            $updateUser->setPerfil($perfil);
            $dataUpdate = array(
                'id'        =>  $updateUser->getUsuarioId(),
                'nombre'    =>  $updateUser->getUsuarioNombre(),
                'apellido'  =>  $updateUser->getUsuarioApellido(),
                'mail'      =>  $updateUser->getUsuarioCorreo(),
                'perfil'    =>  array(
                    'nombre'=>$updateUser->getPerfil()->getPerfilNombre(),
                    'id'=>$updateUser->getPerfil()->getPerfilId()
                )
            );
            if($dbh->insertObj($updateUser)){
                return new JsonModel($dataUpdate);
            }
        }elseif ($jsonView['action'] == 'remove') {
            $dbh->deleteObj($usuario[0]);
            return new JsonModel();
        }  else {
            throw new Exception("Esta opcion no existe", 403, '');
        }
    }
    
    private function serchPerfil($idPerfil){
        $dbh = new \Login\Model\DataBaseHelper($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $perfil = $dbh->selectWhere('SELECT p FROM \Login\Model\Entity\Perfil p WHERE p.perfilId = :idPerfil',array('idPerfil'=>$idPerfil));
        return $perfil[0];
    }
    
    private function arrayUser(array $usuarioArray){
        $i = 0;
        $arrayUser = array();
        foreach ($usuarioArray as $value) {
            $arrayUser[$i++]=array(
                'id'        =>  $value->getUsuarioId(),
                'nombre'    =>  $value->getUsuarioNombre(),
                'apellido'  =>  $value->getUsuarioApellido(),
                'mail'      =>  $value->getUsuarioCorreo(),
                'perfil'    =>  $value->getPerfil()->getPerfilNombre()
            );
        }
        return $arrayUser;
    }
}
