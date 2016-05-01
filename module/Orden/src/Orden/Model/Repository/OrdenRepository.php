<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Repository;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class OrdenRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'orden_orden';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }

    public function search($criteria)
    {
        $this->setCriteria($criteria);
        try {
            $sql= new Sql($this->getAdapter());

            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('o'=> $this->table));
            $select->columns(array('id', 'usuario_id', 'pago_tarjeta','monto', 'fecha_creacion','fac_ruc', 'fac_direccion_fiscal',
                'pago_estado', 'comprobante_tipo', 'comprobante_numero', 'fac_razon_social', 'nombres', 'pago_referencia',
                'doc_identidad', 'estado'
            ));
            $select->join(array('u' => 'usuario_usuario'), 'u.id = o.usuario_id',
                array('id', 'email'), 'inner');

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

}
