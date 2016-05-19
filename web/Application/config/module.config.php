<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'application' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route' => 'application[/:controller[/:action[/:code]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'code' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                // Change this value to reflect the namespace in which
                                // the controllers for your module are found
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller'    => 'Index',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                )
            ),
            'web-registro' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/registrate[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Registro',
                        'action'     => 'index',
                    ),
                ),
            ),
            'web-completa-tu-registro' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/completa-tu-registro[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Registro',
                        'action'     => 'completa-tu-registro',
                    ),
                ),
            ),
//            'web-notificar' => array(
//                'type' => 'Segment',
//                'options' => array(
//                    'route'    => '/notificar-registro[/]',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Registro',
//                        'action'     => 'notificar',
//                    ),
//                ),
//            ),
            'web-activar-cuenta' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/activar-cuenta[/:codigo]',
                    'constraints' => array(
                        'code' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Registro',
                        'action'     => 'activar-cuenta',
                    ),
                ),
            ),
            'web-recuperar-password' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/recuperar-password[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Registro',
                        'action'     => 'recuperar-password',
                    ),
                ),
            ),
            /*'web-modificar-password' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/modificar-password[/:codigo]',
                    'constraints' => array(
                        'code' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Registro',
                        'action'     => 'modificar-password',
                    ),
                ),
            ),*/
            'web-mis-tarjetas' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/mis-tarjetas[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\MisTarjetas',
                        'action'     => 'index',
                    ),
                ),
            ),
            'web-tarjeta-unidad' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/mis-tarjetas/tarjeta-unidad',
                    'defaults' => array(
                        'controller' => 'Application\Controller\MisTarjetas',
                        'action'     => 'tarjeta-unidad',
                    ),
                ),
            ),
            'web-asociar-nueva-tarjeta' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/mis-tarjetas/asociar-nueva-tarjeta[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\MisTarjetas',
                        'action'     => 'asociar-nueva-tarjeta',
                    ),
                ),
            ),
            'web-editar-nombre' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/mis-tarjetas/editar-nombre[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\MisTarjetas',
                        'action'     => 'editar-nombre',
                    ),
                ),
            ),
            'web-beneficios' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/beneficios[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Beneficios',
                        'action'     => 'index',
                    ),
                ),
            ),
            'web-recargas' => array(
                'type' => 'Segment',
                'constraints' => array(
                    'code' => '[a-zA-Z][a-zA-Z0-9_-]*',
                ),
                'options' => array(
                    'route'    => '/recargas[/:codigo]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Recargas',
                        'action'     => 'index',
                    ),
                ),
            ),
            'web-pagos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/pagos[/:action]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Pagos',
                        'action'     => 'index',
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
            'web-carrito' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/carrito[/:action]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Carrito',
                        'action'     => 'index',
                    ),
                ),
            ),
            'web-login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Login',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'modalidad' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route' => '/[:action[/:opcion]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'opcion' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                // Change this value to reflect the namespace in which
                                // the controllers for your module are found
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller'    => 'Login',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                )
            ),
//            'web-panel' => array(
//                'type' => 'Literal',
//                'options' => array(
//                    'route'    => '/inbox',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Tarjeta',
//                        'action'     => 'index',
//                    ),
//                ),
//                'may_terminate' => true,
//                'child_routes' => array(
//                    'inbox' => array(
//                        'type'    => 'Segment',
//                        'options' => array(
//                            // Change this to something specific to your module
//                            'route' => '/[:controller[/:action[/:code]]]',
//                            'constraints' => array(
//                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'code' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                                // Change this value to reflect the namespace in which
//                                // the controllers for your module are found
//                                '__NAMESPACE__' => 'Application\Controller',
//                                'controller'    => 'Tarjeta',
//                                'action'        => 'index',
//                            ),
//                        ),
//                    ),
//                )
//            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
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
