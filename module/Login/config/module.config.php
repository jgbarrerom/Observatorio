<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Login\Controller\Login' => 'Login\Controller\LoginController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(//nombre modulo
                'type' => 'Segment',
                'options' => array(
                    'route' => '/login[/[:action]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Login\Controller\Login',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    /**
     * la parte de doctrine sirve para la configuracion de la creacion de entities,
     * se le para el path donde se van a crear las clases
     * la clase doctrine que crea las anotaciones y
     * el driver 
     */
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Login/Model/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Login\Model\Entity' => 'application_entities'
                )
            ))),
    
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'login/login/login' => __DIR__ . '/../view/login/login/index.phtml',
            'layout/login' => __DIR__ . '/../view/layout/layout_1.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
