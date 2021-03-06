<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

class OauthFormService
{
    private $_auth;
    private $_adapter;
    private $_resultLogin;

    const NOT_IDENTITY = 'notIdentity';
    const INVALID_CREDENTIAL = 'invalidCredential';
    const INVALID_USER = 'invalidUser';
    const INVALID_LOGIN = 'invalidLogin';
    const DISABLED_USER = 'disabledUser';

    protected $messages = array(
        self::NOT_IDENTITY => 'Los datos ingresados son incorrectos.',
        self::INVALID_CREDENTIAL => 'Los datos ingresados son incorrectos.',
        self::INVALID_USER => 'Los datos ingresados son incorrectos.',
        self::INVALID_LOGIN => 'Los datos ingresados son incorrectos.',
        self::DISABLED_USER => 'El usuario no esta activado.',
    );
    
    protected $_repository = null;
    protected $_sl = null;

    public function __construct(Adapter $adapter, $repository, $serviceLocator)
    {
        $this->_adapter = $adapter;
        $this->_auth = new AuthenticationService();
        $this->_auth->setStorage(new SessionStorage('session_usuario'));
        $authAdapter = new AuthAdapter($this->_adapter, 'usuario_usuario', 'email', 'password');
        $this->_auth->setAdapter($authAdapter);
        
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function login($email, $password)
    {
        $this->_resultLogin = new \stdClass();
        $this->_resultLogin->error = true;
        $this->_resultLogin->message = $this->messages[self::INVALID_LOGIN];

        if (!empty($email) && !empty($password)) {
            $password = \Common\Helpers\Util::passwordEncrypt($password, $email);
            $this->_auth->getAdapter()->setIdentity($email);
            $this->_auth->getAdapter()->setCredential($password);
            $result = $this->_auth->authenticate();

            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    $this->_resultLogin->error = true;
                    $this->_resultLogin->message = $this->messages[self::NOT_IDENTITY];
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    $this->_resultLogin->error = true;
                    $this->_resultLogin->message = $this->messages[self::INVALID_CREDENTIAL];
                    break;
                case Result::SUCCESS:
                    if ($result->isValid()) {
                        $data = $this->getRepository()->getUsuarioByEmail($email);
                        if (!empty($data)) {
                            $this->_auth->getStorage()->write($data);
                            $this->_resultLogin->error = false;
                            $this->_resultLogin->message = null;
                        } else {
                            $this->logout();
                            $this->_resultLogin->error = true;
                            $this->_resultLogin->message = $this->messages[self::DISABLED_USER];
                        }
                    }
                    break;
            }
        }
        
        return $this;
    }
    
    public function getResultLogin()
    {
        return $this->_resultLogin;
    }

    public function logout()
    {
        $this->_auth->clearIdentity();
        return $this;
    }

    public function getIdentity()
    {
        if ($this->_auth->hasIdentity()) {
            return $this->_auth->getIdentity();
        }
        return false;
    }

    public function isLoggedIn()
    {
        return $this->_auth->hasIdentity();
    }

    public function getData()
    {
        if ($this->_auth->hasIdentity()) {
            return $this->_auth->getStorage()->read();
        }
        
        return array();
    }

    public function setMessage($messageString, $messageKey = null)
    {
        if ($messageKey === null) {
            $keys = array_keys($this->messages);
            $messageKey = current($keys);
        }

        if (!isset($this->messages[$messageKey])) {
            throw new \Exception('No message exits for key ' . $messageKey);
        }
        
        $this->messages[$messageKey] = $messageString;
        return $this;
    }

    public function setMessages(array $messages)
    {
        foreach ($messages as $key => $message) {
            $this->setMessage($message, $key);
        }
        return $this;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}