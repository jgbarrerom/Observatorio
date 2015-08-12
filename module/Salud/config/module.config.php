<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Salud\Controller\Salud' => 'Salud\Controller\SaludController'
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
                        'controller' => 'Salud\Controller\Salud',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'        => 'error/404',
        'forbidden_template'        => 'error/403',
        'exception_template'        => 'error/index',
        'template_map' => array(
            'salud/salud/salud' => __DIR__ . '/../view/salud/salud/index.phtml',
            'layout/salud'      => __DIR__ . '/../view/layout/layoutSalud.phtml',
            'error/404'         => __DIR__ . '/../view/error/404.phtml',
            'error/403'         => __DIR__ . '/../view/error/403.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
