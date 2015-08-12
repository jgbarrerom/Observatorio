<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Vias\Controller\Vias' => 'Vias\Controller\ViasController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'vias' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vias[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Vias\Controller\Vias',
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
        'forbidden_template' => 'error/403',
        'exception_template' => 'error/index',
        'template_map' => array(
            'vias/vias/vias'  =>   __DIR__ . '/../view/vias/vias/index.phtml',
            'layout/layout'     =>   __DIR__ . '/../view/layout/layoutV.phtml',
            'layout/layoutV1'   =>   __DIR__ . '/../view/layout/layoutV1.phtml',
            'error/404'         =>   __DIR__ . '/../view/error/404.phtml',
            'error/403'         =>   __DIR__ . '/../view/error/403.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
