<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Filter;
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
            'name' => 'destacado',
            'required' => false
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

        $valExtension = new \Zend\Validator\File\Extension(array('jpg', 'jpeg', 'png', 'messages' => 'sasadsasa'));

        $image = new \Zend\InputFilter\FileInput('imagen');
        /*
        $image->setRequired(false);
        $image->getValidatorChain()
            ->attachByName('filesize', array('max' => '2MB', 'min' => '10KB'))
            ->attachByName('fileextension',  array('jpg', 'jpeg', 'png'));
*/
        $image->setRequired(false);
        $image->getValidatorChain()
            ->attach($valExtension)
            ->attachByName('fileextension',  array('jpg', 'jpeg', 'png'));

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
