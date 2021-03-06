<?php

return array(
    'factories' => array(
        //services
        'Usuario\Model\Service\LoginGatewayService' => 'Usuario\Model\Service\Factory\LoginGatewayFactory',
        'Usuario\Model\Service\OauthFormService' => 'Usuario\Model\Service\Factory\OauthFormFactory',
        'Usuario\Model\Service\OauthFacebookService' => 'Usuario\Model\Service\Factory\OauthFacebookFactory',
        'Usuario\Model\Service\OauthTwitterService' => 'Usuario\Model\Service\Factory\OauthTwitterFactory',
        'Usuario\Model\Service\UsuarioService' => 'Usuario\Model\Service\Factory\UsuarioFactory',
        'Usuario\Model\Service\PerfilPagoService' => 'Usuario\Model\Service\Factory\PerfilPagoFactory',
        
        //forms
        'Usuario\Form\UsuarioForm' => 'Usuario\Form\Factory\UsuarioFactory',
        'Usuario\Form\BuscarForm'  => 'Usuario\Form\Factory\BuscarFactory',
    ),
    'invokables' => array(
    ),
);