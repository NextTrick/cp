<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\Visa;

class VisaProcessor extends AbstractProcessor
{
    const ALIAS = 'VISA';
    
    public $ws;
    
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['visa'];
        
        $environment = $config['app']['environment'];
        
        $this->ws = new Visa($wsConfig, $environment);
    }
    
    public function createCharge($data) 
    {        
        $return = array(
            'success' => true,            
        );
           
        try {                                              
            $paymentResponse = $this->ws->createEticket($data);     
            
            var_dump($paymentResponse); exit; 
            
            $return['data'] = array(
                'status' => $paymentResponse->Estado,
                'token' => $paymentResponse->Token,
                'clientReference' => $paymentResponse->NumeroOrdenPago,
                'reference' => $paymentResponse->CodTrans,
            );
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['error']['message'] = $e->getMessage();
            $return['error']['detail'] = $e->getTraceAsString();
        }
                
        return $return;
    }
}