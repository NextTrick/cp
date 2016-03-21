<?php

namespace Authentication\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Authentication\Model\Service\AclService;

class Acl extends AbstractHelper
{
    private $_aclService; 
    
    public function __construct(AclService $service) 
    {
        $this->_aclService = $service;
    }
    
    public function isAllowed($rol, $resource)
    {
        $this->_aclService->setRol($rol);
        $this->_aclService->setResource($resource);
        return $this->_aclService->validate();        
    }    
}
