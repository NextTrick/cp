<?php

namespace Authentication\Filter;

use Util\Filter\Base\BaseFilter;

class RecoverFilter extends BaseFilter
{
    public function init()
    {
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 150,
                    ),
                ),
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'message' => 'Debe ingresar un formato de correo valido',
                    ),
                ),
            ),
        ));        
    }
}