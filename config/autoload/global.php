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

if (file_exists(__DIR__ . '/production.constants.php')) {
    require_once 'production.constants.php';
} else if (file_exists(__DIR__ . '/local.constants.php')) {
    require_once 'local.constants.php';
} else {
    require_once 'constants.php';
}

return array(
    'php' => array(
        'settings' => array(
            'date.timezone' => 'America/Lima',
            'intl.default_locale' => 'es_PE',
            'display_startup_errors' => false,
            'display_errors' => false,
            'error_reporting' => E_ALL,
            'post_max_size' => '804857600',            
        )
    ),
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'cookieName',
                'cookie_httponly' => true,
                'cookie_lifetime' => 60*60*24,
                'gc_maxlifetime' => 60*60*24,
                'remember_me_seconds' => 60*60*24,
            ),
            //'authentication_expiration_time' => 300
        ),
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
    ),
    'error' => array(
        'send_mail' => true,
        'local_log' => true,        
    ),
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
            'ttl' => 60*60*24
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
            'ttl' => 60*60*24
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
    'mail' => array(
        'transport' => array(
            'options' => array(
                'host' => '204.232.198.40',
                'port' => 25,
            ),
        ),
        'fromEmail' => 'contacto@coneypark.com',
        'fromName' => 'ConeyPark',
        'subject' => 'ConeyPark'
    ),
    //Emails
    'emails' => array(
        'admin' => 'ing.angeljara@gmail.com', // email del administrador
        'developers' => 'ing.angeljara@gmail.com, montesinos2005ii@gmail.com', // emails de los dev
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
            'app_id' => '1530224070617551',//dev
            'api_secret' => 'cc1d0233bf7c4f56d13fa2ea5a516192',
            'default_scope' => 'email,user_friends,user_location',
            'redirect_callback' => BASE_URL . 'login/callback/facebook',
        ),
        'twitter' => array(
            'oauth_access_token' => '382920909-7o6d7IzogwJTc8PtKDMpC8oUm5TaXXEA50NHDm62',
            'oauth_access_token_secret' => '4VfBvFULklW59WTPsJa5gS0zrPCILltVHcxJFcdEC9ovi',
            'consumer_key' => 'K0IyDQeeAd8Lv4opyH4FmOnK7',
            'consumer_secret' => 'BRaBpn5TfW7nl0cskHT6fDkD59GqJKoCSXIHr3Tr3yfLDdaD4t',
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
                'securityPath' => APP_PATH . '/data/private/dev/', //PE's key path
                'publickey' => 'SPE_PublicKey.1pz', //PE's public key
                'privatekey' => 'ACI_PrivateKey.1pz', // PE's secret key                
                'medioPago' => '1,2',
                'adminEmail' => 'ing.angeljara@gmail.com', // PE's secret key

                'conceptoPago' => 'ConeyPark',
                'cipExpiracionDias' => 1
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
