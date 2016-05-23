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

class DetalleOrdenRepository extends  \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'orden_detalle_orden';
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

            $selectInterno = $sql->select();
            $selectInterno->from(array("od"=> "orden_detalle_orden"));
            $selectInterno->columns(array('id', 'monto', 'cantidad', 'fecha_creacion', 'emoney', 'bonus', 'gamepoints',
                 'etickets', 'promotionbonus', 'recarga_cantidad', 'recarga_error'
            ));
            $selectInterno->join(array("p" => "paquete_paquete"), "p.id = od.paquete_id",
                array("titulo1", 'titulo2', 'tipo'), 'left');
            $selectInterno->join(array("o" => "orden_orden"), "o.id = od.orden_id",
                array("pago_estado", 'codigo'), 'inner');
            $selectInterno->join(array("u" => "usuario_usuario"), "u.id = o.usuario_id",
                array("email"), 'left');
            $selectInterno->join(array("t" => "tarjeta_tarjeta"), "t.id = od.tarjeta_id",
                array("numero"), 'left');

            $select = $sql->select();
            $select->from(array("r" => $selectInterno));
            $select->columns(array('id', 'monto', 'cantidad', 'fecha_creacion', 'emoney', 'bonus', 'gamepoints',
                    'etickets', 'promotionbonus', 'recarga_cantidad', 'recarga_error', "titulo1", 'titulo2', 'tipo',
                    "pago_estado", 'codigo', "email", "numero"
                )
            );

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
            //echo $select->getSqlString($this->getAdapter()->getPlatform());

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();
            
            return $rows;

        } catch (\Exception $e) {
            echo 'ERROR='.$e->getMessage();exit;
            throw new \Exception($e->getMessage());
        }
    }
}
