<?php

return array(
    'factories' => array(
        //forms
        'Application\Form\LoginForm' => 'Application\Form\Factory\LoginFactory',
        'Application\Form\RegistroForm' => 'Application\Form\Factory\RegistroFactory',
        'Application\Form\MisDatosForm' => 'Application\Form\Factory\MisDatosFactory',
    ),
    'invokables' => array(
    ),
);