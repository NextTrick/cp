<?php

namespace Authentication\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\FactoryInterface;
use Authentication\Model\Service\TwitterService;

class TwitterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {       
        $config = $serviceLocator->get('config');
        $twitterConfig = $config['auth']['twitter'];

        $params = array(
            'access_token' => array(
                'token'  => $twitterConfig['access_token'],
                'secret' => $twitterConfig['access_token_secret']),
            'oauth_options' => array(
                'consumerKey' => $twitterConfig['consumerKey'],
                'consumerSecret' => $twitterConfig['consumerSecret']),
            'http_client_options' => array(
                'adapter' => 'Zend\Http\Client\Adapter\Curl', //'Zend\Http\Client\Adapter\Socket'
                'curloptions' => array(
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                ),
            ),
        );
                                
        return new TwitterService($params);
    }
}