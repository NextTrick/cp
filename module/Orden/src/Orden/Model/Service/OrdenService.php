<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Service;

class OrdenService
{
    protected $_repository = null;
    protected $_sl = null;

    CONST TIPO_COMPROBANTE_DNI = 1;
    CONST TIPO_COMPROBANTE_RUC = 2;

    CONST METODO_PAGO_VISA   = 1;
    CONST METODO_PAGO_PE     = 2;
    CONST METODO_PAGO_MASTER = 3;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}