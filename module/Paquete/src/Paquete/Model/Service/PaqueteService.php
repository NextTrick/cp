<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Model\Service;

class PaqueteService
{
    const TIPO_RECARGA = 1;
    const TIPO_PROMOCION = 2;

    protected $_repository = null;
    protected $_sl = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getTipos()
    {
        return array(
            self::TIPO_RECARGA => 'Recarga',
            self::TIPO_PROMOCION => 'Promoción',
        );
    }

    public function grillaPromociones($cantidad, $destacado = 0)
    {
        $arrayDestacado = array();
        $arrayNormal = array();
        $subTotal = 0;
        if ($destacado > 0) {
            $where = new \Zend\Db\Sql\Where();
            $where->equalTo('activo', 1);
            $where->equalTo('destacado', 1);
            $where->equalTo('tipo', self::TIPO_PROMOCION);
            $criteria = array(
                'where' => $where,
                'limit' => $destacado,
                'order' => array('fecha_creacion DESC'),
            );
            $arrayDestacado = $this->_repository->findAll($criteria);
            $subTotal = count($arrayDestacado);
        }
        
        $resto = $cantidad - $subTotal;
        if ($resto > 0) {
            $where = new \Zend\Db\Sql\Where();
            $where->equalTo('activo', 1);
            $where->equalTo('tipo', self::TIPO_PROMOCION);
            $criteria = array(
                'where' => $where,
                'limit' => $cantidad,
                'order' => array('fecha_creacion DESC'),
            );
            $arrayNormal = $this->_repository->findAll($criteria);
            
            if (!empty($arrayDestacado)) {
                foreach ($arrayNormal as $key => $row1) {
                    foreach ($arrayDestacado as $row2) {
                        if ($row1['id'] == $row2['id']) {
                            //se elimina lo que ya esta en el array destacado
                            unset($arrayNormal[$key]);
                        }
                    }
                }
                $arrayNormal = array_values($arrayNormal);
            }
        }
        return array('destacado' => $arrayDestacado, 'normal' => $arrayNormal);
    }
    
    public function grillaRecargas($cantidad)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('activo', 1);
        $where->equalTo('tipo', self::TIPO_RECARGA);
        $criteria = array(
            'where' => $where,
            'limit' => $cantidad,
            'order' => array('fecha_creacion DESC'),
        );
        return $this->_repository->findAll($criteria);
    }

    public function getRepository()
    {
        return $this->_repository;
    }
    
    public function promocionesEnTrueFi()
    {
        return $this->_getTrueFiPaqueteService()->getPromotions();
    }
    
    protected function _getTrueFiPaqueteService()
    {
        return $this->_sl->get('TrueFi\Model\Service\PromocionService');
    }
}