<?php

return array(
    'factories' => array(
        //services
        'TrueFi\Model\Service\UsuarioService' => 'TrueFi\Model\Service\Factory\UsuarioFactory',
        'TrueFi\Model\Service\TarjetaService' => 'TrueFi\Model\Service\Factory\TarjetaFactory',
    ),
    'invokables' => array(
    ),
);