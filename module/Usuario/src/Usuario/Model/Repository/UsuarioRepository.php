<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Repository;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class UsuarioRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'usuario_usuario';
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

            $selectPais = $sql->select();
            $selectPais->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $selectPais->from(array('upais' => 'sistema_ubigeo'));
            $selectPais->columns(array('cod_pais', 'nombrePais' => "nombre"));
            $selectPais->where(array('cod_depa' => '00', 'cod_prov' => '00', 'cod_dist' => '00' ));

            $selectDepa = $sql->select();
            $selectDepa->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $selectDepa->from(array('udepa' => 'sistema_ubigeo'));
            $selectDepa->columns(array('cod_pais','cod_depa',  'nombreDepa' => "nombre"));
            $selectDepa->where(array('cod_prov' => '00', 'cod_dist' => '00' ));

            $selectProv = $sql->select();
            $selectProv->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $selectProv->from(array('uprov' => 'sistema_ubigeo'));
            $selectProv->columns(array('cod_pais','cod_depa', 'cod_prov', 'nombreProv' => "nombre"));
            $selectProv->where(array('cod_dist' => '00' ));

            $selectDist = $sql->select();
            $selectDist->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $selectDist->from(array('udist' => 'sistema_ubigeo'));
            $selectDist->columns(array('cod_pais','cod_depa', 'cod_prov', 'cod_dist', 'nombreDist' => "nombre"));

            $selectInterno = $sql->select();
            $selectInterno->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $selectInterno->from(array('u'=>'usuario_usuario'));
            $selectInterno->columns(array(
                'id', 'mguid','email', 'estado', 'nombres', 'paterno', 'materno', 'di_tipo', 'di_valor', 'fecha_creacion', 'fecha_nac',
                'codigo_activar'
            ));
            $selectInterno->join(array('u1' => $selectPais), 'u1.cod_pais = u.cod_pais',
                array('cod_pais', 'nombrePais'), 'left');
            $selectInterno->join(array('u2' => $selectDepa), 'u2.cod_pais = u.cod_pais and u2.cod_depa = u.cod_depa',
                array('cod_depa', 'nombreDepa'), 'left');
            $selectInterno->join(array('u3' => $selectProv), 'u3.cod_pais = u.cod_pais and u3.cod_depa = u.cod_depa and u3.cod_prov = u.cod_prov',
                array('cod_prov', 'nombreProv'), 'left');
            $selectInterno->join(array('u4' => $selectDist), 'u4.cod_pais = u.cod_pais and u4.cod_depa = u.cod_depa and u4.cod_prov = u.cod_prov and u4.cod_dist = u.cod_dist',
                array('cod_dist', 'nombreDist'), 'left');

            $selectMain = $sql->select();
            $selectMain->from(array('u'=>$selectInterno));

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
            
            $selectMain->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);

            if (!empty($this->crOrder)) {
                $selectMain->order($this->crOrder);
            }

            if (!empty($this->crLimit)) {
                $selectMain->limit($this->crLimit);
            }
            //cho $selectMain->getSqlString($this->getAdapter()->getPlatform());exit;

            $statement = $sql->prepareStatementForSqlObject($selectMain);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();

            return $rows;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
