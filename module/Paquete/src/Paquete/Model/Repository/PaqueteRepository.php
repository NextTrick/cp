<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Model\Repository;

use Zend\Db\Adapter\Adapter;

class PaqueteRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'paquete_paquete';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
