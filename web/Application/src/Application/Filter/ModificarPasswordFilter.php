<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Application\Filter;
use Common\Filter\Zf2InputFilter;

class ModificarPasswordFilter extends Zf2InputFilter
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
            'name' => 'password',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Contraseña'),
                self::validatorStringLength('contraseña'),
            )
        ));

        $this->add(array(
            'name' => 'password_repeat',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Repetir contraseña'),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                        'message' => array(
                            \Zend\Validator\Identical::NOT_SAME => "Las contraseñas ingresadas no coinciden.",
                            \Zend\Validator\Identical::MISSING_TOKEN => 'Repetir contraseña por favor.',
                        ),
                        'break_chain_on_failure' => true,
                    ),
                ),
            )
        ));
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
