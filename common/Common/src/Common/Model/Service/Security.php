<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Common\Model\Service;

use Zend\ServiceManager\ServiceLocatorInterface;

class Security
{
    protected $_sl = null;
    
    const MODULE_ADMIN = 'Admin';

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_sl = $serviceLocator;                
    }

    protected function _getPublicControllers()
    {
        return array(
            'Admin\Controller\Login',
            'Admin\Controller\Error',
        );
    }
    
    protected function _getPrivateCommonControllers()
    {
        return array(
            'Admin\Controller\Main',
        );
    }
    
    protected function _getModuleControllerAction()
    {
        return array(
            self::MODULE_ADMIN => array(
                'Admin\Controller\Main' => array(),
                'Admin\Controller\Usuario' => array(
                    'R' => array('index'),
                    'C' => array('crear'),
                    'U' => array('modificar'),
                    'D' => array('eliminar'),
                ),
                'Admin\Controller\Permiso' => array(
                    'R' => array('index'),
                    'C' => array('crear'),
                    'U' => array('modificar'),
                    'D' => array('eliminar'),
                ),
                'Admin\Controller\Rol' => array(
                    'R' => array('index'),
                    'C' => array('crear'),
                    'U' => array('modificar'),
                    'D' => array('eliminar'),
                ),
                'Admin\Controller\Recurso' => array(
                    'R' => array('index'),
                    'C' => array('crear'),
                    'U' => array('modificar'),
                    'D' => array('eliminar'),
                ),
            ),
        );
    }
    
    public function getModules()
    {
        $modules = $this->_getModuleControllerAction();
        return array_keys($modules);
    }
    
    protected function _checkAction($inController, $inAction, $inAclString)
    {
        $success = false;
        $modules = $this->_getModuleControllerAction();
        foreach ($modules as $controllers) {
            foreach ($controllers as $controller => $actions) {
                if ($inController == $controller) {
                    foreach ($actions as $acl => $arrayAction) {
                        if (strpos(strtolower($inAclString), strtolower($acl)) !== false) {
                            if (in_array($inAction, $arrayAction)) {
                                $success = true;
                                break;
                            }
                        }
                    }
                }
            }
        }
        
        return $success;
    }

    public function isAccessAllowed($currentController, $currentAction)
    {
        if (in_array($currentController, $this->_getPublicControllers())) {
            return true;
        }
        
        $identity = $this->_getLoginService()->getRepository()->getIdentity();
        if ($identity === false) {
            return false;
        }
        
        $controllerPart = explode('\\', $currentController);
        if (count($controllerPart) == 3) {
            $module = strtolower(array_shift($controllerPart));
            $controller = strtolower(array_pop($controllerPart));

            if (in_array($currentController, $this->_getPrivateCommonControllers())) {
                return true;
            }
            $slug = $module . '/' . $controller;
            $aclString = $this->_getLoginService()->getRepository()->getAcl($identity->id, $slug);
            return $this->_checkAction($currentController, $currentAction, $aclString);
        }

        return false;
    }

    public function getAcl($controller)
    {
        $acl = new \stdClass();
        $acl->c = false;
        $acl->r = false;
        $acl->u = false;
        $acl->d = false;
        $identity = $this->_getLoginService()->getRepository()->getIdentity();
        
        if ($identity !== false) {
            $aclString = $this->_getLoginService()->getRepository()->getAcl($identity->id, $controller);
            if (!empty($aclString)) {
                $aclString = strtolower($aclString);
                for ($i = 0; $i < strlen($aclString); $i++) {
                    switch ($aclString[$i]) {
                        case 'C':
                            $acl->c = true;
                            break;
                        case 'R':
                            $acl->r = true;
                            break;
                        case 'U':
                            $acl->u = true;
                            break;
                        case 'D':
                            $acl->d = true;
                            break;
                    }
                }
            }
        }
        
        return $acl;
    }

    protected function _getLoginService()
    {
        return $this->_sl->get('Admin\Model\Service\LoginService');
    }
}
