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

class RecursoForm extends Form
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
        $this->setAttribute('id', 'formRecurso');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $recursos = $this->_getRecursoService()->getDropDownListMenus();
        $recursoId = new Element\Select('recurso_id');
        $recursoId->setAttributes(array('id' => 'recurso_id'));
        $recursoId->setValueOptions($recursos);
        $recursoId->setEmptyOption('- Seleccione -');
        $recursoId->setDisableInArrayValidator(true);
        $this->add($recursoId);

        $nombre = new Element\Text('nombre');
        $nombre->setAttributes(array(
                'id' => 'nombre',
                'maxlength' => '60',
            ));
        $this->add($nombre);
        
        $url = new Element\Text('url');
        $url->setAttributes(array(
                'id' => 'url',
                'maxlength' => '120',
            ));
        $this->add($url);
        
        $nivel = new Element\Text('orden');
        $nivel->setAttributes(array(
                'id' => 'orden',
                'maxlength' => '5',
            ));
        $this->add($nivel);
        
        $icono = new Element\Text('icono');
        $icono->setAttributes(array(
                'id' => 'icono',
                'maxlength' => '50',
            ));
        $this->add($icono);
        
        $estado = new Element\Checkbox('estado');
        $estado->setUseHiddenElement(true);
        $estado->setCheckedValue('1');
        $estado->setUncheckedValue('0');
        $estado->setValue('1');
        $this->add($estado);
    }
    
    protected function _getRecursoService()
    {
        return $this->_sl->get('Admin\Model\Service\RecursoService');
    }
}
