<?php

namespace Authentication\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login-form');

        $this->setAttribute('method', 'post');

        $this->add(array('name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'class' => 'mb0',
                'maxlength' => 75
            ),
            'options' => array(
                'label' => 'Usuario : '
            )
        ));

        $this->add(array('name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'mb0',
                'maxlength' => 32
            ),
            'options' => array(
                'label' => 'Clave : '
            )
        ));
        
        $this->add(array('name' => 'redirect',
            'attributes' => array(
                'type' => 'hidden',                
            )
        ));

        $this->add(new Csrf('security'));

        $this->add(array('name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Inicia Sesión'
            ),
        ));
    }
}