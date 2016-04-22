<?php

return array(
    'factories' => array(
        //services
        'Cms\Model\Service\ContenidoService' => 'Cms\Model\Service\Factory\ContenidoFactory',
        
        //forms
        'Cms\Form\ContenidoForm' => 'Cms\Form\Factory\ContenidoFactory',
        'Cms\Form\BuscarForm' => 'Cms\Form\Factory\BuscarFactory',
    ),
    'invokables' => array(
    ),
);