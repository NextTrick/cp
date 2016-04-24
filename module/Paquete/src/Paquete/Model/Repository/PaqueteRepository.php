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
    
    public function findByReferencia($referencias)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->in('referencia', $referencias);
        $criteria = array(
            'where' => $where,
            'columns' => array('referencia', 'id')
        );
        return $this->findPairs($criteria);
    }
    
    public function findAllGrid()
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('status', 1);
        $criteria = array(
            'where' => $where,
        );
        return $this->findAll($criteria);
    }
}
