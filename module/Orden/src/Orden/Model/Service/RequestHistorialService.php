<?php

namespace Orden\Model\Service;

class RequestHistorialService
{
    protected $_repository = null;
    
    protected $_sl = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        
        $this->_sl = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}