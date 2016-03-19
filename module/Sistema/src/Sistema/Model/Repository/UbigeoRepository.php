<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Sistema\Model\Repository;

use Zend\Db\Adapter\Adapter;

class UbigeoRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'sistema_ubigeo';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
