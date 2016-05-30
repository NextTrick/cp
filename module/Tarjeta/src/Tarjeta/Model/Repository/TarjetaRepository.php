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
        $sql= new Sql($this->getAdapter());

        $select = $sql->select();
        $select->from(array('a' => $this->table));
        $select->columns(array('*'));
        $select->where->in('a.id', $tarjetaIds);

        $statement = $sql->prepareStatementForSqlObject($select);
        $data = $this->resultSetPrototype->initialize($statement->execute())->toArray();

        return $data;
    }
}
