<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsuarioForm extends Form
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
        $this->setAttribute('id', 'formUsuario');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $criteria = array(
            'columns' => array('id', 'nombre'),
            'order' => array('nombre ASC'),
        );
        $roles = $this->_getRolService()->getRepository()->findPairs($criteria);
        $roleId = new Element\Select('rol_id');
        $roleId->setAttributes(array('id' => 'rol_id'));
        $roleId->setValueOptions($roles);
        $roleId->setEmptyOption('- Seleccione -');
        $roleId->setDisableInArrayValidator(true);
        $this->add($roleId);

        $email = new Element\Text('email');
        $email->setAttributes(array(
                'id' => 'email',
                'maxlength' => '30',
                'autocomplete' => 'off',
            ));
        $this->add($email);
        
        $password = new Element\Password('password');
        $password->setAttributes(array(
                'id' => 'password',
                'maxlength' => '100',
                'autocomplete' => 'off',
            ));
        $this->add($password);
        
        $passwordRep = new Element\Password('password_repeat');
        $passwordRep->setAttributes(array(
                'id' => 'password_repeat',
                'maxlength' => '100',
                'autocomplete' => 'off',
            ));
        $this->add($passwordRep);

        $imagen = new Element\Text('imagen');
        $imagen->setAttributes(array(
                'id' => 'imagen',
                'maxlength' => '50',
            ));
        $this->add($imagen);
        
        $estado = new Element\Checkbox('estado');
        $estado->setUseHiddenElement(true);
        $estado->setCheckedValue('1');
        $estado->setUncheckedValue('0');
        $this->add($estado);
    }
    
    protected function _getRolService()
    {
        return $this->_sl->get('Admin\Model\Service\RolService');
    }
}
