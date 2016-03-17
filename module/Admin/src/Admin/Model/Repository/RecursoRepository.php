<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Model\Repository;

use Zend\Db\Adapter\Adapter;

class RecursoRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'admin_recurso';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
