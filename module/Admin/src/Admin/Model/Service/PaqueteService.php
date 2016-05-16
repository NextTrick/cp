<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Model\Service;
use \Common\Helpers\String;

class PaqueteService
{
    protected $_repository = null;
    protected $_sl         = null;

    CONST DESTACADO_SI      = 1;
    CONST DESTACADO_NO      = 0;
    CONST DESTACADO_NAME_SI = 'Si';
    CONST DESTACADO_NAME_NO = 'No';

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


    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }

    public function getDataCriteria($params)
    {
        $criteria = array(
            'whereLike' => null,
            'limit'     => null,
            'where'     => null,
        );

        if (!empty($params)) {
            $nameFilter = String::xssClean($params['cmbFiltro']);

            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                'activo'    => String::xssClean($params['cmbActivo']),
                'destacado' => String::xssClean($params['cmbDestacado'])
            );

            $criteria = array(
                'whereLike' => $paramsLike,
                'limit'     => LIMIT_BUSCAR,
                'where'     => $paramsWhere
            );
        }

        return $criteria;
    }

    public static function getNombreDestacado($destacado)
    {
        $result = self::DESTACADO_NAME_NO;

        if (self::DESTACADO_SI == $destacado) {
            return self::DESTACADO_NAME_SI;
        }

        return $result;
    }

    public function getDestacado()
    {
        return array(
            self::DESTACADO_SI => self::DESTACADO_NAME_SI,
            self::DESTACADO_NO => self::DESTACADO_NAME_NO
        );
    }

    /**
     * Retorna un array que se utilizar en la busqueda de usuario
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function getFiltrosBuscar()
    {
        return array(
            'titulo1' => 'Titulo 1',
            'titulo2' => 'Titulo 2'
        );
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
            $where->equalTo('tipo', self::TIPO_PROMOCION);
            $criteria = array(
                'where' => $where,
                'limit' => $cantidad,
                'order' => array('orden ASC'),
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
            'order' => array('orden ASC'),
        );
        return $this->_repository->findAll($criteria);
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
        $cantTipoMax    = (self::TIPO_PROMOCION == $tipo)? CANT_ACTIVO_TIPO_PROMOCION: CANT_ACTIVO_TIPO_RECARGA;
        $ordenTemp      = null;
        
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

    public function updateDestacados($idPaquete, $destacado, $tipo)
    {
        if (empty($destacado) || (!empty($tipo) && $tipo == self::TIPO_RECARGA)) {
            return null;
        }
        
        $paquetesDestacados = $this->_repository->getDestacados();
        $bandBaja           = null;
        $bandAlta           = null;

        $count = 0;
        foreach ($paquetesDestacados as $key => $reg) {
            if ($count == LIMIT_DESTACADOS) {
                break;
            }

            $destacadoValidos[] = $reg['id'];
            $count ++;
        }

        $idPaqueteBaja= array_shift($destacadoValidos);
        if (!empty($destacadoBaja)) {
            $temp['destacado'] = 0;
            $bandBaja = $this->_repository->save($temp, $idPaqueteBaja);
        }

        if (!empty($idPaquete)) {
            $temp['destacado'] = 1;
            $bandAlta = $this->_repository->save($temp, $idPaquete);
        }

        $destacadoValidos[] = $idPaquete;

        $cantPaquetesBaja = $this->_repository->darBajaDestacados($destacadoValidos);
        
        return array(
            'IdBaja'           => !empty($bandBaja)? $destacadoBaja['id']: 0,
            'IdAlta'           => !empty($bandAlta)? $idPaquete: 0,
            'cantPaquetesBaja' => $cantPaquetesBaja,
        );
    }


}