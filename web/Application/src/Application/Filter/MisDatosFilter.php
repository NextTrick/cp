<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Application\Filter;
use Common\Filter\Zf2InputFilter;
use Zend\InputFilter\FileInput;

class MisDatosFilter extends Zf2InputFilter
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
        
        $changePassword = $this->_getValueDefault('changePassword');
        
        if ($changePassword) {
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
            'name' => 'pais_id',
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
            'name' => 'departamento_id',
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
            'name' => 'distrito_id',
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
        
        $image = new FileInput('imagen');
        $image->setRequired(false);
        $image->getValidatorChain()
            ->attachByName('filesize', array('max' => 2000000))
            ->attachByName('fileextension',  array(
                'jpg', 'jpeg', 'png'
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
