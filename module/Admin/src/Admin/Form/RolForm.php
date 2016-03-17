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

class RolForm extends Form
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
        $this->setAttribute('id', 'formRol');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $nombre = new Element\Text('nombre');
        $nombre->setAttributes(array(
                'id' => 'nombre',
                'maxlength' => '45',
            ));
        $this->add($nombre);
        
        $estado = new Element\Checkbox('estado');
        $estado->setUseHiddenElement(true);
        $estado->setCheckedValue('1');
        $estado->setUncheckedValue('0');
        $estado->setValue('1');
        $this->add($estado);
    }
}
