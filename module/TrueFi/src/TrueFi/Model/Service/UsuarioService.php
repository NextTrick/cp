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
    
    private function getUrl($tipo)
    {
        $urls = array(
            self::METHOD_NEW_MEMBER => $this->_config->url . 'NewMember.php',
            self::METHOD_LOGON => $this->_config->url . 'logon.php',
        );
        
        return isset($urls[$tipo]) ? $urls[$tipo] : null;
    }
    
    private function getRules($tipo)
    {
        $rules = array(
            self::METHOD_NEW_MEMBER => array(
                'FirstName',
                'LastName',
                'EMail',
                'Password',
                'Type',
            )
        );
        
        return isset($rules[$tipo]) ? $rules[$tipo] : array();
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
                    $dataValid[$key] = $data[$key];
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
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_NEW_MEMBER);
            $data = Response::curl($url, $this->_config, $jsonData);
            if ($data['success']) {
                $result['success'] = true;
                $result['mguid'] = $data['data']->Data->MGUID;
                return $result;
            } else {
                $result['msg'] = 'Error';
            }
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