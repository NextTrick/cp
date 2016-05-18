<?php
return array(
    'router' => array(
        'routes' => array(
            'payment' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/payment-processor[/:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'PaymentProcessor\Controller',
                        '__CONTROLLER__' => 'index',
                        'module'        => 'PaymentProcessor',
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
