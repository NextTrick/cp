<?php

namespace PaymentProcessor\Model\Gateway\Processor\Ws;

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
        
        $view = new ViewModel();
        $view->setTerminal(true)                
                ->setTemplate('Xml/eticked.xml')
                ->setVariables(array(
                    'userData' => $userData,
                    'token' => $token,                        
                ));
        
        $viewRenderer = $this->_sl->get('viewrenderer');      
        $html = $viewRenderer->render($view);
        
        return array('xmlIn' => $createEticketRequestXml);
    }
    
    protected function getRetrieveEticketRequestData($data)
    {
        $retrieveEticketRequestData = array(
            
        );
        
        return $retrieveEticketRequestData;
    }
}