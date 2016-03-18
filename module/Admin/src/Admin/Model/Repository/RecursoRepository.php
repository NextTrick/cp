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

class RecursoRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'admin_recurso';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
    
    public function findSidebarMenus($rolId)
    {
        try {
            $cClomuns = array(
                'id',
                'recurso_id',
                'nombre',
                'url',
                'orden',
                'icono',
            );
            $sql = new Sql($this->getAdapter());
            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('a' => 'admin_permiso'));
            $select->columns(array());
            $select->join(array('c' => 'admin_recurso'), 'a.recurso_id = c.id', $cClomuns, 'left');
            $select->where(array('a.rol_id' => $rolId));
            
            $statement = $sql->prepareStatementForSqlObject($select);
            $rows = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $rows;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
