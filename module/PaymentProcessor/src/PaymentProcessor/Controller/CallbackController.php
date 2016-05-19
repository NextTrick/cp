<?php

namespace PaymentProcessor\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor;
use PaymentProcessor\Model\Gateway\Processor\VisaProcessor;
use PaymentProcessor\Model\PaymentProcessor;
use Zend\View\Model\ViewModel;

class CallbackController extends AbstractActionController
{
    public function pagoEfectivoAction()
    {
        $params = $this->getRequest()->getPost();        
        $paymentProcessor = new PaymentProcessor(PagoEfectivoProcessor::ALIAS,
                $this->getServiceLocator());        
        $response = $paymentProcessor->processCallback($params);

        var_dump($response);
        
        exit;
    }
    
    public function visaAction()
    {
        $params = $this->getRequest()->getPost();        
        $paymentProcessor = new PaymentProcessor(VisaProcessor::ALIAS,
                $this->getServiceLocator());
        $response = $paymentProcessor->processCallback($params);

        var_dump($response);

        exit;
    }

    public function visaRedirectAction()
    {
        $eticket = $this->params()->fromRoute('eticket');
        $config = $this->getServiceLocator()->get('config');
        $visaConfig = $config['app']['paymentProcessor']['visa'];
        $action = $visaConfig['baseUrl'] . $visaConfig['formularioPago'];

        $view = new ViewModel();
        $view->setTerminal(true);
        $view->eticket = base64_decode($eticket);
        $view->action = $action;

        return $view;
    }

}