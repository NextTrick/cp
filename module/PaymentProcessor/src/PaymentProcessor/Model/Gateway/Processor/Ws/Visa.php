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
    }
    
    public function createEticket($data)
    {                  
        $this->wsdl = __DIR__ . '/Visa/Wsdl/WSEticketQAS.wsdl';
        if ($this->environment == 'production') {
            $this->wsdl = __DIR__ . '/Visa/Wsdl/WSEticket.wsdl';
        } 
        $this->client = new \SoapClient($this->wsdl, array('trace' => 1));
        
        $requestData = getCreateEticketRequestData($data);                        
        $response = $this->client->GeneraEticket($requestData);
    }
    
    public function retrieveTicket($data)
    {
        $this->wsdl = __DIR__ . '/Visa/Wsdl/WSConsultaEticketQAS.wsdl';
        if ($this->environment == 'production') {
            $this->wsdl = __DIR__ . '/Visa/Wsdl/WSConsultaEticket.wsdl';
        }        
        $this->client = new \SoapClient($this->wsdl, array('trace' => 1));
        
        $requestData = getRetrieveEticketRequestData($data);         
        $response = $this->client->ConsultaEticket($requestData);
    }
    
    protected function getCreateEticketRequestData($data)
    {
        $createEticketRequestData = array(
            
        );
        
        return $createEticketRequestData;
    }
    
    protected function getRetrieveEticketRequestData($data)
    {
        $retrieveEticketRequestData = array(
            
        );
        
        return $retrieveEticketRequestData;
    }
}