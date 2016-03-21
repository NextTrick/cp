<?php

namespace Authentication\Filter;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
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
                    'options' => array(),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
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
                        'min' => 3,
                        'max' => 32,
                    ),
                ),
            ),
        )); 
        
        $this->add(array(
            'name' => 'redirect',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),            
        ));
    }   
}