<?php

namespace PaymentProcessor\Model\Gateway;

use PaymentProcessor\Model\Gateway\Processor\VisaProcessor;
use PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor;

class PaymentProcessorGateway
{   
    public static function getProcessor($alias, $serviceLocator)
    {
        $processor = null;        
        switch ($alias) {
            case VisaProcessor::ALIAS: 
                $processor = new VisaProcessor($serviceLocator);
                break;
            case PagoEfectivoProcessor::ALIAS: 
                $processor = new PagoEfectivoProcessor($serviceLocator);
                break;            
            default :                 
                break;
        }
        
        return $processor;
    }
}