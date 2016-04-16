<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Cms\Model\Repository;

use Zend\Db\Adapter\Adapter;

class ContenidoRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'cms_contenido';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
