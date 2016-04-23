<?php

return array(
    'factories' => array(
        //forms
        'Application\Form\LoginForm' => 'Application\Form\Factory\LoginFactory',
        'Application\Form\RegistroForm' => 'Application\Form\Factory\RegistroFactory',
//        'Application\Form\RecuperarPasswordForm' => 'Application\Form\Factory\RecuperarPasswordFactory',
        'Application\Form\ModificarPasswordForm' => 'Application\Form\Factory\ModificarPasswordFactory',
    ),
    'invokables' => array(
    ),
);