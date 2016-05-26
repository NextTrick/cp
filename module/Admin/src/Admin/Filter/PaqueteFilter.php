<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Filter;
use Common\Filter\Zf2InputFilter;
use Zend\Validator\File\ImageSize;

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

        $valExtension = new \Zend\Validator\File\Extension(array('jpg', 'jpeg', 'png'));
        $valExtension->setMessage('La imagen debe ser de tipo JPG o PNG');

        $valSize = new \Zend\Validator\File\Size(array('min' => '1kB', 'max' => '2MB'));
        $valSize->setMessage('El tamaño máximo permitido para la imagen es de 2MB', \Zend\Validator\File\Size::TOO_BIG);

        $valUpload = new \Zend\Validator\File\UploadFile();
        $valUpload->setMessage('El tamaño máximo  permitido para la imagen es de 2MB', \Zend\Validator\File\UploadFile::INI_SIZE);

        $image = new \Zend\InputFilter\FileInput('imagen');
        $image->setRequired(false)
              ->setErrorMessage("El tamaño máximo permitido para la imagen es 2MB y debe ser de tipo JPG o PNG");

        $image->getValidatorChain()
            ->attach($valSize)
            ->attach($valUpload)
            ->attach($valExtension)
           ;

        $image->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target' => $this->_getValueDefault('uploadDir'),
                'use_upload_name' => true,
                'use_upload_extension' => true,
                'overwrite' => true,
                'randomize' => false,
            ), 4
        );
        
        $this->add($image);
    }

    protected function _getValueDefault($key)
    {
        return isset($this->_values[$key]) ? $this->_values[$key] : null;
    }
}
