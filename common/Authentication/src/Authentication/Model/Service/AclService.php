<?php

namespace Authentication\Model\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Exception\InvalidArgumentException;
use Usuario\Model\Repository\RolRepository;

class AclService
{
    const SERVICE_ROL = 'Auth\Model\Service\RolesService';
    const SERVICE_USER = 'Auth\Model\Service\UsersService';    
    const SERVICE_RESOURCE = 'Auth\Model\Service\RecursosService';
    const SERVICE_PERMISSIONS = 'Auth\Model\Service\RolesRecursosService';
    const FIELD_ROL_ID = 'rol_id';
    const FIELD_RESOURCE_URI = 'rec_uri';
           
    /**
     * @var Acl
     */
    private $_acl;

    /**
     * @var String
     */
    private $_rol;

    /**
     * @var String
     */
    private $_resource;
    
    /**     
     * @var Zend\ServiceManager\ServiceLocatorInterface 
     */
    protected $_sl;

    /**
     *
     * @var \Usuario\Model\Repository\RolRepository
     */
    private $_rolService;

    public function __construct()
    {
        $this->_acl = new Acl();
    }

    /**
     * Genera el ACL para la aplicacion
     * 
     * @return Acl
     */
    public function begin()
    {
        $this->_loadRoles();
        $this->_loadResources();
        $this->_loadPermissions();
    }

    /**
     * Valida si el usuario tiene permisos o no     
     * 
     * @return boolean
     */
    public function validate()
    {
        $cleanResource = $this->_cleanResource($this->_resource);
        if (!$this->_acl->hasResource($cleanResource)) {            
            return true;
        }

        try {
            $allow = $this->_acl->isAllowed($this->_rol, $cleanResource);
        } catch (InvalidArgumentException $e) {            
            $allow = false;
        }
        
        return $allow;
    }

    /**
     * Inicia el recurso de la peticion actual
     * 
     * @param Array|String $info
     * 
     * @return void
     */
    public function setResource($info)
    {
        if (is_array($info)) {
            $this->_resource = "{$info['module']}/{$info['controller']}";
        } else {
            $this->_resource = $info;
        }
    }

    /**
     * Inicia el recurso de la peticion actual
     * 
     * @param String $info
     * 
     * @return void
     */
    public function setRol($rol)
    {
        $this->_rol = $rol;
    }

    /**
     * Limpia el recurso para la comparar en el ACL
     * 
     * @param String $resource
     * 
     * @return String
     */
    private function _cleanResource($resource)
    {
        $replace = array('-');
        $filter = array('');

        return str_replace($replace, $filter, $resource);
    }

    /**
     * Carga los roles
     * 
     * @return void
     */
    private function _loadRoles()
    {
        $roles = $this->getRoles();
        
        foreach ($roles as $rol) {
            $this->_acl->addRole(new GenericRole($rol[self::FIELD_ROL_ID]));
        }        
    }
    
    protected function getRoles()
    {
        return $this->getRolService()->getAll();
    }
        
    public function getRolService()
    {
        return $this->_sl->get(self::SERVICE_ROL);
    }
    
    /**
     * Carga todos los recursos
     * 
     * @return void
     */
    private function _loadResources()
    {
        $recusosIgnorados = $this->_getRecursosIgnorados();        

        $resources = $this->_getResources();
        
        $ignorado = false;
        foreach ($resources as $resource) {
            if (empty($resource[self::FIELD_RESOURCE_URI])) {
                continue;
            }
            
            foreach ($recusosIgnorados as $ri) {                
                if (strpos($resource[self::FIELD_RESOURCE_URI], $ri) !== FALSE) {
                    $ignorado = true;
                }
            }

            if ($ignorado == false) {
                if (!$this->_acl->hasResource($resource[self::FIELD_RESOURCE_URI])) {
                    $this->_acl->addResource($resource[self::FIELD_RESOURCE_URI]);
                }
            }
        }
    }

    /**
     * Todos los permisos para el moderador (rol root usa esto)
     * 
     * @return Array
     */
    private function _getResources()
    {
        return $this->getResourceService()->getAll();
    }
    
    public function getResourceService()
    {
        return $this->_sl->get(self::SERVICE_RESOURCE);
    }
        
    /**
     * Carga los permisos por defecto
     * 
     * TODO: leer permisos e la tabla
     * @return void
     */
    private function _loadPermissions()
    {       
        $rolPermissions = $this->getPermissionsService()->getPermissions();        
        
        foreach ($rolPermissions as $rol => $permission) {
            $this->_acl->allow($rol, $permission);
        }      
    }
    
    public function getPermissionsService()
    {
        return $this->_sl->get(self::SERVICE_PERMISSIONS);
    }

    public function setRolService($rolService)
    {
        $this->_rolService = $rolService;
    }

    public function _getRecursosIgnorados()
    {
        $config = $this->_sl->get('config');
        $publicResources = $config['authentication']['acl']['resources']['public_resources'];
        return $publicResources;
    }
    
    public function setServiceLocator($sl)
    {
        $this->_sl = $sl;
    }    
}