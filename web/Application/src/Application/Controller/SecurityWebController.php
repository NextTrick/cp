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
        return $this->redirect()->toRoute('web-beneficios', array('controller' => 'beneficios'));
    }

    protected function _toUrlRecargas()
    {
        return $this->redirect()->toRoute('web-recargas', array('controller' => 'recargas'));
    }

    protected function _isLogin()
    {
        return $this->_getLoginGatewayService()->isLoggedIn();
    }
    
    protected function _getUsuarioData()
    {
        $data = $this->_getLoginGatewayService()->getData();
        
        if (empty($data)) {
            throw new \Exception('Su session expiro.');
        }
        
        $usuario = new \stdClass();
        $usuario->id = $data['id'];
        $usuario->email = $data['email'];
        $usuario->mguid = $data['mguid'];
        $usuario->nombres = $data['nombres'];
        $usuario->paterno = $data['paterno'];
        $usuario->materno = $data['materno'];

        return $usuario;
    }
    
    protected function _getLoginGatewayService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\LoginGatewayService');
    }
    
    protected function _getDbAdapter()
    {
        return $this->getServiceLocator()->get('dbAdapter');
    }
}