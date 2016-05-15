<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Model\Repository;

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

    public function search($criteria)
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());

            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('o'=> $this->table));

            $where = new \Zend\Db\Sql\Where();
            foreach ($this->crWhere as $key => $value) {
                if (!empty($value) && !empty($key) || $value === '0') {
                    $where->AND->equalTo($key, $value) ;
                }
            }

            foreach ($this->crWhereLike as $key => $value) {
                if (!empty($value) && !empty($key)) {
                    $where->and->like($key, "%$value%") ;
                }
            }

            foreach ($this->crWhereBetween as $key => $value) {
                if (!empty($value['min']) && !empty($key)) {
                    $where->and->greaterThanOrEqualTo($key, $value['min']) ;
                } elseif (!empty($value['max']) && !empty($key)) {
                    $where->and->lessThanOrEqualTo($key, $value['max']) ;
                }
            }

            $select->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);

            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }

            if (!empty($this->crLimit)) {
                $select->limit($this->crLimit);
            }
            //echo $select->getSqlString($this->getAdapter()->getPlatform());exit;

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();

            return $rows;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
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

    public function getDestacados()
    {
        try {
            $sql = new Sql($this->getAdapter());

            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('p'=> $this->table));

            $where = new \Zend\Db\Sql\Where();
            $where->AND->equalTo('tipo', 2) ;
            $where->AND->equalTo('destacado', 1) ;

            $select->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);
            $select->order('fecha_edicion DESC');

            //echo $select->getSqlString($this->getAdapter()->getPlatform());exit;

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();

            return $rows;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function darBajaDestacados($idsValidos = array())
    {
        try {
            $sql = new Sql($this->getAdapter());

            $update = $sql->update();
            $update->table($this->table);
            $update->set(array('destacado' => 0));

            $where = new \Zend\Db\Sql\Where();
            $where->AND->equalTo('tipo', 2) ;
            $where->AND->notIn('id', $idsValidos);

            $update->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);

            //echo $select->getSqlString($this->getAdapter()->getPlatform());exit;

            $statement = $sql->prepareStatementForSqlObject($update);
            $result    = $statement->execute();

            return $result;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
