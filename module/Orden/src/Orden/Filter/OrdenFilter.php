<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Filter;
use Common\Filter\Zf2InputFilter;

class OrdenFilter extends Zf2InputFilter
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
            'name' => 'comprobante_tipo',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Comprobante_tipo'),
            )
        ));

        $this->add(array(
            'name' => 'comprobante_numero',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Comprobante_numero'),
            )
        ));

        $this->add(array(
            'name' => 'fac_razon_social',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fac_razon_social'),
            )
        ));

        $this->add(array(
            'name' => 'fac_ruc',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fac_ruc'),
            )
        ));

        $this->add(array(
            'name' => 'fac_direccion_fiscal',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fac_direccion_fiscal'),
            )
        ));

        $this->add(array(
            'name' => 'fac_direccion_entrega_factura',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Fac_direccion_entrega_factura'),
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
                self::validatorNotEmpty('Paterno'),
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
                self::validatorNotEmpty('Materno'),
            )
        ));

        $this->add(array(
            'name' => 'ciudadania',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Ciudadania'),
            )
        ));

        $this->add(array(
            'name' => 'doc_identidad',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Doc_identidad'),
            )
        ));

        $this->add(array(
            'name' => 'direccion',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Direccion'),
            )
        ));

        $this->add(array(
            'name' => 'pais_id',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Pais_id'),
            )
        ));

        $this->add(array(
            'name' => 'distrito_id',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Distrito_id'),
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
            'name' => 'monto',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Monto'),
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
