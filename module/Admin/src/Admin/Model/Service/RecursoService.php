<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Model\Service;

class RecursoService
{
    protected $_repository = null;
    protected $_sl = null;
    private $_menus = array();

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    private function recursiveItems($id, $uriPath)
    {
        $menus = array();
        $newActive = false;
        foreach ($this->_menus as $key => $row) {
            if ($row['recurso_id'] == $id) {
                $xmenus = $this->recursiveItems($row['id'], $uriPath);
                
                $active = false;
                if ($xmenus['active'] === true) {
                    $newActive = true;
                    $active = true;
                } else {
                    $active = (!empty($row['url']) && strpos($uriPath, $row['url']) !== false);
                    if ($active) {
                        $newActive = true;
                    }
                }

                $row['hijos'] = $xmenus['items'];
                $row['active'] = $active;
                
                $menus[$row['orden']] = $row;
                unset($this->_menus[$key]);
            }
        }
        ksort($menus);
        return array(
            'items' => $menus,
            'active' => $newActive,
        );
    }


    public function getMenus($rolId, $uriPath)
    {
        $this->_menus = $this->getRepository()->findSidebarMenus($rolId);
        
        $menus = array();
        foreach ($this->_menus as $key => $row) {
            if (empty($row['recurso_id'])) {
                $xmenus = $this->recursiveItems($row['id'], $uriPath);
                
                $active = false;
                if ($xmenus['active'] === true) {
                    $active = true;
                } else {
                    $active = (!empty($row['url']) && strpos($uriPath, $row['url']) !== false);
                }

                $row['hijos'] = $xmenus['items'];
                $row['active'] = $active;

                $menus[$row['orden']] = $row;
                unset($this->_menus[$key]);
            }
        }
        ksort($menus);
        
        return $menus;
    }
    
    public function getRepository()
    {
        return $this->_repository;
    }
}