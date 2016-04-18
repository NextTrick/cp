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
    
    public function getViewXml($path, $data = array())
    {
        $resolver = new TemplatePathStack(array(
            'script_paths' => array(__DIR__ . '/../Ws/')
        ));
        
        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        $view = new ViewModel();
        $view->setTemplate($path);
        $view->setVariables($data);
        
        return $renderer->render($view);
    }
    
    abstract public function createCharge($data);    
}