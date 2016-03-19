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

class PermisoForm extends Form
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
        $this->setAttribute('id', 'formPermiso');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $criteria1 = array(
            'columns' => array('id', 'nombre'),
            'order' => array('nombre ASC'),
        );
        $roles = $this->_getRolService()->getRepository()->findPairs($criteria1);
        $roleId = new Element\Select('rol_id');
        $roleId->setAttributes(array('id' => 'rol_id'));
        $roleId->setValueOptions($roles);
        $roleId->setDisableInArrayValidator(true);
        $this->add($roleId);
        
        $recursos = $this->_getRecursoService()->getDropDownListMenus();
        $recursoId = new Element\Select('recurso_id');
        $recursoId->setAttributes(array('id' => 'recurso_id'));
        $recursoId->setValueOptions($recursos);
        $recursoId->setEmptyOption('- Seleccione -');
        $recursoId->setDisableInArrayValidator(true);
        $this->add($recursoId);

        $listar = new Element\Checkbox('listar');
        $listar->setAttributes(array('id' => 'listar'));
        $listar->setUseHiddenElement(true);
        $listar->setCheckedValue('1');
        $listar->setUncheckedValue('0');
        $this->add($listar);
        
        $crear = new Element\Checkbox('crear');
        $crear->setUseHiddenElement(true);
        $crear->setCheckedValue('1');
        $crear->setUncheckedValue('0');
        $this->add($crear);
        
        $modificar = new Element\Checkbox('modificar');
        $modificar->setUseHiddenElement(true);
        $modificar->setCheckedValue('1');
        $modificar->setUncheckedValue('0');
        $this->add($modificar);
        
        $eliminar = new Element\Checkbox('eliminar');
        $eliminar->setUseHiddenElement(true);
        $eliminar->setCheckedValue('1');
        $eliminar->setUncheckedValue('0');
        $this->add($eliminar);
    }
    
    protected function _getRolService()
    {
        return $this->_sl->get('Admin\Model\Service\RolService');
    }
    
    protected function _getRecursoService()
    {
        return $this->_sl->get('Admin\Model\Service\RecursoService');
    }
}
