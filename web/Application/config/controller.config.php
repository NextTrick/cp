<?php
namespace Application;

return array(
    'invokables' => array(
        'Application\Controller\Index' => 'Application\Controller\IndexController',
        'Application\Controller\Inicio' => 'Application\Controller\InicioController',
        'Application\Controller\Login' => 'Application\Controller\LoginController',
        'Application\Controller\Registro' => 'Application\Controller\RegistroController',
        'Application\Controller\Tarjeta' => 'Application\Controller\TarjetaController',
        'Application\Controller\Ubigeo' => 'Application\Controller\UbigeoController',
        'Application\Controller\MisTarjetas' => 'Application\Controller\MisTarjetasController',
        'Application\Controller\MisDatos' => 'Application\Controller\MisDatosController',
        'Application\Controller\Recargas' => 'Application\Controller\RecargasController',
        'Application\Controller\Beneficios' => 'Application\Controller\BeneficiosController',
        'Application\Controller\Carrito' => 'Application\Controller\CarritoController',
        'Application\Controller\Pagos' => 'Application\Controller\PagosController',
        'Application\Controller\Test' => 'Application\Controller\TestController',
    ),
);