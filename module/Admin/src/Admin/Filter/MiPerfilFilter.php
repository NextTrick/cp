<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Filter;
use Common\Filter\Zf2InputFilter;

class MiPerfilFilter extends Zf2InputFilter
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
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Rol'),
                self::validatorDigits('Rol'),
            )
        ));
        
        $this->add(array(
            'name' => 'email',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Email'),
                self::validatorEmailAddress('Email'),
            )
        ));
        
        if (isset($this->_values['repeat']) && $this->_values['repeat']) {
            $this->add(array(
                'name' => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    self::validatorNotEmpty('Password'),
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
                    self::validatorNotEmpty('Repetir password'),
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password',
                            'message' => array(
                                \Zend\Validator\Identical::NOT_SAME => "Los Passwords no coinciden.",
                                \Zend\Validator\Identical::MISSING_TOKEN => 'Repetir password por favor.',
                            ),
                            'break_chain_on_failure' => true,
                        ),
                    ),
                )
            ));
        }
        
        $this->add(array(
            'name' => 'estado',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Estado'),
                self::validatorDigits('Estado'),
            )
        ));
        
        $this->add(array(
            'name' => 'imagen',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Imagen'),
            )
        ));
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
