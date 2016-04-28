<?php

return array(
    'factories' => array(
        //services
        'Orden\Model\Service\CarritoService' => 'Orden\Model\Service\Factory\CarritoFactory',
        'Orden\Model\Service\OrdenService' => 'Orden\Model\Service\Factory\OrdenFactory',
        
        //forms
        'Orden\Form\CarritoForm' => 'Orden\Form\Factory\CarritoFactory',
        'Orden\Form\OrdenForm' => 'Orden\Form\Factory\OrdenFactory',
        'Orden\Form\BuscarForm'  => 'Orden\Form\Factory\BuscarFactory',
    ),
    'invokables' => array(
    ),
);