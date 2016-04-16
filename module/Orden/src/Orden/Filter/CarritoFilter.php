<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Filter;
use Common\Filter\Zf2InputFilter;

class CarritoFilter extends Zf2InputFilter
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
            'name' => 'usuario_id',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Usuario_id'),
            )
        ));

        $this->add(array(
            'name' => 'pago_referencia',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Pago_referencia'),
            )
        ));

        $this->add(array(
            'name' => 'pago_estado',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Pago_estado'),
            )
        ));

        $this->add(array(
            'name' => 'pago_tarjeta',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Pago_tarjeta'),
            )
        ));

        $this->add(array(
            'name' => 'monto_total',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Monto_total'),
            )
        ));

        $this->add(array(
            'name' => 'estado',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Estado'),
            )
        ));

        $this->add(array(
            'name' => 'fecha_creacion',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fecha_creacion'),
            )
        ));

        $this->add(array(
            'name' => 'fecha_edicion',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fecha_edicion'),
            )
        ));

    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
