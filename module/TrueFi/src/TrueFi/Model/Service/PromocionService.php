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

class PromocionService
{
    const METHOD_GET_PROMOTIONS = 'GetPromotions';


    protected $_sl = null;
    protected $_config = null;

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
            self::METHOD_GET_PROMOTIONS => $this->_config->url . self::METHOD_GET_PROMOTIONS . '.php',
        );
        
        return isset($urls[$tipo]) ? $urls[$tipo] : null;
    }
    
    private function getRules($tipo)
    {
        $rules = array(
            self::METHOD_GET_PROMOTIONS => array(
            ),
        );
        
        return isset($rules[$tipo]) ? $rules[$tipo] : array();
    }

    public function getPromotions()
    {
        $result = Request::validate(array(), $this->getRules(self::METHOD_GET_PROMOTIONS));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_GET_PROMOTIONS);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
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
}