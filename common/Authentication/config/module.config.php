<?php
return array(
    'router' => array(
        'routes' => array(                        
            'auth' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/authentication[/:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Authentication\Controller',                                               
                        '__CONTROLLER__' => 'index',
                        'module'        => 'Authentication',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(                    
                    'default' => array(
                        'type' => 'Wildcard',
                        'options' => array(                            
                        ),
                    ),                    
                ),
            ),
        ),
    ),
    'view_manager' => array(     
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
