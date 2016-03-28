<?php

namespace PaymentProcessor\Model\Gateway\Processor\Base;

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
    
    abstract public function createCharge($data);    
}