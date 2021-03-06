<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\Model\Repository;

use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

class LoginRepository
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
        self::NOT_IDENTITY => 'Usuario y/o Password es incorrecto.',
        self::INVALID_CREDENTIAL => 'Usuario y/o Password es incorrecto.',
        self::INVALID_USER => 'Usuario y/o Password es incorrecto.',
        self::INVALID_LOGIN => 'Usuario y/o Password es incorrecto.',
        self::DISABLED_USER => 'El usuario esta deshabilitado.',
    );

    public function __construct(Adapter $adapter)
    {
        $this->_adapter = $adapter;
        $this->_auth = new AuthenticationService();
        $this->_auth->setStorage(new SessionStorage('session_admin'));
        $authAdapter = new AuthAdapter($this->_adapter, 'admin_usuario', 'email', 'password');
        $this->_auth->setAdapter($authAdapter);
    }

    public function login($username, $password)
    {
        $this->_resultLogin = new \stdClass();
        $this->_resultLogin->error = true;
        $this->_resultLogin->message = $this->messages[self::INVALID_LOGIN];

        if (!empty($username) && !empty($password)) {
            $password = \Common\Helpers\Util::passwordHash($password);
            $this->_auth->getAdapter()->setIdentity($username);
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
                        $data = $this->_getUsuarioData($result->getIdentity());
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
        $container = new \Zend\Session\Container('initialized');
        $container->offsetUnset('init');
        $container->offsetUnset('remoteAddr');
        $container->offsetUnset('httpUserAgent');
        return $this;
    }

    public function getIdentity()
    {
        if ($this->_auth->hasIdentity()) {
            return $this->_auth->getIdentity();
        }
        return false;
    }
    
    public function getData()
    {
        if ($this->_auth->hasIdentity()) {
            return $this->_auth->getStorage()->read();
        }
        return array();
    }

    public function isLoggedIn()
    {
        return $this->_auth->hasIdentity();
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

    protected function _getUsuarioData($username)
    {
        try {
            $sql = new \Zend\Db\Sql\Sql($this->_adapter);
            $select = $sql->select();
            $select->from(array('a' => 'admin_usuario'));
            $select->columns(array('id', 'email', 'rol_id', 'imagen'));
            $select->where(array('a.email' => $username, 'a.estado' => 1));
            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            $result = $results->current();

            if (!empty($result)) {
                $partEmail = explode('@', $result['email']);
                $data = new \stdClass();
                $data->id = $result['id'];
                $data->username = array_shift($partEmail);
                $data->email = $result['email'];
                $data->rol_id = $result['rol_id'];
                $data->image = $result['imagen'];
                return $data;
            }
        } catch (\Exception $e) {
            \Common\Helpers\Error::initialize()->logException($e);
        }
                
        return false;
    }

    public function getAcl($userId, $slug)
    {
        try {
            $sql = new \Zend\Db\Sql\Sql($this->_adapter);
            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('a' => 'admin_usuario'));
            $select->columns(array());
            $select->join(array('b' => 'admin_rol'), 'a.rol_id = b.id', array());
            $select->join(array('c' => 'admin_permiso'), 'c.rol_id = b.id', array('acl'));
            $select->join(array('d' => 'admin_recurso'), 'c.recurso_id = d.id', array());
            $select->where(array('a.id' => $userId));
            $select->where(array('d.url' => $slug));

            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = new \Zend\Db\ResultSet\ResultSet();
            $row = $resultSet->initialize($statement->execute())->current();

            if (isset($row['acl'])) {
                return $row['acl'];
            }
        } catch (\Exception $e) {
            \Common\Helpers\Error::initialize()->logException($e);
        }
        
        return null;
    }
}