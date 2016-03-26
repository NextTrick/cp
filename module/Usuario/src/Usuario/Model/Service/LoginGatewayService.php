<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

class LoginGatewayService
{
    const LOGIN_FORM = 'form';
    const LOGIN_TWITTER = 'twitter';
    const LOGIN_FACEBOOK = 'facebook';

    protected $_sl;
    protected $_email;
    protected $_password;
    protected $_gateway;
    
    public function __construct($serviceLocator)
    {
        $this->_sl = $serviceLocator;
    }

    public function setCredential($email, $password)
    {
        $this->_email = $email;
        $this->_password = $password;
        return $this;
    }
    
    public function setGateway($gateway)
    {
        $this->_gateway = $gateway;
        return $this;
    }
    
    public function getGateways()
    {
        return array(
            self::LOGIN_FORM,
            self::LOGIN_FACEBOOK,
            self::LOGIN_TWITTER,
        );
    }

    public function login()
    {
        if (self::LOGIN_FORM == $this->_gateway) {
            $oauth = $this->_getLoginService($this->_gateway);
            return $oauth->login($this->_email, $this->_password)->getResultLogin();
        } else {
            $this->_getLoginService($this->_gateway)->login();
        }
    }
    
    public function callback()
    {
        return $this->_getLoginService($this->_gateway)->callback();
    }

    public function logout()
    {
        $this->_getLoginService(self::LOGIN_FORM)->logout();
        $this->_getLoginService(self::LOGIN_FACEBOOK)->logout();
        $this->_getLoginService(self::LOGIN_TWITTER)->logout();
    }

    public function isLoggedIn()
    {
        $isLoginForm = $this->_getLoginService(self::LOGIN_FORM)->isLoggedIn();
        $isLoginFacebook = $this->_getLoginService(self::LOGIN_FACEBOOK)->isLoggedIn();
        $isLoginTwitter = $this->_getLoginService(self::LOGIN_TWITTER)->isLoggedIn();
        
        if ($isLoginForm || $isLoginFacebook || $isLoginTwitter) {
            return true;
        }

        return false;
    }

    protected function _getLoginService($gateway)
    {
        if (in_array($gateway, $this->getGateways())) {
            $gateway = ucfirst(strtolower($gateway));
            return $this->_sl->get("Usuario\Model\Service\Oauth{$gateway}Service");
        } else {
            throw new \Exception("No existe el modo de validación $gateway");
        }
    }
}