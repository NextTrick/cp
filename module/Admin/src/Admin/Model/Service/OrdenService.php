<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Model\Service;
use \Common\Helpers\String;

class OrdenService
{
    protected $_repository = null;
    protected $_sl         = null;

    CONST TIPO_COMPROBANTE_BOLETA       = 1;
    CONST TIPO_COMPROBANTE_FACTURA      = 2;
    CONST TIPO_COMPROBANTE_NAME_BOLETA  = 'Boleta';
    CONST TIPO_COMPROBANTE_NAME_FACTURA = 'Factura';

    CONST TIPO_DOCUMENTO_RUC      = 1;
    CONST TIPO_DOCUMENTO_DNI      = 2;
    CONST TIPO_DOCUMENTO_NAME_RUC = 'RUC';
    CONST TIPO_DOCUMENTO_NAME_DNI = 'DNI';

    CONST METODO_PAGO_NAME_VISA   = 'VISA';
    CONST METODO_PAGO_NAME_PE     = 'PE';
    
    CONST ESTADO_PAGO_NAME_ERROR     = 'Error';
    CONST ESTADO_PAGO_NAME_PAGADO    = 'Pagado';
    const ESTADO_PAGO_NAME_EXPIRADO  = 'Expirado';
    const ESTADO_PAGO_NAME_EXTORNADO  = 'Extornado';
    const ESTADO_PAGO_NAME_NUEVO  = 'Nuevo';
    //CONST ESTADO_PAGO_NAME_PENDIENTE = 'Pendiente';

    CONST ESTADO_NAME_ERROR     = 'Error';
    CONST ESTADO_NAME_NUEVO     = 'Nuevo';
    CONST ESTADO_NAME_PROCESADO = 'Procesado';

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
        $order = array('pago_fecha_confirmacion DESC', 'id DESC',);
        
        $criteria = array(
            'whereLike'    => null,
            'limit'        => null,
            'where'        => null,
            'whereBetween' => null,
            'order'        => $order
        );

        if (!empty($params)) {
            $nameFilter            = String::xssClean($params['cmbFiltro']);
            $params['txtFechaFin'] = (!empty($params['txtFechaFin']))? $params['txtFechaFin']." 23:59:59" : null;


            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                'comprobante_tipo' => String::xssClean($params['cmbTipoComp']),
                'pago_estado'      => String::xssClean($params['cmbPagoEstado']),
                'pago_metodo'     => String::xssClean($params['cmbMetodoPago']),
                'o.estado'     => String::xssClean($params['cmbEstado']),
            );

            $betwween = array(
                'o.pago_fecha_confirmacion' => array(
                    'min'=> String::xssClean($params['txtFechaIni']),
                    'max'=> String::xssClean($params['txtFechaFin'])
                    )
            );

            
            
            $criteria = array(
                'whereLike'    => $paramsLike,
                'limit'        => LIMIT_BUSCAR,
                'where'        => $paramsWhere,
                'whereBetween' => $betwween,
                'order'        => $order
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

        if (self::TIPO_COMPROBANTE_FACTURA == $tipoComprobante) {
            $result = self::TIPO_COMPROBANTE_NAME_FACTURA;
        } elseif (self::TIPO_COMPROBANTE_BOLETA == $tipoComprobante) {
            $result = self::TIPO_COMPROBANTE_NAME_BOLETA;
        }

        return $result;
    }

    public static function getNombreTipoDocumento($tipoDocumento)
    {
        $result = null;
        if (empty($tipoDocumento)) {
            return $result;
        }

        if (self::TIPO_DOCUMENTO_DNI == $tipoDocumento) {
            $result = self::TIPO_DOCUMENTO_NAME_DNI;
        } elseif (self::TIPO_DOCUMENTO_RUC == $tipoDocumento) {
            $result = self::TIPO_DOCUMENTO_NAME_RUC;
        }

        return $result;
    }

    
    public function getPagoEstados()
    {
        return array(
            self::ESTADO_PAGO_NAME_NUEVO => self::ESTADO_PAGO_NAME_NUEVO,
            self::ESTADO_PAGO_NAME_PAGADO    => self::ESTADO_PAGO_NAME_PAGADO,
            self::ESTADO_PAGO_NAME_ERROR     => self::ESTADO_PAGO_NAME_ERROR,
            self::ESTADO_PAGO_NAME_EXPIRADO  => self::ESTADO_PAGO_NAME_EXPIRADO,
            self::ESTADO_PAGO_NAME_EXTORNADO  => self::ESTADO_PAGO_NAME_EXTORNADO
        );
    }

    public function getEstados()
    {
        return array(
            self::ESTADO_NAME_NUEVO => self::ESTADO_NAME_NUEVO,
            self::ESTADO_NAME_PROCESADO     => self::ESTADO_NAME_PROCESADO,
            self::ESTADO_NAME_ERROR   => self::ESTADO_NAME_ERROR,
        );
    }

    public function getTipoComprobante()
    {
        return array(
            self::TIPO_COMPROBANTE_BOLETA  => self::TIPO_COMPROBANTE_NAME_BOLETA,
            self::TIPO_COMPROBANTE_FACTURA => self::TIPO_COMPROBANTE_NAME_FACTURA
        );
    }

    public function getMetodoPago()
    {
        return array(
            self::METODO_PAGO_NAME_VISA   => self::METODO_PAGO_NAME_VISA,
            self::METODO_PAGO_NAME_PE     => self::METODO_PAGO_NAME_PE,
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
            'email'              => 'Correo',
            'codigo'             => 'Codigo Transaccion',
            'comprobante_numero' => 'Nro. Comprobante',
            'pago_referencia'    => 'Cód. Pago',
            'fac_razon_social'   => 'R. Social',
            'nombres'            => 'Nombres'
        );
    }
}