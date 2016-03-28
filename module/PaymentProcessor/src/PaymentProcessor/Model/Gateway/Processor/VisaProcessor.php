<?php

namespace PaymentProcessor\Model\Gateway\Processor;

class VisaProcessor
{
    const ALIAS = 'VISA';
    
    public $ws;
    
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['visa'];
        
        $this->ws = new Visa($wsConfig);
    }
    
    public function createPayment($data) 
    {
        
    }
}