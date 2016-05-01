<?php
namespace Admin;

return array(
    'invokables' => array(
        'Admin\Controller\Login' => 'Admin\Controller\LoginController',
        'Admin\Controller\Error' => 'Admin\Controller\ErrorController',
        'Admin\Controller\Main' => 'Admin\Controller\MainController',
        'Admin\Controller\Rol' => 'Admin\Controller\RolController',
        'Admin\Controller\Usuario' => 'Admin\Controller\UsuarioController',
        'Admin\Controller\Recurso' => 'Admin\Controller\RecursoController',
        'Admin\Controller\Permiso' => 'Admin\Controller\PermisoController',
        
        'Admin\Controller\Contenido' => 'Admin\Controller\ContenidoController',
        'Admin\Controller\Paquete' => 'Admin\Controller\PaqueteController',
        
        'Orden\Controller\Orden' => 'Orden\Controller\OrdenController',
        'Orden\Controller\Carrito' => 'Orden\Controller\CarritoController',
    ),
);