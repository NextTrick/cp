<?php

return array(
    'factories' => array(
        //services
        'Usuario\Model\Service\UsuarioService' => 'Usuario\Model\Service\Factory\UsuarioFactory',
        'Usuario\Model\Service\OauthFacebookService' => 'Usuario\Model\Service\Factory\OauthFacebookFactory',
        'Usuario\Model\Service\OauthTwitterService' => 'Usuario\Model\Service\Factory\OauthTwitterFactory',
        
        //forms
        'Usuario\Form\UsuarioForm' => 'Usuario\Form\Factory\UsuarioFactory',
    ),
    'invokables' => array(
    ),
);