<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Tarjeta\Model\Repository;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class TarjetaRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'tarjeta_tarjeta';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }

    public function getTarjetasByIds($tarjetaIds)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select();
        $select->from(array('a' => $this->table));
        $select->columns(array('*'));
        $select->where->in('a.id', $tarjetaIds);

        $statement = $sql->prepareStatementForSqlObject($select);
        $data = $this->resultSetPrototype->initialize($statement->execute())->toArray();

        return $data;
    }

    public function getParaSyncByIdTiempo($cguid, $restarTiempo, $validarFechaActualizacion = true)
    {
        $fecha = date('Y-m-d H:i:s', $restarTiempo);
        $sql = new Sql($this->getAdapter());

        $select = $sql->select();
        $select->from(array('a' => $this->table));
        $select->columns(array('*'));

        if ($validarFechaActualizacion) {
            $select->where->nest()->isNull('fecha_actualizacion')
                ->orPredicate(new \Zend\Db\Sql\Predicate\Expression("fecha_actualizacion < ?", $fecha))
                ->unnest();
        }

        $select->where->equalTo('cguid', $cguid);

        //echo $sql->getSqlStringForSqlObject($select); exit;

        $statement = $sql->prepareStatementForSqlObject($select);
        $data = $this->resultSetPrototype->initialize($statement->execute())->toArray();

        if (!empty($data)) {
            return $data[0];
        }

        return array();
    }
}
