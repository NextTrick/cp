<?php
namespace Authentication;
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'factories' => array(
        'auth' => function(ServiceLocatorInterface $sm) {            
            $atenticacionService = $sm->getServiceLocator()->get('Authentication\Model\Service\AuthenticationService');
            $auth = new \Authentication\View\Helper\Auth($atenticacionService);
            
            return $auth;
        },
        'acl' => function(ServiceLocatorInterface $sm) {
            $aclService = $sm->getServiceLocator()->get('Authentication\Model\Service\AclService');  
            
            return new \Authentication\View\Helper\Acl($aclService);
        },
    ),
);
