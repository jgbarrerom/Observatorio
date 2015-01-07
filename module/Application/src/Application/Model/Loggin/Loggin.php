<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loggin
 *
 * @author Jeisson
 */
class Loggin {
    public function validateLiggin($pass = "") {
        $adapter = new Zend\Db\Adapter\Adapter(array(
           'driver' => 'Pdo_Mysql',
            'database'=>'usuarioscbol',
            'username'=>'root',
            'password'=>''
        ));
                
        return true;
    }
}
