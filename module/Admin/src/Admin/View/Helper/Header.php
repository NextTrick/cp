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

class Header extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke()
    {
        $sl = $this->getServiceLocator()->getServiceLocator();

        /*$notifications = array(
            'success' => array(
                'icon' => 'fa-envelope-o',
                'name' => 'You have 1 notifications',
                'children' => array(
                    array(
                        'name' => 'Categorías 1',
                        'url' => '#',
                        'icon' => 'fa-users text-aqua',
                    ),
                    array(
                        'name' => 'Categorías 2',
                        'url' => '#',
                        'icon' => 'fa-users text-aqua',
                    ),
                    array(
                        'name' => 'Categorías 3',
                        'url' => '#',
                        'icon' => 'fa-users text-aqua',
                    ),
                )
            ),
            'warning' => array(
                'icon' => 'fa-bell-o',
                'name' => 'You have 1 notifications',
                'children' => array(
                    array(
                        'name' => 'Categorías 4',
                        'url' => '#',
                        'icon' => 'fa-users text-aqua',
                    ),
                    array(
                        'name' => 'Categorías 5',
                        'url' => '#',
                        'icon' => 'fa-users text-aqua',
                    ),
                    array(
                        'name' => 'Categorías 6',
                        'url' => '#',
                        'icon' => 'fa-users text-aqua',
                    ),
                )
            ),
        );*/
        
        $notifications = array();
        $identity = $sl->get('Admin\Model\Service\LoginService')->getRepository()->getIdentity();
        
        $config = $sl->get('config');
        $urlImg = isset($config['fileDir']['usuario_usuario']['down']) ? $config['fileDir']['usuario_usuario']['down'] : null;
        $user = new \stdClass();
        $user->username = null;
        $user->image = null;
        $user->urlImg = null;
        $user->urlProfile = '#';
        if ($identity !== false) {
            $user->username = $identity->username;
            $user->image = empty($identity->image) ? 'user-default.png' : $identity->image;
            $user->urlImg = $urlImg;
            $user->urlProfile = '#';
        }
        
        return $this->getView()->render('helper/header.phtml',
                array('notifications' => $notifications, 'user' => $user));
    }

    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
        return $this;
    }
}