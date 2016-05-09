<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace TrueFi\Model\Service;

use TrueFi\Model\Service\Response;
use TrueFi\Model\Service\Request;

class TarjetaService
{
    protected $_sl = null;
    protected $_config = null;
    
    const METHOD_GET_CARD = 'GetCard';
    const METHOD_ADD_CARD = 'AddCard';
    const METHOD_CREDIT_PURCHESE = 'CreditPurchase';
    const METHOD_DENOUNCE_CARD = 'DenounceCard';
    const METHOD_REMOVE_CARD = 'RemoveCard';

    public function __construct($serviceLocator)
    {
        $this->_sl = $serviceLocator;
        $this->_setCofig();
    }
    
    private function _setCofig()
    {
        $config = $this->_sl->get('config');
        $this->_config = (object)$config['api']['true_fi'];
    }
    
    private function getUrl($tipo)
    {
        $urls = array(
            self::METHOD_GET_CARD => $this->_config->url . self::METHOD_GET_CARD . '.php',
            self::METHOD_ADD_CARD => $this->_config->url . self::METHOD_ADD_CARD . '.php',
            self::METHOD_CREDIT_PURCHESE => $this->_config->url . self::METHOD_CREDIT_PURCHESE . '.php',
            self::METHOD_DENOUNCE_CARD => $this->_config->url . self::METHOD_DENOUNCE_CARD . '.php',
            self::METHOD_REMOVE_CARD => $this->_config->url . self::METHOD_REMOVE_CARD . '.php',
        );
        
        return isset($urls[$tipo]) ? $urls[$tipo] : null;
    }
    
    private function getRules($tipo)
    {
        $rules = array(
            self::METHOD_GET_CARD => array(
                'CGUID',
            ),
            self::METHOD_ADD_CARD => array(
                'MGUID',
                'Card',
            ),
            self::METHOD_CREDIT_PURCHESE => array(
                'CGUID',
                'EMoney',
            ),
            self::METHOD_DENOUNCE_CARD => array(
                'CGUID',
            ),
            self::METHOD_REMOVE_CARD => array(
                'Card',
            ),
        );
        
        return isset($rules[$tipo]) ? $rules[$tipo] : array();
    }

    public function getCard($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_GET_CARD));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_GET_CARD);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if ($curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['result'] = $curlData['data']['data'];
                } else {
                    $result['success'] = false;
                    $result['message'] = $curlData['data']['message'];
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function addCard($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_ADD_CARD));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_ADD_CARD);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if ($curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['result'] = $curlData['data']['data'];
                } else {
                    $result['success'] = false;
                    $result['message'] = $curlData['data']['message'];
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }

    public function creditPurchase($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_CREDIT_PURCHESE));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_CREDIT_PURCHESE);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if ($curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['result'] = $curlData['data']['data'];
                } else {
                    $result['success'] = false;
                    $result['message'] = $curlData['data']['message'];
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function denounceCard($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_DENOUNCE_CARD));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_DENOUNCE_CARD);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if ($curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = $curlData['data']['message'];
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    /*
     *No funciona aun, ultima prueba 2016-05-01
     */
    public function removeCard($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_REMOVE_CARD));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_REMOVE_CARD);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                var_dump($curlData);exit;
                if ($curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = $curlData['data']['message'];
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
}