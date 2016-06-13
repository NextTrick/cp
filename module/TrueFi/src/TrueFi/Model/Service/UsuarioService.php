<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace TrueFi\Model\Service;
use TrueFi\Model\Service\Response;
use TrueFi\Model\Service\Request;

class UsuarioService
{
    const TIPO_CLIENTE = 1;
    const TIPO_EMPRESA = 2;

    const METHOD_LOGON = 'Logon';
    const METHOD_NEW_MEMBER = 'NewMember';
    const METHOD_GET_MEMBER = 'GetMember';
    const METHOD_SET_MEMBER = 'SetMember';
    const METHOD_ACTIVATE_MEMBER = 'ActivateMember';
    const METHOD_DELETE_MEMBER = 'DeleteMember';
    const METHOD_RECOVER_PASSWORD = 'RecoverPassword';
    const METHOD_CHANGE_PASSWORD = 'ChangePassword';


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
            self::METHOD_LOGON => $this->_config->url . self::METHOD_LOGON . '.php',
            self::METHOD_NEW_MEMBER => $this->_config->url . self::METHOD_NEW_MEMBER . '.php',
            self::METHOD_GET_MEMBER => $this->_config->url . self::METHOD_GET_MEMBER . '.php',
            self::METHOD_SET_MEMBER => $this->_config->url . self::METHOD_SET_MEMBER . '.php',
            self::METHOD_ACTIVATE_MEMBER => $this->_config->url . self::METHOD_ACTIVATE_MEMBER . '.php',
            self::METHOD_DELETE_MEMBER => $this->_config->url . self::METHOD_DELETE_MEMBER . '.php',
            self::METHOD_RECOVER_PASSWORD => $this->_config->url . self::METHOD_RECOVER_PASSWORD . '.php',
            self::METHOD_CHANGE_PASSWORD => $this->_config->url . self::METHOD_CHANGE_PASSWORD . '.php',
        );
        
        return isset($urls[$tipo]) ? $urls[$tipo] : null;
    }
    
    private function getRules($tipo)
    {
        $rules = array(
            self::METHOD_LOGON => array(
                'EMail',
                'Password',
            ),
            self::METHOD_NEW_MEMBER => array(
                'FirstName',
                'LastName',
                'EMail',
                'Password',
                'Type',
            ),
            self::METHOD_GET_MEMBER => array(
                'MGUID',
            ),
            self::METHOD_SET_MEMBER => array(
                'MGUID',
                'Data', /* => array(
                "FIRSTNAME" => "Marcio",
                "LASTNAME" => "Benso",
                "PASSWORD" => "BgAAABSwfdiJ+TOg",
                "IDNUMBER" => "12345678",
                "BIRTHDATE" => "2012-01-01",
                "GENDER" => "M",
                "CHILDS" => array(
                    array("Name" => "Agostina", "Gender" => "F", "Birthdate" => "2003-10-04")
                ),
                "EMAIL" => "mbenso@cointech.com.ar",
                "PHONE" => "4894654654",
                "ADDRESS" => "Crisol 18",
                "STATE" => array("ius" => "50", "id" => "3"),
                "CITY" => array("ius" => "50", "id" => "4"),
                "BRANCHS" => array("V35"),
                "ACTIVE" => true,
                "TYPE" => "1",
                "AVATAR" => array("iusavatar" => "50", "idavatar" => "1000000001"),
                "AVATARURL" => "/Avatars/1000000001.jpg",
                "cards" => array(
                    array("NUMBER" => "000-102079-1", "CGUID" => "{2AC405C3-9056-45F9-8AFA-5559CF6F75CA}", "STATUS" => "0")
                ))*/
            ),
            self::METHOD_ACTIVATE_MEMBER => array(
                'MGUID',
            ),
            self::METHOD_DELETE_MEMBER => array(
                'MGUID',
            ),
            self::METHOD_RECOVER_PASSWORD => array(
                'EMail',
            ),
            self::METHOD_CHANGE_PASSWORD => array(
                'MGUID',
                'Password',
                'OldPassword',
            ),
        );
        
        return isset($rules[$tipo]) ? $rules[$tipo] : array();
    }

    public function logon($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_LOGON));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_LOGON);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['mguid'] = $curlData['data']['data']['mguid'];
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function newMember($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_NEW_MEMBER));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_NEW_MEMBER);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['mguid'] = $curlData['data']['data']['mguid'];
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function getMember($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_GET_MEMBER));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_GET_MEMBER);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                    $result['result'] = $curlData['data']['data'];
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function setMember($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_SET_MEMBER));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_SET_MEMBER);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function activateMember($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_ACTIVATE_MEMBER));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_ACTIVATE_MEMBER);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function deleteMember($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_DELETE_MEMBER));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_DELETE_MEMBER);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }

    public function recoverPassword($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_RECOVER_PASSWORD));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_RECOVER_PASSWORD);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
    
    public function changePassword($data)
    {
        $result = Request::validate($data, $this->getRules(self::METHOD_CHANGE_PASSWORD));
        if ($result['success']) {
            $jsonData = json_encode($result['data']);
            $url = $this->getUrl(self::METHOD_CHANGE_PASSWORD);
            $curlData = Response::curl($url, $this->_config, $jsonData);
            if ($curlData['success']) {
                if (isset($curlData['data']['code']) && $curlData['data']['code'] == 0) {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = !empty($curlData['data']['message']) ? $curlData['data']['message'] : null;
                }
            } else {
                $result['success'] = false;
                $result['message'] = $curlData['message'];
            }
        }
        
        unset($result['data']);
        return $result;
    }
}