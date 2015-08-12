<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Administrador\Controller\Admin' => 'Administrador\Controller\AdminController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'administrador' => array( 
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin[/[:action]][/[:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'    =>  '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Administrador\Controller\Admin',
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
            'administrador/administrador/admin' => __DIR__ . '/../view/administrador/admin/index.phtml',
            'layout/admin' => __DIR__ . '/../view/layout/layoutAdmin.phtml',
            'error/403'               => __DIR__ . '/../view/error/403.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
