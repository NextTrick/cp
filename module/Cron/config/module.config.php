<?php

namespace Cron;

return array(
    'controllers' => array(
        'invokables' => array(
            'Cron\Controller\Tarjeta' => 'Cron\Controller\TarjetaController',
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'actualizar-tarjetas' => array(
                    'type'    => 'simple',
                    'options' => array(
                        // add [ and ] if optional ( ex : [<doname>] )
                        'route' => 'actualizar tarjetas', 
                        'defaults' => array(
                            '__NAMESPACE__' => 'Cron\Controller',
                            'controller' => 'Tarjeta',
                            'action' => 'actualizar'
                        ),
                    ),
                ),
                'actualizar-promociones' => array(
                    'type'    => 'simple',
                    'options' => array(
                        // add [ and ] if optional ( ex : [<doname>] )
                        'route' => 'actualizar promociones', 
                        'defaults' => array(
                            '__NAMESPACE__' => 'Cron\Controller',
                            'controller' => 'Paquete',
                            'action' => 'actualizar'
                        ),
                    ),
                ),
            )
        )
    ),
);