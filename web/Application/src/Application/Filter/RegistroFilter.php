<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Application\Filter;
use Common\Filter\Zf2InputFilter;

class RegistroFilter extends Zf2InputFilter
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
            'name' => 'email',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Correo electrónico'),
                self::validatorEmailAddress('Correo electrónico'),
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Contraseña'),
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
                            \Zend\Validator\Identical::NOT_SAME => "Las contraseñas no coinciden.",
                            \Zend\Validator\Identical::MISSING_TOKEN => 'Repetir contraseña por favor.',
                        ),
                        'break_chain_on_failure' => true,
                    ),
                ),
            )
        ));
        
        $this->add(array(
            'name' => 'nombres',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Nombres'),
            )
        ));

        $this->add(array(
            'name' => 'paterno',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Apellido paterno'),
            )
        ));

        $this->add(array(
            'name' => 'materno',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Apellido materno'),
            )
        ));

        $this->add(array(
            'name' => 'cod_pais',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Pais'),
            )
        ));

        $this->add(array(
            'name' => 'cod_depa',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Departamento'),
            )
        ));

        $this->add(array(
            'name' => 'cod_dist',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Distrito'),
            )
        ));
        
        $this->add(array(
            'name' => 'di_tipo',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Documento de Identidad'),
            )
        ));
        
        $this->add(array(
            'name' => 'di_valor',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Documento de Identidad'),
            )
        ));

        $this->add(array(
            'name' => 'fecha_nac',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fecha de nacimiento'),
            )
        ));
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
