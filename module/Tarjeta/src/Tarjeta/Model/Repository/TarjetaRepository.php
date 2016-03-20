<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Tarjeta\Model\Repository;

use Zend\Db\Adapter\Adapter;

class TarjetaRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'tarjeta_tarjeta';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
