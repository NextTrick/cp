<?php
namespace Authentication;
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'factories' => array(
        'Auth' => function(ServiceLocatorInterface $sm) {
           $atenticacionService = $sm->getServiceLocator()->get('Authentication\Model\Service\AuthenticationService');
           return new \Authentication\Controller\Plugin\Auth($atenticacionService);
        },
    ),
);