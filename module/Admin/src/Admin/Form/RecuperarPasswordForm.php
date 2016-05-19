<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class RecuperarPasswordForm extends Form
{
    protected $_sl = null;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct();
        
        $this->_sl = $serviceLocator;

        $this->_addForm();
        $this->_addElements();
    }
    
    protected function _addForm()
    {
        $this->setAttribute('id', 'formRecuperarPassword');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $email = new Element\Text('email');
        $email->setAttributes(array(
                'id' => 'email',
                'autocomplete' => 'off',
                'maxlength' => '30',
                'class' => 'form-control',
            ));
        $this->add($email);
        
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
                'value' => 'Enviar',
                'class' => 'btn btn-primary btn-block btn-flat'
            )
        ));
    }
}
