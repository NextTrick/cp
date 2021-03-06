<?php

return array(
    'factories' => array(
        //services
        'Orden\Model\Service\CarritoService' => 'Orden\Model\Service\Factory\CarritoFactory',
        'Orden\Model\Service\OrdenService' => 'Orden\Model\Service\Factory\OrdenFactory',
        'Orden\Model\Service\DetalleOrdenService' => 'Orden\Model\Service\Factory\DetalleOrdenFactory',
        'Orden\Model\Service\RequestHistorialService' => 'Orden\Model\Service\Factory\RequestHistorialFactory',
        
        //forms
        'Orden\Form\CarritoForm' => 'Orden\Form\Factory\CarritoFactory',
        'Orden\Form\OrdenForm' => 'Orden\Form\Factory\OrdenFactory',
        'Orden\Form\BuscarForm'  => 'Orden\Form\Factory\BuscarFactory',
        'Orden\Form\CarritoBuscarForm'  => 'Orden\Form\Factory\CarritoBuscarFactory',
    ),
    'invokables' => array(
    ),
);