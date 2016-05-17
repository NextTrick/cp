<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Filter;
use Common\Filter\Zf2InputFilter;

class ContenidoFilter extends Zf2InputFilter
{
    protected $_values         = array();
    protected $_serviceLocator = null;

    public function __construct($serviceLocator, $values = array())
    {
        $this->_values         = $values;
        $this->_serviceLocator = $serviceLocator;
        $this->_addElements();

    }

    protected function _addElements()
    {
        $this->add(array(
            'name' => 'codigo',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Codigo'),
                array(
                    'name'    => 'Db\NoRecordExists',
                    'options' => array(
                        'table'     => 'cms_contenido',
                        'field'     => 'codigo',
                        'adapter'   => $this->_serviceLocator->get('dbAdapter'),
                        'message'   => 'Este código ya se encuentra registrado',
                    ),
                ),
            )
        ));

        $this->add(array(
            'name' => 'tipo',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Tipo'),
            )
        ));

        $this->add(array(
            'name' => 'titulo',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Titulo'),
            )
        ));

        $this->add(array(
            'name' => 'contenido',
            'required' => true,
            'validators' => array(
                self::validatorNotEmpty('Contenido'),
            )
        ));

        $this->add(array(
            'name'     => 'url',
            'required' => false
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
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
