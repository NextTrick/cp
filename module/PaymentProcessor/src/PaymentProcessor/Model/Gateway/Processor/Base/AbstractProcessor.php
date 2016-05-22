<?php

namespace PaymentProcessor\Model\Gateway\Processor\Base;

use Zend\Http\Client;
use Orden\Model\Service\RequestHistorialService;
use Orden\Model\Service\OrdenService;

abstract class AbstractProcessor
{        
    public $ws;
    
    public $sl;

    const METHOD_CREATECHARGE = 'createCharge';

    const METHOD_PROCESSCALLBACK = 'processCallback';

    public $wsConfig;
    
    public function __construct($serviceLocator)
    {
        $this->sl = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->sl;
    }
    
    public function saveResquestHistorial($data)
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

        if (empty($data['ordenId'])) {
            if (!empty($data['reference'])) {
                $dataDb = $this->getOrderService()->getRepository()
                    ->getIdByPagoReference($data['reference']);

                if (!empty($dataDb)) {
                    $data['ordenId'] = $dataDb['id'];
                }
            }
        }

        if (!empty($data['ordenId'])) {
            $requestData = array(
                'request' => !empty ($request) ? serialize($request) : null,
                'response' => !empty ($response) ? serialize($response) : null,
                'orden_id' => $data['ordenId'],
                'method' => $data['method'],
                'pago_referencia' => !empty ($data['reference']) ? $data['reference'] : null,
            );

            $this->getRequestHistorialService()->getRepository()->save($requestData);
        }
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

    /**
     * @return OrdenService
     */
    public function getOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\OrdenService');
    }
    
    abstract public function createCharge($data);

    abstract public function processCallback($params);
}