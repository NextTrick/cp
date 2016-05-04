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
    'mail' => array(
        'transport' => array(
            'options' => array(
                'host' => '204.232.198.40',
                'port' => 587,
                'connection_class'  => 'login',
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
    //Application config params 
    'app' => array(
        'environment' => 'development',
        
        'paymentProcessor' => array(
            'pagoEfectivo' => array(
                'merchanId' => 'HOK',
                'baseUrl' => 'http://pre.2b.pagoefectivo.pe/',
                'wscrypta' => 'PagoEfectivoWSCrypto/WSCrypto.asmx?WSDL', //data encrypt ws
                'wscip2' => 'PagoEfectivoWSGeneralv2/service.asmx?WSDL', //cip generator ws 
                'wsgenpago' => 'GenPago.aspx', //PE's CIP window
                'wsgenpagoiframe' => 'GenPagoIF.aspx', //
                'securityPath' => APP_PATH . '/data/private/', //PE's key path
                'publickey' => 'SPE_PublicKey.1pz', //PE's public key
                'privatekey' => 'ACI_PrivateKey.1pz', // PE's secret key                
                'medioPago' => '1,2',
                'adminEmail' => 'ing.angeljara@gmail.com', // PE's secret key           
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
);
