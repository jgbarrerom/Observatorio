<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager'=>array(
        'invokables'=>array(
            'Zend\Authentication\AuthenticationService'=>'Zend\Authentication\AuthenticationService',
            'Zend\Mvc\Controller\AbstractController'=>'Zend\Mvc\Controller\AbstractController',
        ),
    ),
    'module_layouts'=>array(
        'Login'     => 'layout/layout_1.phtml',
        'Vias'      => 'layout/layoutV.phtml',
    ),
    'session_config'    =>  array
                                (
                                    'cache_expire'          =>  60*60*2,
                                    'name'                  =>  'sessionName',
                                    'cookie_lifetime'       =>  60*60*2,
                                    'gc_maxlifetime'        =>  60*60*2,
                                    'cookie_path'           =>  '/',
                                    'cookie_secure'         =>  false,
                                    'remember_me_seconds'   =>  60*60*2,
                                    'use_cookies'           =>  true,
                                ),
);
