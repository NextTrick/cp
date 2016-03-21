<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use Zend\Session\Container;

class OauthTwitterService
{
    protected $_repository = null;
    protected $_sl = null;
    protected $_config = null;
    protected $_container = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
        $this->_container = new Container('usuario_web');
        $this->_setCofig();
    }

    private function _setCofig()
    {
        $config = $this->_sl->get('config');
        $this->_config = (object)$config['social']['twitter'];
    }
    
    public function login()
    {

    }

    public function isLogin()
    {
        if ($this->_container->offsetExists('access_token')) {
            return true;
        }
        return false;
    }
    
    public function logout()
    {
        $this->_container->offsetUnset('access_token');
    }
    
    public function getRepository()
    {
        return $this->_repository;
    }
}