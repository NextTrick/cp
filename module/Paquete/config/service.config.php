<?php

return array(
    'factories' => array(
        //services
        'Paquete\Model\Service\PaqueteService' => 'Paquete\Model\Service\Factory\PaqueteFactory',
        
        //forms
        'Paquete\Form\PaqueteForm' => 'Paquete\Form\Factory\PaqueteFactory',
    ),
    'invokables' => array(
    ),
);