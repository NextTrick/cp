<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Service;
use \Common\Helpers\String;

class OrdenService
{
    protected $_repository = null;
    protected $_sl         = null;

    CONST TIPO_COMPROBANTE_DNI      = 1;
    CONST TIPO_COMPROBANTE_RUC      = 2;
    CONST TIPO_COMPROBANTE_NAME_DNI = 'DNI';
    CONST TIPO_COMPROBANTE_NAME_RUC = 'RUC';

    CONST METODO_PAGO_VISA        = 1;
    CONST METODO_PAGO_PE          = 2;
    CONST METODO_PAGO_MASTER      = 3;
    CONST METODO_PAGO_NAME_VISA   = 'VISA';
    CONST METODO_PAGO_NAME_PE     = 'Pago Efectivo';
    CONST METODO_PAGO_NAME_MASTER = 'Master Card';

    CONST ESTADO_PAGO_ERROR          = 1;
    CONST ESTADO_PAGO_PAGADO         = 2;
    CONST ESTADO_PAGO_PENDIENTE      = 3;
    CONST ESTADO_PAGO_NAME_ERROR     = 'Error';
    CONST ESTADO_PAGO_NAME_PAGADO    = 'Pagado';
    CONST ESTADO_PAGO_NAME_PENDIENTE = 'Pendiente';

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }

    public function getDataCriteria($params)
    {
        $criteria = array(
            'whereLike'    => null,
            'limit'        => null,
            'where'        => null,
            'whereBetween' => null
        );

        if (!empty($params)) {
            $nameFilter = String::xssClean($params['cmbFiltro']);

            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                'comprobante_tipo' => String::xssClean($params['cmbTipoComp']),
                'pago_estado'      => String::xssClean($params['cmbEstado']),
                'pago_tarjeta'     => String::xssClean($params['cmbMetodoPago']),
            );

            $betwween = array(
                'fecha_creacion' => array(
                    'min'=> String::xssClean($params['txtFechaIni']),
                    'max'=> String::xssClean($params['txtFechaFin'])
                    )
            );

            $criteria = array(
                'whereLike'    => $paramsLike,
                'limit'        => LIMIT_BUSCAR,
                'where'        => $paramsWhere,
                'whereBetween' => $betwween
            );
        }

        return $criteria;
    }

    public static function getNombreTipoComprobante($tipoComprobante)
    {
        $result = null;
        if (empty($tipoComprobante)) {
            return $result;
        }

        if (self::TIPO_COMPROBANTE_RUC == $tipoComprobante) {
            $result = self::TIPO_COMPROBANTE_NAME_RUC;
        } elseif (self::TIPO_COMPROBANTE_DNI == $tipoComprobante) {
            $result = self::TIPO_COMPROBANTE_NAME_DNI;
        }

        return $result;
    }

    public static function getNombreTipoPago($tipoPago)
    {
        $result = null;
        if (empty($tipoPago)) {
            return $result;
        }

        if (self::METODO_PAGO_PE == $tipoPago) {
            $result = self::METODO_PAGO_NAME_PE;
        } elseif (self::METODO_PAGO_VISA == $tipoPago) {
            $result = self::METODO_PAGO_NAME_VISA;
        } elseif (self::METODO_PAGO_MASTER == $tipoPago) {
            $result = self::METODO_PAGO_NAME_MASTER;
        }

        return $result;
    }

    public static function getNombreEstadoPago($estadoPago)
    {
        $result = null;
        if (empty($estadoPago)) {
            return $result;
        }

        if (self::ESTADO_PAGO_ERROR == $estadoPago) {
            $result = self::ESTADO_PAGO_NAME_ERROR;
        } elseif (self::ESTADO_PAGO_PENDIENTE == $estadoPago) {
            $result = self::ESTADO_PAGO_NAME_PENDIENTE;
        } elseif (self::ESTADO_PAGO_PAGADO == $estadoPago) {
            $result = self::ESTADO_PAGO_NAME_PAGADO;
        }

        return $result;
    }

}