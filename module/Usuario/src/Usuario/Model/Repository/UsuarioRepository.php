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

    const ELIMINADO_TRUEFI_SI = 1;
    const ELIMINADO_TRUEFI_NO = 0;
    
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
            $selectInterno->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $selectInterno->from(array('u'=>'usuario_usuario'));
            $selectInterno->columns(array(
                'id', 'mguid','email', 'estado', 'nombres', 'paterno', 'materno', 'di_tipo', 'di_valor', 'fecha_creacion', 'fecha_nac',
                'codigo_activar'
            ));
            $selectInterno->join(array('u1' => 'sistema_ubigeo'), 'u1.id = u.pais_id',
                array('pais_id' => 'id', 'nombrePais' => 'nombre'), 'left');
            $selectInterno->join(array('u2' => 'sistema_ubigeo'), 'u2.id = u.departamento_id',
                array('departamento_id' => 'id', 'nombreDepa' => 'nombre'), 'left');
            $selectInterno->join(array('u3' => 'sistema_ubigeo'), 'u3.id = u.provincia_id',
                array('provincia_id' => 'id', 'nombreProv' => 'nombre'), 'left');
            $selectInterno->join(array('u4' => 'sistema_ubigeo'), 'u4.id = u.distrito_id',
                array('distrito_id' => 'id', 'nombreDist' => 'nombre'), 'left');

            $selectInterno->where->notEqualTo('eliminado_truefi', self::ELIMINADO_TRUEFI_SI);

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
                }
                if (!empty($value['max']) && !empty($key)) {
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
            //echo $selectMain->getSqlString($this->getAdapter()->getPlatform());exit;
            $statement = $sql->prepareStatementForSqlObject($selectMain);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();

            return $rows;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getUsuarioByEmail($email)
    {
        $criteria = array(
            'where' => array('email' => $email, 'estado' => 1),
            'columns' => array('id', 'email', 'mguid', 'nombres', 'paterno', 'materno', 'imagen')
        );
        return $this->findOne($criteria);
    }

    public function getById($id)
    {
        $criteria = array(
            'where' => array('id' => $id, 'estado' => 1),
        );
        
        return $this->findOne($criteria);
    }
}
