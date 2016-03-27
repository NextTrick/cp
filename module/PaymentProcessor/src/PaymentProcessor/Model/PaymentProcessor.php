<?php

namespace PaymentProcessor\Model;

use PaymentProcessor\Model\Gateway\PaymentProcessorGateway;

class PaymentProcessor
{    
    protected $_sl;
    
    public $processor;

    public function __construct($alias, $serviceLocator)
    {        
        $this->_sl = $serviceLocator;
        
        $this->processor = PaymentProcessorGateway::getProcessor($alias, $serviceLocator);
    }
    
    public function createCharge($data)
    {
        $this->processor->createCharge($data);
    }        
}