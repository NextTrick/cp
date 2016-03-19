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
    private $_sidebarMenus = array();
    private $_ddlMenus = array();

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    private function _sidebarRecursiveItems($id, $uriPath)
    {
        $menus = array();
        $newActive = false;
        foreach ($this->_sidebarMenus as $key => $row) {
            if ($row['recurso_id'] == $id) {
                $xmenus = $this->_sidebarRecursiveItems($row['id'], $uriPath);
                
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
                unset($this->_sidebarMenus[$key]);
            }
        }
        ksort($menus);
        return array(
            'items' => $menus,
            'active' => $newActive,
        );
    }


    public function getSidebarMenus($rolId, $uriPath)
    {
        $this->_sidebarMenus = $this->getRepository()->findSidebarMenus($rolId);
        
        $menus = array();
        foreach ($this->_sidebarMenus as $key => $row) {
            if (empty($row['recurso_id'])) {
                $xmenus = $this->_sidebarRecursiveItems($row['id'], $uriPath);
                
                $active = false;
                if ($xmenus['active'] === true) {
                    $active = true;
                } else {
                    $active = (!empty($row['url']) && strpos($uriPath, $row['url']) !== false);
                }

                $row['hijos'] = $xmenus['items'];
                $row['active'] = $active;

                $menus[$row['orden']] = $row;
                unset($this->_sidebarMenus[$key]);
            }
        }
        ksort($menus);
        
        return $menus;
    }
    
    private function _ddlRecursiveItems($id)
    {
        $menus = array();
        foreach ($this->_ddlMenus as $key => $row) {
            if ($row['recurso_id'] == $id) {
                $row['prefix'] = isset($row['prefix']) ? '--' . $row['prefix'] : '----';
                $row['hijos'] = $this->_ddlRecursiveItems($row['id']);
                $menus[$row['orden']] = $row;
                unset($this->_ddlMenus[$key]);
            }
        }
        ksort($menus);
        
        $newMenus = array();
        foreach ($menus as $row) {
            $hijos = $row['hijos'];
            unset($row['hijos']);
            if (!empty($hijos)) {
                $newMenus[] = $row;
                foreach ($hijos as $row2) {
                    $newMenus[] = $row2;
                }
            } else {
                $newMenus[] = $row;
            }
        }
        
        return $newMenus;
    }
    
    public function getDropDownListMenus()
    {
        $newMenus = $this->getListMenus();
        
        $rows = array();
        foreach ($newMenus as $row) {
            $rows[$row['id']] = $row['prefix'] . ' ' . $row['nombre'];
        }

        return $rows;
    }

    public function getListMenus($criteria = array())
    {
        $this->_ddlMenus = $this->getRepository()->search($criteria);

        $menus = array();
        foreach ($this->_ddlMenus as $key => $row) {
            if (empty($row['recurso_id'])) {
                $row['prefix'] = '--';
                $row['hijos'] = $this->_ddlRecursiveItems($row['id']);
                $menus[$row['orden']] = $row;
                unset($this->_ddlMenus[$key]);
            }
        }
        ksort($menus);

        $newMenus = array();
        foreach ($menus as $row) {
            $hijos = $row['hijos'];
            unset($row['hijos']);
            if (!empty($hijos)) {
                $newMenus[] = $row;
                foreach ($hijos as $row2) {
                    $newMenus[] = $row2;
                }
            } else {
                $newMenus[] = $row;
            }
        }
        
        return $newMenus;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}