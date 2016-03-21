<?php

namespace Authentication\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Authentication\Model\Service\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Auth extends AbstractPlugin implements ServiceLocatorAwareInterface
{
    private $_authenticationService;

    public function __construct(AuthenticationService $atenticacionService)
    {
        $this->_authenticationService = $atenticacionService;
    }
    
    /**
     * Returns true if and only if an identity is available from storage
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->_authenticationService->hasIdentity();
    }

    /**
     * Returns the identity from storage or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        return $this->_authenticationService->getIdentity();
    }
        
    /**
     * Get service locator
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface;
     */
    public function getServiceLocator()
    {
        return $this->_sl;
    }
    
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->_sl = $serviceLocator;
    }
    
    /**
     * devuelve el id del Perfil logueado
     * 
     * @return int
     */
    public function getId()
    {
        if ($this->hasIdentity()) {
            return $this->getIdentity()->getId();
        }
        
        return null;
    }
}