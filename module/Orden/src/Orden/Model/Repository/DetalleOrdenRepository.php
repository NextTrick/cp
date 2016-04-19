<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Repository;

use Zend\Db\Adapter\Adapter;

class DetalleOrdenRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'orden_detalle_orden';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
