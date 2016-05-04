<?php
define('BASE_URL', 'http://dev.recargas.coneypark.pe/');
define('URL_RESOURCES', 'http://dev.recargas.coneypark.pe/s/');

return array(
    'php' => array(
        'settings' => array(
            'date.timezone' => 'America/Lima',
            'intl.default_locale' => 'es_PE',
            'display_startup_errors' => true,
            'display_errors' => true,
            'error_reporting' => E_ALL,
            'post_max_size' => '804857600',            
        )
    ),
    'error' => array(
        'send_mail' => true,
        'local_log' => true,        
    ),
    'view_manager' => array(
        'base_path' => BASE_URL,
        //'display_not_found_reason' => false,
        //'display_exceptions' => false,
        'charset' => 'UTF-8',
        'doctype' => 'HTML5',
        'title' => 'Recargas Coney Park',
        'strategies' => array(
           'ViewJsonStrategy',
        ),
    ),
    'db' => array(
        'driver' => 'pdo_mysql',
        'hostname' => 'localhost',
        'database' => 'coneypark',
        'username' => 'root',
        'password' => '',
        'port' => '3306',        
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        )
    ),
    'fileDir' => array(
        'usuario_usuario' => array(
            'up' => APP_PATH . '/public/s/files/usuario/usuario',
            'down' => URL_RESOURCES . 'files/usuario/usuario',
        ),
        'paquete_paquete' => array(
            'up' => APP_PATH . '/public/s/files/paquete/paquete',
            'down' => URL_RESOURCES . 'files/paquete/paquete',
        ),
    ),
    'social' => array(
        'facebook' => array(
            'app_id' => '1676429382610359',
            'api_secret' => 'c29480e4a45c99ce0040cb4b0801d6ee',
            'default_scope' => 'email,user_friends,user_location',
            'redirect_callback' => BASE_URL . 'login/callback/facebook',
        ),
        'twitter' => array(
            'oauth_access_token' => '382920909-7o6d7IzogwJTc8PtKDMpC8oUm5TaXXEA50NHDm62',
            'oauth_access_token_secret' => '4VfBvFULklW59WTPsJa5gS0zrPCILltVHcxJFcdEC9ovi',
            'consumer_key' => 'KAkyvbsAq5GvegoIuhdMLuBo0',
            'consumer_secret' => 'FC9HkFAi8B0yY4wn2NxObQDqRJcx0BcD6vtYNVlWxT0JDh71J4',
            'redirect_callback' => BASE_URL . 'login/callback/twitter',
        ),
    ),
    'api' => array(
        'true_fi' => array(
            'url' => 'http://65.52.221.92:8088/ITFIMemberServices/',
            'password' => 'Admin123.',
        ),
    ),
    'mail' => array(
        'transport' => array(
            'options' => array(
                'host' => '204.232.198.40',
                'port' => 587,
//                'connection_class'  => 'login',
//                'connection_config' => array(
//                    'username' => 'AKIAJSU2S4UPKXV4LUTA',
//                    'password' => 'Aq/U/Mx/COu9VZpqAPASSkhjG958LHnBP9NeIujEF/qN',
//                    'ssl' => 'tls',
//                ),
            ),
        ),
        'fromEmail' => 'contacto@coneypark.co',
        'fromName' => 'ConeyPark',
        'subject' => 'ConeyPark'
    ),
);
