<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Application\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginForm extends Form
{
    protected $_sl = null;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct();
        $this->_sl = $serviceLocator;

        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'formLogin');
        $this->setAttribute('name', 'formLogin');
        $this->_addElements();
    }

    protected function _addElements()
    {
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'id' => 'email',
                'type' => 'text',
                'placeholder' => 'Email',
                'autocomplete' => 'off',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'type' => 'password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'id' => 'password',
                'placeholder' => 'Password',
                'autocomplete' => 'off',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'token_csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
        
        $this->add(array(
            'name' => 'aceptar',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Aceptar',
                'class' => 'btn btn-primary btn-block btn-flat'
            )
        ));
    }
}