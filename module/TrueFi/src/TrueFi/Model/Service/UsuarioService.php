<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace TrueFi\Model\Service;
use TrueFi\Model\Service\Response;

class UsuarioService
{
    const TIPO_CLIENTE = 1;
    const TIPO_EMPRESA = 2;


    const METHOD_NEW_MEMBER = 'newMember';
    const METHOD_LOGON = 'logon';


    protected $_sl = null;
    protected $_config = null;

    public function __construct($serviceLocator)
    {
        $this->_sl = $serviceLocator;
        $this->_setCofig();
    }
    
    private function _setCofig()
    {
        $config = $this->_sl->get('config');
        $this->_config = (object)$config['api']['true_fi'];
    }
    
    private function getUrl()
    {
        return array(
            self::METHOD_NEW_MEMBER => $this->_config->url . 'NewMember.php',
            self::METHOD_LOGON => $this->_config->url . 'logon.php',
        );
    }
    
    private function getRules()
    {
        return array(
            self::METHOD_NEW_MEMBER => array(
                'FirstName',
                'LastName',
                'EMail',
                'Password',
                'Type',
            )
        );
    }

    private function validate($data, $tipo)
    {
        $rules = $this->getRules($tipo);
        $result = array(
            'success' => false,
            'msg' => 'Error de validación',
        );
        $keyData = array_keys($data);
        $errorRules = array();
        $valid = true;
        foreach ($keyData as $field) {
            if (!in_array($field, $rules)) {
                $errorRules[] = $field;
                $valid = false;
            }
        }
        
        if (!$valid) {
            $result['msg'] = 'Ingrese los campos obligatorios ' . implode(', ', $errorRules);
        } else {
            $dataValid = array();
            foreach ($data as $key => $value) {
                if (in_array($key, $rules)) {
                    $dataValid[] = $data[$key];
                }
            } 

            $result['success'] = true;
            $result['data'] = $dataValid;
        }
        
        return $result;
    }

    public function newMember($data)
    { 
        $result = $this->validate($data, self::METHOD_NEW_MEMBER);
        if ($result['success']) {
            $jsonData = json_decode($result['data']);
            return Response::curl($this->getUrl(self::METHOD_NEW_MEMBER), $jsonData);
        } else {
            return $result;
        }
    }
    
    public function logon()
    {
        
    }
    
    public function getMember()
    {
        
    }
    
    public function setMember()
    {
        
    }
    
    public function activeMember()
    {
        
    }
    
    public function changePassword()
    {
        
    }
    
    public function recoverPassword()
    {
        
    }
}