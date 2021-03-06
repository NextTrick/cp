<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Sidebar extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke()
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
                
        $menus = array();
        $loginService = $sl->get('Admin\Model\Service\LoginService')->getRepository();
        $identity = $loginService->getIdentity();
        
        $config = $sl->get('config');
        $urlImg = isset($config['fileDir']['usuario_usuario']['down']) ? $config['fileDir']['usuario_usuario']['down'] : null;
        
        $user = new \stdClass();
        $user->username = null;
        $user->image = null;
        $user->urlImg = null;
        $user->urlProfile = '#';
        if ($identity !== false) {
            $data = $loginService->getData();
            $user->username = $identity->username;
            $user->image = empty($identity->image) ? 'user-default.png' : $identity->image;
            $user->urlImg = $urlImg;
            if (!empty($data)) {
                $codeUser = \Common\Helpers\Crypto::encrypt($data->id, \Common\Helpers\Util::VI_ENCODEID);
                $user->urlProfile = BASE_URL . 'admin/main/mi-perfil?u=' . $codeUser;
            }
            
            $uriPath = $sl->get('Request')->getUri()->getPath();
            $menus = $sl->get('Admin\Model\Service\RecursoService')->getSidebarMenus($identity->rol_id, $uriPath);
        }

        return $this->getView()->render('helper/sidebar.phtml',
                array('menus' => $menus, 'user' => $user));
    }

    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
        return $this;
    }
}