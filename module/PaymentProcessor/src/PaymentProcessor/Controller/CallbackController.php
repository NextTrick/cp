<?php

namespace PaymentProcessor\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor;
use PaymentProcessor\Model\Gateway\Processor\VisaProcessor;
use PaymentProcessor\Model\PaymentProcessor;

class CallbackController extends AbstractActionController
{
    public function PagoEfectivoAction()
    {
        $params = $this->getRequest()->getPost();        
        $paymentProcessor = new PaymentProcessor(PagoEfectivoProcessor::ALIAS,
                $this->getServiceLocator());        
        $response = $paymentProcessor->processCallback($params);

        var_dump($response);
        
        exit;
    }
    
    public function VisaAction()
    {
        $params = $this->getRequest()->getPost();        
        $paymentProcessor = new PaymentProcessor(VisaProcessor::ALIAS,
                $this->getServiceLocator());
        $response = $paymentProcessor->processCallback($params);

        var_dump($response);

        exit;
    }
}