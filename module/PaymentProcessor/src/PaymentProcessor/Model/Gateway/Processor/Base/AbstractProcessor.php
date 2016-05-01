<?php

namespace PaymentProcessor\Model\Gateway\Processor\Base;

use Zend\Http\Client;
use Orden\Model\Service\RequestHistorialService;

abstract class AbstractProcessor
{        
    public $ws;
    
    public $sl;
    
    public function __construct($serviceLocator)
    {
        $this->sl = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->sl;
    }
    
    public function saveResquestHistorial($searchId)
    {
        $client = $this->ws->getClient();
        $request = '';
        $response = null;        
        
        if ($client instanceof \SoapClient) {
            $request = $client->__getLastRequest();
            $response = $client->__getLastResponse();
        } else if ($client instanceof Client) {
            $request = $client->getLastRawRequest();
            $response = $client->getLastRawResponse();
        }
        
        $requestData = array(
            'request' => !empty ($request) ? serialize($request) : null,
            'response' => !empty ($response) ? serialize($response) : null,
            'orderId' => $searchId,            
        );
        
        $this->getRequestHistorialService()->getRepository()->save($requestData);        
    }
    
    public function getViewXml($path, $data = array())
    {
        $resolver = new TemplatePathStack(array(
            'script_paths' => array(__DIR__ . '/../Ws/')
        ));
        
        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        $view = new ViewModel();
        $view->setTemplate($path);
        $view->setVariables($data);
        
        return $renderer->render($view);
    }
    
    /**     
     * @return RequestHistorialService
     */
    public function getRequestHistorialService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\RequestHistorialService');
    }
    
    abstract public function createCharge($data);    
}