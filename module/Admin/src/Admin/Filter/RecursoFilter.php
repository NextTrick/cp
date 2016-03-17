<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Filter;
use Common\Filter\Zf2InputFilter;

class RecursoFilter extends Zf2InputFilter
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
            'name' => 'recurso_id',
            'required' => false,
            'validators' => array(
                self::validatorNotEmpty('Menú'),
                self::validatorDigits('Menú'),
            )
        ));
        $this->add(array(
            'name' => 'nombre',
            'required' => true,
            'validators' => array(
                self::validatorNotEmpty('Nombre'),
            )
        ));
        $this->add(array(
            'name' => 'url',
            'required' => false,
            'validators' => array(
                self::validatorNotEmpty('Url'),
            )
        ));
        $this->add(array(
            'name' => 'nivel',
            'required' => true,
            'validators' => array(
                self::validatorNotEmpty('Nivel'),
                self::validatorDigits('Nivel'),
            )
        ));
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
