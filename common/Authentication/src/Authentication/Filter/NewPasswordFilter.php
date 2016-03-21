<?php

namespace Authentication\Filter;

use Util\Filter\Base\BaseFilter;

class NewPasswordFilter extends BaseFilter
{
    public function init()
    {
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'options' => array(
                'label' => 'Clave: ',
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 32,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'password2',
            'required' => true,
            'options' => array(
                'label' => 'Repetir Clave: ',
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 32,
                    ),
                ),
            ),
        ));      
    }
}