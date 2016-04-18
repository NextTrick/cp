<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PaymentProcessor\Model\PaymentProcessor;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        return $view;
    }
    
    public function testPeAction()
    {
        $data = array(
            'id' => 1,
            'perfilpago_nombres' => 'Angel',
            'perfilpago_paterno' => 'Jara',
            'perfilpago_materno' => 'Vilca',
            'perfilpago_nombres' => 'NextTrick',
            'comprobante_tipo' => 'DNI',
            'comprobante_numero' => '11872911',
            'usuario_email' => 'ing.angeljara@gmail.com',
            'monto' => 20.00
        );
                        
        try {
            $alias = \PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor::ALIAS;        
            $paymentProcessor = new PaymentProcessor($alias, $this->getServiceLocator());

            $paymentProcessor->createCharge($data);
        } catch (\Exception $e) {
            var_dump($e->getMessage(), $e->getTraceAsString()); exit;
        }
        
        echo 'fin'; exit;
        
        exit;
    }
    
    public function testVisaAction()
    {                                
        $data = array(
            'id' => 10,
            'perfilpago_nombres' => 'Angel',
            'perfilpago_paterno' => 'Jara',
            'perfilpago_materno' => 'Vilca',
            'perfilpago_nombres' => 'NextTrick',
            'perfilpago_direccion' => 'Av. Carcamo',
            'comprobante_tipo' => 'DNI',
            'comprobante_numero' => '11872911',
            'usuario_email' => 'ing.angeljara@gmail.com',
            'monto' => '20.00'
        );
        
        
        $alias = \PaymentProcessor\Model\Gateway\Processor\VisaProcessor::ALIAS;        
        $paymentProcessor = new PaymentProcessor($alias, $this->getServiceLocator());
        
        $paymentProcessor->createCharge($data);
        
        exit;
    }
    
    public function phpinfoAction()
    {
        echo phpinfo(); exit;
    }
}
