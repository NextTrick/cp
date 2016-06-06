<?php

return array(
    'factories' => array(
        'Zend\Session\SessionManager' => function ($sm) {
            $config = $sm->get('config');
            if (isset($config['session'])) {
                $session = $config['session'];

                $sessionConfig = null;
                if (isset($session['config'])) {
                    $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                    $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                    $sessionConfig = new $class();
                    $sessionConfig->setOptions($options);
                }

                $sessionStorage = null;
                if (isset($session['storage'])) {
                    $class = $session['storage'];
                    $sessionStorage = new $class();
                }

                $sessionSaveHandler = null;
                if (isset($session['save_handler'])) {
                    // class should be fetched from service manager since it will require constructor arguments
                    $sessionSaveHandler = $sm->get($session['save_handler']);
                }

                $sessionManager = new \Zend\Session\SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
            } else {
                $sessionManager = new \Zend\Session\SessionManager();
            }
            \Zend\Session\Container::setDefaultManager($sessionManager);
            return $sessionManager;
        },
        //services
        'Admin\Model\Service\LoginService' => 'Admin\Model\Service\Factory\LoginFactory',
        'Admin\Model\Service\UsuarioService' => 'Admin\Model\Service\Factory\UsuarioFactory',
        'Admin\Model\Service\RolService' => 'Admin\Model\Service\Factory\RolFactory',
        'Admin\Model\Service\RecursoService' => 'Admin\Model\Service\Factory\RecursoFactory',
        'Admin\Model\Service\PermisoService' => 'Admin\Model\Service\Factory\PermisoFactory',
        'Admin\Model\Service\DetalleOrdenService' => 'Admin\Model\Service\Factory\DetalleOrdenFactory',
        'Admin\Model\Service\OrdenService' => 'Admin\Model\Service\Factory\OrdenFactory',
        'Admin\Model\Service\PaqueteService' => 'Admin\Model\Service\Factory\PaqueteFactory',


        //forms
        'Admin\Form\LoginForm' => 'Admin\Form\Factory\LoginFactory',
        'Admin\Form\UsuarioForm' => 'Admin\Form\Factory\UsuarioFactory',
        'Admin\Form\MiPerfilForm' => 'Admin\Form\Factory\MiPerfilFactory',
        'Admin\Form\RolForm' => 'Admin\Form\Factory\RolFactory',
        'Admin\Form\RecursoForm' => 'Admin\Form\Factory\RecursoFactory',
        'Admin\Form\PermisoForm' => 'Admin\Form\Factory\PermisoFactory',
        'Admin\Form\DetalleOrdenBuscarForm' => 'Admin\Form\Factory\DetalleOrdenBuscarFactory',
        'Admin\Form\OrdenBuscarForm' => 'Admin\Form\Factory\OrdenBuscarFactory',
        'Admin\Form\PaqueteBuscarForm' => 'Admin\Form\Factory\PaqueteBuscarFactory',
        'Admin\Form\PaqueteForm' => 'Admin\Form\Factory\PaqueteFactory',
        'Admin\Form\ModificarPasswordForm' => 'Admin\Form\Factory\ModificarPasswordFactory',
        'Admin\Form\RecuperarPasswordForm' => 'Admin\Form\Factory\RecuperarPasswordFactory',
    ),
    'invokables' => array(
    ),
);