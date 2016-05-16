<?php

namespace PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo;

use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo\Crypto;

abstract class Service
{
    protected $_options = array(
        'url2' => '',
        'url3' => '',
        'url4' => '',
    );

    protected static $_instance;

    public $client;

    public function __construct($config = null)
    {
        if (isset($config)) {
            $this->_options = array_merge($this->_options, $config);
        }
    }
    /*
     * Ejecutar el servicio
     */
    public function _loadService($service, $data)
    {
        switch ($service) {
            case 'GenerarCIPMod1': $url = $this->_options['url2'];
                break;
            case 'ActDataAdicional': $url = $this->_options['url4'];
                break;
            case 'ConsultarSolicitudPagov2': $url = $this->_options['url2'];
                break;
            case 'ActualizarCIPMod1': $url = $this->_options['url2'];
                break;
            case 'ConsultarCIPMod1': $url = $this->_options['url2'];
                break;
            case 'EliminarCIPMod1': $url = $this->_options['url2'];
                break;
            case 'BlackBox': $url = $this->_options['url3'];
                break;
            default : $url = $this->_options['url'];
                break;
        }

        try {
            $this->client = new \SoapClient($url, array('ssl' => array('peer_verify' => false,
                'verify_peer_name' => false, 'allow_self_signed' => false), 'cache_wsdl' => WSDL_CACHE_NONE));
            //var_dump($data); echo '<br><br>';
            $info = $this->client->$service($data);
            return $info;
        } catch (\Exception $e) {
            var_dump($e->getMessage(), $e->getTraceAsString()); exit;
            echo $e->getMessage();
            return false;
        }
    }

    /*
     * Extraer una instancia de la aplicación
     * @param string $securityPath Carpeta donde se almacenan public.key y private.key
     * @return PagoEfectivo retorna la instancia de la clase
     */
    final public static function getInstance($options = null)
    {
        $class = self::getClass();
        if (!isset(self::$_instance[$class])) {
            self::$_instance[$class] = new $class($options);
        }

        return self::$_instance[$class];
    }

    /*
     * Captura el nombre de la clase
     */
    final public static function getClass()
    {
        if (function_exists('get_called_class')) {
            return get_called_class();
        }

        return Crypto;
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function getClient()
    {
        return $this->client;
    }
}