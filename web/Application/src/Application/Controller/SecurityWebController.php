<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

abstract class SecurityWebController extends AbstractActionController
{
    protected function _toUrlLogin()
    {
        return $this->redirect()->toRoute('web-login/modalidad', array('controller' => 'login'));
    }
    
    protected function _toUrlMain()
    {
        return $this->redirect()->toRoute('web-panel/inbox', array('controller' => 'inicio'));
    }
    
    protected function _getLoginGatewayService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\LoginGatewayService');
    }
    
    protected function _getDbAdapter()
    {
        return $this->getServiceLocator()->get('dbAdapter');
    }
    
    protected function _isLogin()
    {
        
    }
}