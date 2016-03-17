<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\Model\Service;

namespace Admin\Model\Service;

class LoginService
{
    protected $_repository = null;
    protected $_sl = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getMenus($uriPath)
    {
        return array(
            array(
                'name' => 'Usuario y Roles',
                'url' => '',
                'icon' => 'fa-dashboard',
                'active' => true,
                'children' => array(
                    array(
                        'name' => 'Roles',
                        'url' => 'admin/rol',
                        'icon' => 'fa-circle-o',
                        'active' => true,
                    ),
                    array(
                        'name' => 'Recursos',
                        'url' => 'admin/recurso',
                        'icon' => 'fa-circle-o',
                        'active' => false,
                    ),
                    array(
                        'name' => 'Permisos',
                        'url' => 'admin/permiso',
                        'icon' => 'fa-circle-o',
                        'active' => false,
                    ),
                    array(
                        'name' => 'Usuarios',
                        'url' => 'admin/usuario',
                        'icon' => 'fa-circle-o',
                        'active' => false,
                    ),
                )
            ),
//            array(
//                'name' => 'Paquetes',
//                'url' => '',
//                'icon' => 'fa-files-o',
//                'active' => false,
//                'children' => array(
//                    array(
//                        'name' => 'Pedidos',
//                        'url' => 'admin/order',
//                        'icon' => 'fa-circle-o',
//                        'active' => false,
//                    ),
//                )
//            ),
        );
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}