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
    const TIPO_RECARGA        = 1;
    const TIPO_PROMOCION      = 2;
    const TIPO_NAME_RECARGA   = 'Recarga';
    const TIPO_NAME_PROMOCION = 'Promoción';

    const CANT_ACTIVO_TIPO_PROMOCION = 100;
    const CANT_ACTIVO_TIPO_RECARGA   = 100;

    const ESTADO_BAJA        = 0;
    const ESTADO_ACTIVO      = 1;
    const ESTADO_NAME_BAJA   = 'Inactivo';
    const ESTADO_NAME_ACTIVO = 'Activo';

    protected $_repository = null;
    protected $_sl         = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
    }

    public function getTipos()
    {
        return array(
            self::TIPO_RECARGA   => self::TIPO_NAME_RECARGA,
            self::TIPO_PROMOCION => self::TIPO_NAME_PROMOCION,
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
                'order' => array('orden ASC'),
            );
            $arrayDestacado = $this->_repository->findAll($criteria);
            $subTotal = count($arrayDestacado);
        }
        
        $resto = $cantidad - $subTotal;
        if ($resto > 0) {
            $where = new \Zend\Db\Sql\Where();
            $where->equalTo('activo', 1);
            $criteria = array(
                'where' => $where,
                'limit' => $cantidad,
                'order' => array('tipo DESC', 'orden ASC'),
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
    
    public function recargaPromociones()
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('activo', 1);
        $where->equalTo('tipo', self::TIPO_PROMOCION);
        $criteria = array(
            'where' => $where,
            'order' => array('orden ASC'),
        );
        $rows = $this->_repository->findAll($criteria);
        return \Common\Helpers\Util::formatoRecargas($rows);
    }
    
    public function grillaRecargas($cantidad)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('activo', 1);
        $where->equalTo('tipo', self::TIPO_RECARGA);
        $criteria = array(
            'where' => $where,
            'limit' => $cantidad,
            'order' => array('orden ASC'),
        );
        return $this->_repository->findAll($criteria);
    }
    
    public function recargaRecargas()
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('activo', 1);
        $where->equalTo('tipo', self::TIPO_RECARGA);
        $criteria = array(
            'where' => $where,
            'order' => array('orden ASC'),
        );
        
        $rows = $this->_repository->findAll($criteria);
        return \Common\Helpers\Util::formatoRecargas($rows);
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

    public function updateOrdenPaquete($tipo, $orden, $id)
    {
        $paquetes       = $this->_repository->getPaquetesByTipo($tipo);
        $paquetesUodate = array();
        $cont           = 1;
        $countUpdate    = 0;
        $band           = false;
        $cantTipoMax    = (self::TIPO_PROMOCION == $tipo)? self::CANT_ACTIVO_TIPO_PROMOCION: self::CANT_ACTIVO_TIPO_RECARGA;
        $ordenTemp      = null;
        echo "orden = ".$orden." Id = ".$id;
        foreach ($paquetes as $key => $reg) {

            if ($band == false && ($reg['orden'] == $orden || $orden == 1)) {
                $paquetesUodate[] = array(
                    'id'     => $id,
                    'orden'  => intval($orden),
                    'activo' => 1
                );

                $ordenTemp = intval($orden);
                $band      = true;
            }

            if ($band && !empty($reg['id']) && $reg['id'] != $id) {
                $ordenTemp ++;
                $paquetesUodate[] = array(
                    'id'     => $reg['id'],
                    'orden'  => $ordenTemp,
                    'activo' => ($cantTipoMax >= $cont)? 1: 0,
                );

                $cont ++;
                continue;
            } elseif ($band && !empty($reg['id']) && $reg['id'] == $id) {
                continue;
            }

            $paquetesUodate[] = array(
                'id'     => $reg['id'],
                'orden'  => $reg['orden'],
                'activo' => ($cantTipoMax >= $cont)? 1: 0,
            );

            $cont ++;
        }

        //var_dump($paquetesUodate);exit;

        foreach ($paquetesUodate as $key => $reg) {
            $id = $reg['id'];
            unset($reg['id']);
            $this->_repository->save($reg, $id);
            $countUpdate ++;
        }

        return $countUpdate;
    }

    public static function getNombreTipo($tipo)
    {
        $result = null;
        if (empty($tipo)) {
            return $result;
        }

        if (self::TIPO_RECARGA == $tipo) {
            $result = self::TIPO_NAME_RECARGA;
        } elseif (self::TIPO_PROMOCION == $tipo) {
            $result = self::TIPO_NAME_PROMOCION;
        }

        return $result;
    }

    public static function getNombreEstado($estado)
    {
        $result = null;
        if (!isset($estado)) {
            return $result;
        }

        if (self::ESTADO_ACTIVO == $estado) {
            $result = self::ESTADO_NAME_ACTIVO;
        } elseif (self::ESTADO_BAJA == $estado) {
            $result = self::ESTADO_NAME_BAJA;
        }

        return $result;
    }

}