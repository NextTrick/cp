<?php
namespace Authentication;

return array(
    'invokables' => array(
        'Authentication\Controller\Twitter' => 'Authentication\Controller\TwitterController',
        'Authentication\Controller\Facebook' => 'Authentication\Controller\FacebookController',
        'Authentication\Controller\Google' => 'Authentication\Controller\GoogleController',        
        'Authentication\Controller\Access' => 'Authentication\Controller\AccessController', 
    ),
);