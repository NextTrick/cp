<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Common\Filter;

use Zend\InputFilter\InputFilter;

class Zf2InputFilter extends InputFilter
{
    public static function validatorNotEmpty($labelName)
    {
        return array(
            'name' => 'NotEmpty',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\NotEmpty::IS_EMPTY => "$labelName es requerido."
                ),
                'break_chain_on_failure' => true,
            )
        );
    }
    
    public static function validatorDigits($labelName)
    {
        return array(
            'name' => 'Digits',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Digits::NOT_DIGITS  => "$labelName debe contener sólo dígitos.",
                    \Zend\Validator\Digits::STRING_EMPTY => "$labelName es requerido.",
                    \Zend\Validator\Digits::INVALID => "$labelName es un valor numérico",
                ),
                'break_chain_on_failure' => true
            )
        );
    }
    
    public static function validatorEmailAddress($labelName)
    {
        return array(
            'name' => 'EmailAddress',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\EmailAddress::INVALID  => "$labelName no es una dirección válida.",
                    \Zend\Validator\EmailAddress::INVALID_FORMAT => "$labelName no es una dirección válida.",
                    \Zend\Validator\EmailAddress::INVALID_HOSTNAME => "'%hostname%' no es un nombre de host válido para el Email.",
                    \Zend\Validator\EmailAddress::INVALID_MX_RECORD => "'%hostname%' no parecen tener ningún MX o A registros válidos para el Email.",
                    \Zend\Validator\EmailAddress::INVALID_SEGMENT => "'%hostname%' no está en un segmento de red enrutable. El Email no debe ser resuelto desde la red pública.",
                    \Zend\Validator\EmailAddress::DOT_ATOM => "'%hostname%' no puede ser comparada con el formato dot-atom.",
                    \Zend\Validator\EmailAddress::QUOTED_STRING => "'%hostname%' no puede ser comparada con el formato quoted-string.",
                    \Zend\Validator\EmailAddress::INVALID_LOCAL_PART => "'%hostname%' no es una parte local válida para el Email.",
                    \Zend\Validator\EmailAddress::LENGTH_EXCEEDED => "$labelName supera la longitud permitida.",
                ),
                'break_chain_on_failure' => true
            )
        );
    }
    
    public static function validatorHostname($labelName)
    {
        return array(
            'name' => 'Hostname',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Hostname::CANNOT_DECODE_PUNYCODE => "La entrada parece ser un nombre de host DNS pero la notación punycode dado no puede ser decodificada",
                    \Zend\Validator\Hostname::INVALID => "Tipo no válido. se esperaba una cadena",
                    \Zend\Validator\Hostname::INVALID_DASH => "La entrada parece ser un nombre de host DNS, pero contiene un guión en una posición no válida",
                    \Zend\Validator\Hostname::INVALID_HOSTNAME => "La entrada no coincide con la estructura esperada para un nombre de host DNS",
                    \Zend\Validator\Hostname::INVALID_HOSTNAME_SCHEMA => "La entrada parece ser un nombre de host DNS pero no puede coincidir con el esquema nombre de host para TLD '%tld%'",
                    \Zend\Validator\Hostname::INVALID_LOCAL_NAME => "La entrada no parece ser un nombre de red local válida",
                    \Zend\Validator\Hostname::INVALID_URI => "La entrada no parece ser un nombre de URI válido",
                    \Zend\Validator\Hostname::IP_ADDRESS_NOT_ALLOWED => "La entrada parece ser una dirección IP, direcciones IP no estan permitidas",
                    \Zend\Validator\Hostname::LOCAL_NAME_NOT_ALLOWED => "La entrada parece ser un nombre de red local, pero los nombres de red locales no están permitidos",
                    \Zend\Validator\Hostname::UNDECIPHERABLE_TLD => "La entrada parece ser un nombre de host DNS, pero no puede extraer parte TLD",
                    \Zend\Validator\Hostname::UNKNOWN_TLD => "La entrada parece ser un nombre de host DNS pero no puede coincidir con la lista conocida TLD",
                ),
                'break_chain_on_failure' => true
            )
        );
    }
}
