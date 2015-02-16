<?php
return array(
    'controllers'=>array(
        'invokables'=>array(
            'Login\Controller\Login'=>'Login\Controller\LoginController'
        ),
    ),
    
    'router'=>array(
        'routes'=>array(
            'login'=>array(//nombre modulo
                'type'=>'Segment',
                'options'=>array(
                    'route'=>'/login[/[:action]]',
                    'constraints'=>array(
                        'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'=>array(
                        'controller'=>'Login\Controller\Login',
                        'action'=>'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'login/login/login' => __DIR__ . '/../view/login/login/index.phtml',
           
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);