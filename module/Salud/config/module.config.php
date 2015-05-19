<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Salud\Controller\Index' => 'Salud\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'salud' => array(//nombre modulo
                'type' => 'Segment',
                'options' => array(
                    'route' => '/salud[/[:action]][/[:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'    =>  '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Salud\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'salud/salud/index' => __DIR__ . '/../view/salud/index/index.phtml',
            'layout/salud' => __DIR__ . '/../view/layout/layoutSalud.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);