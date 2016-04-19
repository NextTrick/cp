<?php

namespace Orden;

return array(
    'router' => array(
        'routes' => array(
            'orden' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/orden',
                    'defaults' => array(
                        'controller' => 'Orden\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                // Defines that "/news" can be matched on its own without a child route being matched
                'may_terminate' => true,
                'child_routes' => array(
                    'crud' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route' => '[/:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                // Change this value to reflect the namespace in which
                                // the controllers for your module are found
                                '__NAMESPACE__' => 'Orden\Controller',
                                'controller'    => 'Index',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
