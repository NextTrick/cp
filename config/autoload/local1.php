<?php
define('BASE_URL', 'http://cpark.cuadraticas.com/');
define('URL_RESOURCES', 'http://cpark.cuadraticas.com/');

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
        'database' => 'cuadrati_cp',
        'username' => 'cuadrati_cp',
        'password' => '#Q@Tast395QlaT',
        'port' => '3306',        
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        )
    ),
    'fileDir' => array(
        'usuario_usuario' => array(
            'up' => APP_PATH . '/public/files/usuario/usuario',
            'down' => 'http://cpark.cuadraticas.com/files/usuario/usuario',
        ),
    ),
    'social' => array(
        'facebook' => array(
            'app_id' => '1676429382610359',
            'api_secret' => 'c29480e4a45c99ce0040cb4b0801d6ee',
            'default_scope' => 'email,user_friends,user_location',
            'redirect_callback' => 'http://cpark.cuadraticas.com/login/facebook-callback',
        ),
        'twitter' => array(
            'oauth_access_token' => '382920909-LlMRIJWODxQeJ4Vjjs8yyAx1jicchiCmgsMPGORv',
            'oauth_access_token_secret' => 'rxwSlVetaMxVCPloZTAaHq50eWk55S3KOfP9p7R63XorS',
            'consumer_key' => 'ZBoXFfyPjtc9PJaCsbQp4E0ZC',
            'consumer_secret' => ' UHF9hSIoXZW708OXKCIn9lIwTdS8kBlaZeGAuTfseolktJ2UTG',
            'redirect_callback' => 'http://cpark.cuadraticas.com/login/twitter-callback',
        ),
    )
);