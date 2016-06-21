<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Model\Service;

use \Common\Helpers\String;

class DetalleOrdenService
{
    protected $_repository = null;
    protected $_sl         = null;

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
        $order = array('id DESC', 'fecha_creacion DESC');

        $criteria = array(
            "whereLike"    => null,
            "limit"        => null,
            "where"        => null,
            "whereBetween" => null,
            'order'        => $order
        );

        if (!empty($params)) {
            $nameFilter            = String::xssClean($params['cmbFiltro']);
            $params['txtFechaFin'] = (!empty($params['txtFechaFin']))? $params['txtFechaFin']." 23:59:59" : null;

            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                "pago_estado" => String::xssClean($params['cmbPagoEstado']),
                "estado" => String::xssClean($params['cmbEstado'])
            );

            $betwween = array(
                "fecha_creacion" => array(
                    "min" => String::xssClean($params['txtFechaIni']),
                    "max" => String::xssClean($params['txtFechaFin'])
                )
            );
            
            $criteria = array(
                "whereLike"    => $paramsLike,
                //"limit"        => LIMIT_BUSCAR,
                "where"        => $paramsWhere,
                "whereBetween" => $betwween,
                'order'        => $order
            );
        }

        return $criteria;
    }

    /**
     * Retorna un array que se utilizar en la busqueda de usuario
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function getFiltrosBuscar()
    {
        return array(
            'codigo' => 'Codigo Transaccion',
            'email'  => 'Correo',
            'numero' => 'Tarjeta'
        );
    }

}