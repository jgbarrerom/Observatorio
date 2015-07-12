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
    'service_manager' => array(
        'invokables' => array(
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
            'Zend\Mvc\Controller\AbstractController' => 'Zend\Mvc\Controller\AbstractController'
        ),
    ),
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'cbol',
                'cookie_httponly' => true,
                'cookie_lifetime' => 3600,
                'gc_maxlifetime' => 3600,
                'remember_me_seconds' => 3600,
            ),
            'authentication_expiration_time' => 300
        ),
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
    ),
);
