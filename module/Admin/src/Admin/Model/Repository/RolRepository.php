<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Model\Repository;

use Zend\Db\Adapter\Adapter;

class RolRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'admin_rol';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
    
    public function existsChildren($id)
    {
        try {
            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('a' => 'admin_rol'));
            $select->columns(array('id'));
            $select->join(array('b' => 'admin_usuario'), 'b.rol_id = a.id', array('usuario_id' => 'id'), 'left');
            $select->join(array('c' => 'admin_permiso'), 'c.role_id = a.id', array('permiso_id' => 'id'), 'left');
            $select->where(array('a.id' => $id));

            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = new \Zend\Db\ResultSet\ResultSet();
            $row = $resultSet->initialize($statement->execute())->current();

            if (!empty($row['usuario_id']) || !empty($row['permiso_id'])) {
                return true;
            }
        } catch (\Exception $e) {
            \Common\Helpers\Error::initialize()->logException($e);
        }
                
        return false;
    }
}
