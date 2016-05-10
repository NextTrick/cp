<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Model\Repository;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

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
            'where'   => $where,
            'columns' => array('referencia', 'id')
        );

        return $this->findPairs($criteria);
    }

    public function getPaquetesByTipo($tipo)
    {
        try {
            $sql = new Sql($this->getAdapter());

            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('o'=> $this->table));

            $where = new \Zend\Db\Sql\Where();
            $where->AND->equalTo('tipo', $tipo) ;
            $where->AND->equalTo('activo', 1) ;

            $select->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);
            $select->order('orden ASC');

            //echo $select->getSqlString($this->getAdapter()->getPlatform());exit;

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();

            return $rows;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
