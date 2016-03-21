<?php
namespace Authentication\Model\Service;
          
use Util\Model\Service\Base\AbstractService;
use Usuario\Model\Entity\PerfilEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService as ZendAuthService;

class AuthenticationServicesd extends ZendAuthService
{   
    /**
     * Credentials' table
     * @var string 
     */
    protected $_table = 'usuario_usuario';    
    
    /**
     * Default identity column
     * @var string 
     */
    protected $_identityColumn = 'email';
    
    /**
     * Default credential column
     * @var string
     */
    protected $_credentialColumn = 'usuario'; 
        
    /**
     *
     * @var \Zend\Authentication\Adapter\DbTable
     */
    protected $_dbTable;

    public function __construct(Adapter $adapter) 
    {
        parent::__construct(null, $adapter);
        
        $this->_dbTable = new DbTable($adapter);
        $this->_dbTable->setTableName($this->_table);
        $this->_dbTable
            ->setIdentityColumn($this->_identityColumn)                        
            ->setCredentialColumn($this->_credentialColumn)
            ->getDbSelect()->where(array('estado' => 1));
    }
    
    public function setCredentialColumns($identityColumn, $credentialColumn)
    {
        $this->_identityColumn = $identityColumn;
        $this->_credentialColumn = $credentialColumn;
        
        $this->_dbTable
            ->setIdentityColumn($identityColumn)                        
            ->setCredentialColumn($credentialColumn);            
    }
    
    public function login(PerfilEntity $perfil)
    {
        $this->setCredentials($perfil);                
        $result = $this->authenticate($this->_dbTable);
        if ($result->isValid()) {
            $this->_writeStorage($perfil);            
        }

        return $result;
    }
    
//    public function authenticate(PerfilEntity $perfil)
//    {                
//        $this->setCredentials($perfil);                
//        $result = parent::authenticate($this->_dbTable);
//        if ($result->isValid()) {
//            $this->_writeStorage($perfil);            
//        }
//
//        return $result;
//    }
    
    private function _writeStorage(PerfilEntity $perfil)
    {        
        $this->getStorage()->write($perfil);        
    }
    
    public function setCredentials(PerfilEntity $perfil)
    {
        $entityMethod = 'get' . \Util\Common\String::prepareForMethod($this->_identityColumn);
        $credentialsMethod = 'get' . \Util\Common\String::prepareForMethod($this->_credentialColumn);
        
        $this->_dbTable
             ->setIdentity($perfil->getUsuario()->$entityMethod())
             ->setCredential($perfil->getUsuario()->$credentialsMethod());
    }
        
    public function logout()
    {
        $this->clearIdentity();
    }
}