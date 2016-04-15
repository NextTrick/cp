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
        );
        
        return isset($urls[$tipo]) ? $urls[$tipo] : null;
    }
    
    private function getRules($tipo)
    {
        $rules = array(
            self::METHOD_GET_CARD => array(
                'CGUID',
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
            var_dump($curlData);exit;
            if ($curlData['success']) {
                if ($curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['mguid'] = $curlData['data']['data']['mguid'];
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

    public function creditPurchase()
    {
        
    }
}