<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Filter;
use Common\Filter\Zf2InputFilter;

class PermisoFilter extends Zf2InputFilter
{
    protected $_values = array();

    public function __construct($values = array())
    {
        $this->_values = $values;
        
        $this->_addElements();
    }

    protected function _addElements()
    {        
        $this->add(array(
            'name' => 'rol_id',
            'required' => true,
            'validators' => array(
                self::validatorNotEmpty('Rol'),
                self::validatorDigits('Rol'),
            )
        ));
        $this->add(array(
            'name' => 'recurso_id',
            'required' => true,
            'validators' => array(
                self::validatorNotEmpty('Recurso'),
                self::validatorDigits('Recurso'),
            )
        ));
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
