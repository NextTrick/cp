<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Common\Controller;

use Zend\Mvc\Controller\AbstractActionController;

abstract class SecurityAdminController extends AbstractActionController
{
    protected function _toUrlLogin()
    {
        return $this->redirect()->toRoute('admin/crud', array('controller' => 'login'));
    }
    
    protected function _toUrlMain()
    {
        return $this->redirect()->toRoute('admin/crud', array('controller' => 'main'));
    }
    
    protected function _getLoginService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\LoginService');
    }
    
    protected function _getDbAdapter()
    {
        return $this->getServiceLocator()->get('dbAdapter');
    }
}