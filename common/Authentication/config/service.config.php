<?php
namespace Authentication;

return array(
    'factories' => array(                        
        'Authentication\Model\Service\ConsumerService' => 'Authentication\Model\Service\Factory\ConsumerFactory',                
        'Authentication\Model\Service\TwitterService' => 'Authentication\Model\Service\Factory\TwitterFactory',
        'Authentication\Model\Service\FacebookService' => 'Authentication\Model\Service\Factory\FacebookFactory',
        'Authentication\Model\Service\GoogleService' => 'Authentication\Model\Service\Factory\GoogleFactory',
        'Authentication\Model\Service\AuthenticationService' => 'Authentication\Model\Service\Factory\AuthenticationFactory',
        'Authentication\Model\Service\AclService' => 'Authentication\Model\Service\Factory\AclFactory',
     ),
    'invokables' => array(
    ),
);