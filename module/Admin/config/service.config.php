<?php

return array(
    'factories' => array(
        //services
        'Admin\Model\Service\LoginService' => 'Admin\Model\Service\Factory\LoginFactory',
        'Admin\Model\Service\UsuarioService' => 'Admin\Model\Service\Factory\UsuarioFactory',
        'Admin\Model\Service\RolService' => 'Admin\Model\Service\Factory\RolFactory',
        'Admin\Model\Service\RecursoService' => 'Admin\Model\Service\Factory\RecursoFactory',
        'Admin\Model\Service\PermisoService' => 'Admin\Model\Service\Factory\PermisoFactory',
        'Admin\Model\Service\DetalleOrdenService' => 'Admin\Model\Service\Factory\DetalleOrdenFactory',
        
        //forms
        'Admin\Form\LoginForm' => 'Admin\Form\Factory\LoginFactory',
        'Admin\Form\UsuarioForm' => 'Admin\Form\Factory\UsuarioFactory',
        'Admin\Form\RolForm' => 'Admin\Form\Factory\RolFactory',
        'Admin\Form\RecursoForm' => 'Admin\Form\Factory\RecursoFactory',
        'Admin\Form\PermisoForm' => 'Admin\Form\Factory\PermisoFactory',
        'Admin\Form\DetalleOrdenBuscarForm' => 'Admin\Form\Factory\DetalleOrdenBuscarFactory',
    ),
    'invokables' => array(
    ),
);