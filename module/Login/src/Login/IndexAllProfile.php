<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login;

/**
 * Description of IndexAllProfile
 *
 * @author JeissonGerardo
 */
class IndexAllProfile {
    
    /**
     * Metodo que retorna la pagina de inicio de cada perfil
     * @param type $idProfile
     * @return string
     */
    static function listIndexAllProfiles($idProfile){
        $indexProfile = array(
            1=>'admin',
            2=>'educacion',
            3=>'salud',
            4=>'vias'
        );
        return $indexProfile[$idProfile];
    }
}
