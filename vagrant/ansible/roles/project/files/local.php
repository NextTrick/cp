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
    'db' => array(
        'driver' => 'pdo_mysql',
        'hostname' => 'localhost',
        'database' => 'projectuser',
        'username' => 'projectpass',
        'password' => '',
        'port' => '3306',        
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        )
    ),    
);