<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModificarPasswordForm extends Form
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
        $this->setAttribute('id', 'formModificarPassword');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $codigo = new Element\Hidden('codigo');
        $codigo->setAttributes(array(
                'id' => 'codigo',
                'maxlength' => '100',
            ));
        $this->add($codigo);

        $password = new Element\Password('password');
        $password->setAttributes(array(
                'id' => 'password',
                'autocomplete' => 'off',
                'maxlength' => '100',
            ));
        $this->add($password);
        
        $passwordRep = new Element\Password('password_repeat');
        $passwordRep->setAttributes(array(
                'id' => 'password_repeat',
                'autocomplete' => 'off',
                'maxlength' => '100',
            ));
        $this->add($passwordRep);
        
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
