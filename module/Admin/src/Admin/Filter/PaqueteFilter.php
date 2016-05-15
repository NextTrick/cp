<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Filter;
use Common\Filter\Zf2InputFilter;

class PaqueteFilter extends Zf2InputFilter
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
            'name' => 'titulo1',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Titulo 1'),
            )
        ));
        
        $this->add(array(
            'name' => 'titulo2',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorNotEmpty('Titulo 2'),
            )
        ));
        
        $this->add(array(
            'name' => 'tipo',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                self::validatorDigits('Tipo'),
            )
        ));
        
        $image = new \Zend\InputFilter\FileInput('imagen');
        $image->setRequired(false);
        $image->getValidatorChain()
            ->attachByName('filesize', array('max' => 204800))
            ->attachByName('fileextension',  array(
                'jpg', 'jpeg', 'png', 'gif'
            ))
            ->attachByName('fileimagesize', array('maxWidth' => 500, 'maxHeight' => 500));
        
        $image->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target' => $this->_getValueDefault('uploadDir'),
                'use_upload_name' => true,
                'use_upload_extension' => true,
                'overwrite' => true,
                'randomize' => false,
            )
        );
        
        $this->add($image);
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
