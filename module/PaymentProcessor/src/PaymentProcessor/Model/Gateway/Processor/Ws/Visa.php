<?php

namespace PaymentProcessor\Model\Gateway\Processor\Ws;

use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Model\ViewModel;

class Visa
{
    protected $client;
    
    protected $wsdl;
    
    protected $environment;

    public function __construct($config, $environment) 
    {
        $this->environment = $environment;      
        
        $this->config = $config;
    }
    
    public function createEticket($data)
    {                          
        $this->wsdl = __DIR__ . '/Visa/Wsdl/WSEticketQAS.wsdl';
        if ($this->environment == 'production') {
            $this->wsdl = __DIR__ . '/Visa/Wsdl/WSEticket.wsdl';
        }
        
        $this->client = new \SoapClient($this->wsdl, array('trace' => 1));
                
        $requestData = $this->getCreateEticketRequestData($data); 
        
        $response = $this->client->GeneraEticket($requestData);
        
        var_dump($response);
    }
    
    public function retrieveTicket($data)
    {
        $this->wsdl = __DIR__ . '/Visa/Wsdl/WSConsultaEticketQAS.wsdl';
        if ($this->environment == 'production') {
            $this->wsdl = __DIR__ . '/Visa/Wsdl/WSConsultaEticket.wsdl';
        }        
        $this->client = new \SoapClient($this->wsdl, array('trace' => 1));
        
        $requestData = $this->getRetrieveEticketRequestData($data);         
        $response = $this->client->ConsultaEticket($requestData);
    }
    
    protected function getCreateEticketRequestData($data)
    {                
        $createEticketRequestData = array(
            'commerceCode' => $this->config['codigoComercio'],
            'id' => $data['id'],
            'amount' => $data['monto'],
            'profileName' => $data['perfilpago_nombres'],
            'profileLastName' => $data['perfilpago_paterno'] . ' ' . $data['perfilpago_materno'],
            'city' => 'LIMA',
            'address' => $data['perfilpago_direccion'],
            'userEmail' => $data['usuario_email'],            
        );
                        
        $createEticketRequestXml = $this->getViewXml('eticket.xml', $createEticketRequestData);
        
        return array('xmlIn' => $createEticketRequestXml);
    }
    
    protected function getRetrieveEticketRequestData($data)
    {
        $retrieveEticketRequestData = array(
            
        );
        
        return $retrieveEticketRequestData;
    }
    
    public function getViewXml($path, $data = array())
    {
        $resolver = new TemplatePathStack(array(
            'script_paths' => array(__DIR__ . '/Visa/Xml/')
        ));                
        
        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        $view = new ViewModel();
        $view->setTemplate($path);
                
        $view->setVariables($data);
        
        return $renderer->render($view);
    }
}