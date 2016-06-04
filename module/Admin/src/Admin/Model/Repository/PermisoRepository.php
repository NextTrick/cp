<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Model\Repository;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class PermisoRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'admin_permiso';
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
            $select->from(array('a' => 'admin_permiso'));
            $select->columns(array('id', 'acl'));
            $select->join(array('b' => 'admin_rol'), 'a.rol_id = b.id', array('rol_nombre' => 'nombre'), 'left');
            $select->join(array('c' => 'admin_recurso'), 'a.recurso_id = c.id', array('recurso_nombre' => 'nombre'), 'left');

            $where = new \Zend\Db\Sql\Where();
            if (!empty($this->crWhere['rol_id'])) {
                $where->and->equalTo('a.rol_id', $this->crWhere['rol_id']) ;
            }
            if (!empty($this->crWhere['recurso_id'])) {
                $where->and->equalTo('a.recurso_id', $this->crWhere['recurso_id']) ;
            }
            
            $select->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);

            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }
            
            if (!empty($this->crLimit)) {
                $select->limit($this->crLimit);
            }

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $rows;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
