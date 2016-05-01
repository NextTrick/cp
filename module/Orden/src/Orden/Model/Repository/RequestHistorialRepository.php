<?php

namespace Orden\Model\Repository;

use Zend\Db\Adapter\Adapter;

class RequestHistorialRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{        
    protected $cache;
            
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
