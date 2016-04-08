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
            'error_reporting' => 0,
            'post_max_size' => '804857600',            
        )
    ),
    
    'error' => array(
        'send_mail' => false,
        'local_log' => true,        
    ),
            
    'view_manager' => array(
        'base_path' => "http://dev.recargas.coneypark.pe/",
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
    'fileDir' => array(
        'usuario_usuario' => array(
            'up' => APP_PATH . '/public/files/usuario/usuario',
            'down' => 'http://dev.recargas.coneypark.pe/files/usuario/usuario',
        ),
    ),
    'mails' => array(
        'confirmOrder' => array(
            'fromEmail' => 'test@gmail.com',
            'fromName' => 'Coneypark',
            'toEmail' => 'admin@gmail.com',
            'subject' => 'Pedido',
            'options' => array(
                'name' => 'smtp.gmail.com',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class'  => 'login',
                'connection_config' => array(
                    'username' => 'stmpadmin@gmail.com',
                    'password' => '',
                    'ssl' => 'tls',
                ),
            )
        ),
    ),
    //Application config params 
    'app' => array(
        'environment' => 'development',
        
        'paymentProcessor' => array(
            'pagoEfectivo' => array(
                'merchanId' => 'HOK',
                'baseUrl' => 'http://pre.pagoefectivo.pe/',
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
