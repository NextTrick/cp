<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Repository;

use Zend\Db\Adapter\Adapter;

class OrdenRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'orden_orden';
    
    protected $cache;
    
    const PAGO_ESTADO_PENDIENTE = 'PENDIENTE';
    const PAGO_ESTADO_PAGADO = 'PAGADO';
    const PAGO_ESTADO_ERROR = 'ERROR';
    const PAGO_ESTADO_EXPIRADO = 'EXPIRADO';
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
