<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

require_once 'constants.php';

return array(
    'php' => array(
        'settings' => array(
            'date.timezone' => 'America/Lima',
            'intl.default_locale' => 'es_PE',
            'display_startup_errors' => false,
            'display_errors' => true,
            'error_reporting' => E_ALL,
            'post_max_size' => '804857600',            
        )
    ),
    'error' => array(
        'send_mail' => true,
        'local_log' => true,        
    ),
    /*'db' => array(
        'driver' => 'pdo_mysql',
        'hostname' => 'localhost',
        'database' => 'coneypark',
        'username' => 'root',
        'password' => '',
        'port' => '3306',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        )
    ),*/
    'db' => array(
        'driver' => 'pdo_mysql',
        'hostname' => 'localhost',
        'database' => 'pasarelaconeydev',
        'username' => 'idigital',
        'password' => '1D1g1t4L',
        'port' => '3306',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        )
    ),
    'cacheCart' => array(
        'adapter' => 'filesystem',
        'options' => array(
            'cache_dir' => './data/cache',
            'dirPermission' => 0755,
            'filePermission' => 0666,
            'namespaceSeparator' => '-cart-',
            'ttl' => 3600
        ),
        'plugins' => array(
            'exception_handler' => array('throw_exceptions' => false),
            'serializer'
        )
    ),
    'cacheDb' => array(
        'adapter' => 'filesystem',
        'options' => array(
            'cache_dir' => './data/cache',
            'dirPermission' => 0755,
            'filePermission' => 0666,
            'namespaceSeparator' => '-db-',
            'ttl' => 3600
        ),
        'plugins' => array(
            'exception_handler' => array('throw_exceptions' => false),
            'serializer'
        )
    ),

    'view_manager' => array(
        'base_path' => BASE_URL,
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'charset' => 'UTF-8',
        'doctype' => 'HTML5',
        'title' => 'Videl',
        'strategies' => array(
           'ViewJsonStrategy',
        ),
    ),
//    'mail' => array(
//        'transport' => array(
//            'options' => array(
//                'host' => '204.232.198.40',
//                'port' => 587,
//                'connection_class'  => 'login',
//                'connection_config' => array(
//                    'username' => 'AKIAJSU2S4UPKXV4LUTA',
//                    'password' => 'Aq/U/Mx/COu9VZpqAPASSkhjG958LHnBP9NeIujEF/qN',
//                    'ssl' => 'tls',
//                ),
//            ),
//        ),
//        'fromEmail' => 'contacto@coneypark.com',
//        'fromName' => 'ConeyPark',
//        'subject' => 'ConeyPark'
//    ),

    'mail' => array(
        'transport' => array(
            'options' => array(
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class'  => 'login',
                'connection_config' => array(
                    'username' => 'autopasioncompany@gmail.com',
                    'password' => 'Cistensure2',
                    'ssl' => 'tls',
                ),
            ),
        ),
        'fromEmail' => 'contacto@coneypark.com',
        'fromName' => 'ConeyPark',
        'subject' => 'ConeyPark'
    ), 
         
    //Emails
    'emails' => array(
        'admin' => 'ing.angeljara@gmail.com', // email del administrador
        'developers' => 'ing.angeljara@gmail.com', // emails de los dev
        'from' => 'contacto@coneypark.pe',
    ), 
    
    'api' => array(
        'true_fi' => array(
            'url' => 'http://65.52.221.92:8088/ITFIMemberServices/',
            'password' => 'Admin123.',
        ),
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

    //Application config params 
    'app' => array(
        'environment' => 'development',
        
        'paymentProcessor' => array(
            'pagoEfectivo' => array(
                
                'merchanId' => 'ACI',
                //'merchanId' => 'HOK',                
                'baseUrl' => 'https://pre.2b.pagoefectivo.pe/',
                'wscrypta' => 'PagoEfectivoWSCrypto/WSCrypto.asmx?WSDL', //data encrypt ws
                'wscip2' => 'PagoEfectivoWSGeneralv2/service.asmx?WSDL', //cip generator ws 
                'wsgenpago' => 'GenPago.aspx', //PE's CIP window
                'wsgenpagoiframe' => 'GenPagoIF.aspx', //
                'securityPath' => APP_PATH . '/data/private/', //PE's key path
                'publickey' => 'SPE_PublicKey.1pz', //PE's public key
                'privatekey' => 'ACI_PrivateKey.1pz', // PE's secret key                
                'medioPago' => '1,2',
                'adminEmail' => 'ing.angeljara@gmail.com', // PE's secret key

                'conceptoPago' => 'Recarga de Tarjeta ConeyPark',
                'cipExpiracionDias' => 3
            ),
            'visa' => array(                
                'baseUrl' => 'http://qas.multimerchantvisanet.com/',
                'wsEticket' => 'WSGenerarEticket/WSEticket.asmx?wsdl',                
                'formularioPago' => 'formularioweb/formulariopago.asp',
                'wsConsultaTicket' => 'WSConsulta/WSConsultaEticket.asmx?wsdl',
                'codigoComercio' => '490345336',
            ),
        ),
    ),
    'cart' => array(
        'amount_decimal_length' => 2,
        'amount_decimal_separator' => '.',
        'amount_thousands_separator' => ',',
        'quantity_max_by_product' => 5,
        'currency' => 'NS',
    )
);
