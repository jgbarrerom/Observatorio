<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Educacion\Controller\Index' => 'Educacion\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'educacion' => array(//nombre modulo
                'type' => 'Segment',
                'options' => array(
                    'route' => '/educacion[/[:action]][/[:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'    =>  '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Educacion\Controller\Index',
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
        'forbidden_template'       => 'error/403',
        'template_map' => array(
            'educacion/educacion/index' => __DIR__ . '/../view/educacion/index/index.phtml',
            'layout/educacion' => __DIR__ . '/../view/layout/layoutEducacion.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/403'               => __DIR__ . '/../view/error/403.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
