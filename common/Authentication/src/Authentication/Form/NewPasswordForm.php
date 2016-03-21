<?php

namespace Authentication\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class NewPasswordForm extends Form
{
    public function __construct()
    {
        parent::__construct('generar-clave-form');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'generar-clave-form');

        $this->add(array('name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'maxlength' => 32
            ),
            'options' => array(
                'label' => 'Password : '
            )
        ));
        
        $this->add(array('name' => 'password2',
            'attributes' => array(
                'type' => 'password',
                'maxlength' => 32
            ),
            'options' => array(
                'label' => 'Repetir password : '
            )
        ));
        
        $this->add(new Element\Csrf('security'));

        $this->add(array('name' => 'reset',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Recuperar'
            ),
        ));
    }
}