<?php

namespace Authentication\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class RecoverForm extends Form
{
    public function __construct()
    {
        parent::__construct('recuperar-form');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'recuperar-form');

        $this->add(array('name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'maxlength' => 85
            ),
            'options' => array(
                'label' => 'Email: '
            )
        ));
        
        $this->add(new Element\Csrf('security'));

        $this->add(array('name' => 'reset',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enviar'
            ),
        ));
    }
}