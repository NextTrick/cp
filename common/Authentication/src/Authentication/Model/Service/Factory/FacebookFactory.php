<?php

namespace Authentication\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\FactoryInterface;
use Authentication\Model\Service\FacebookService;

class FacebookFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {       
        $config = $serviceLocator->get('config');
        $facebookConfig = $config['authentication']['facebook'];
        
        $params = array(
            'appId' => $facebookConfig['appId'],
            'secret' => $facebookConfig['secret'],
//            'fileUpload' => $facebookConfig['fileUpload'], // optional
//            'allowSignedRequest' => $facebookConfig['allowSignedRequest'], // optional, but should be set to false for non-canvas apps
        );
                       
        return new FacebookService($params);
    }
}