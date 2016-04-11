<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace TrueFi\Model\Service;

class Request
{
    public static function validate($data, $rules)
    {
        $result = array(
            'success' => false,
            'data' => array(),
            'message' => 'Error de validación',
        );
        $keyData = array_keys($data);
        $errorRules = array();
        $valid = true;
        
        if (!empty($rules)) {
            foreach ($keyData as $field) {
                if (!in_array($field, $rules)) {
                    $errorRules[] = $field;
                    $valid = false;
                }
            }
        }
        
        if (!$valid) {
            $result['message'] = 'Ingrese los campos obligatorios ' . implode(', ', $errorRules);
        } else {
            $dataValid = array();
            foreach ($data as $key => $value) {
                if (in_array($key, $rules)) {
                    $dataValid[$key] = $data[$key];
                }
            } 

            $result['success'] = true;
            $result['message'] = null;
            $result['data'] = $dataValid;
        }
        
        return $result;
    }
}