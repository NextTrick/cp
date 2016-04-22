<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Common\Model\Repository;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Cache\Storage\StorageInterface;

class Zf2AbstractTableGateway extends AbstractTableGateway
{
    protected $table;
    protected $cache;
    
    protected $crWhere = array();
    protected $crWhereLike = array();
    protected $crColumns = array('*');
    protected $crOrder = array();
    protected $crLimit = array();
    protected $crOffset = array();


    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
    }
    
    public function setCache(StorageInterface $cache)
    {
        $this->cache = $cache;
    }
    
    public function clearCriteria()
    {
        $this->crWhere = array();
        $this->crWhereLike = array();
        $this->crColumns = array('*');
        $this->crOrder = array();
        $this->crLimit = array();
        $this->crOffset = array();
    }

    public function setCriteria($criteria)
    {
        $this->clearCriteria();
        if (isset($criteria['where'])) {
            if (is_array($criteria['where']) || $criteria['where'] instanceof \Zend\Db\Sql\Where) {
                $this->crWhere = $criteria['where'];
            }
        }
        if (isset($criteria['whereLike'])) {
            if (is_array($criteria['whereLike'])) {
                $this->crWhereLike = $criteria['whereLike'];
            }
        }
        if (isset($criteria['columns']) && is_array($criteria['columns'])) {
            $this->crColumns = $criteria['columns'];
        }
        if (isset($criteria['order']) && is_array($criteria['order'])) {
            $this->crOrder = $criteria['order'];
        }
        if (isset($criteria['limit'])) {
            $this->crLimit = $criteria['limit'];
        }
        if (isset($criteria['offset'])) {
            $this->crOffset = $criteria['offset'];
        }
    }

    public function findAll($criteria = array())
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            if (!empty($this->crColumns)) {
                $select->columns($this->crColumns);
            }
            
            if (!empty($this->crWhere)) {
                $select->where($this->crWhere);
            }

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
    
    public function search($criteria)
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            if (!empty($this->crColumns)) {
                $select->columns($this->crColumns);
            }
            
            $where = array();
            if ($this->crWhere instanceof \Zend\Db\Sql\Where) {
                $where = $this->crWhere;
            } else {
                $where = new \Zend\Db\Sql\Where();

                foreach ($this->crWhere as $key => $value) {
                    if (!empty($value) && !empty($key)) {
                        $where->or->equalTo($key, $value) ;
                    }
                }

                foreach ($this->crWhereLike as $key => $value) {
                    if (!empty($value) && !empty($key)) {
                        $where->or->like($key, "%$value%") ;
                    }
                }
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
    
    public function countTotal($criteria)
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            $select->columns(array('num_rows' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            
            $where = array();
            if ($this->crWhere instanceof \Zend\Db\Sql\Where) {
                $where = $this->crWhere;
            } else {
                $where = new \Zend\Db\Sql\Where();

                foreach ($this->crWhere as $key => $value) {
                    if (!empty($value) && !empty($key)) {
                        $where->or->equalTo($key, $value) ;
                    }
                }

                foreach ($this->crWhereLike as $key => $value) {
                    if (!empty($value) && !empty($key)) {
                        $where->or->like($key, "%$value%") ;
                    }
                }
            }
            
            $select->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);

            $statement = $sql->prepareStatementForSqlObject($select);
            $row = $this->resultSetPrototype->initialize($statement->execute())
                ->current();

            return isset($row['num_rows']) ? (int) $row['num_rows'] : 0;
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function findOne($criteria)
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            if (!empty($this->crColumns)) {
                $select->columns($this->crColumns);
            }
            
            if (!empty($this->crWhere)) {
                $select->where($this->crWhere);
            }
                        
            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }

            $statement = $sql->prepareStatementForSqlObject($select);
            $row = $this->resultSetPrototype->initialize($statement->execute())
                ->current();
            return $row;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function findAssoc($criteria = array())
    {       
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            if (!empty($this->crColumns)) {
                $select->columns($this->crColumns);
            }
            
            if (!empty($this->crWhere)) {
                $select->where($this->crWhere);
            }
            
            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }
            
            if (!empty($this->crLimit)) {
                $select->limit($this->crLimit);
            }

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();

            $results = array();
            foreach ($rows as $row) {
                $tmp = array_values(array_slice($row, 0, 1));
                $results[$tmp[0]] = $row;
            }
            return $results;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findCol($criteria = array())
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            if (!empty($this->crColumns)) {
                $select->columns($this->crColumns);
            }
            
            if (!empty($this->crWhere)) {
                $select->where($this->crWhere);
            }
            
            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }
            
            if (!empty($this->crLimit)) {
                $select->limit($this->crLimit);
            }

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();

            $results = array();
            foreach ($rows as $row) {
                $tmp = array_values(array_slice($row, 0, 1));
                $results[] = $tmp[0];
            }
            return $results;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function findExists($criteria = array())
    {
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            $select->columns(array('num_rows' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            
            if (!empty($this->crWhere)) {
                $select->where($this->crWhere);
            }

            $statement = $sql->prepareStatementForSqlObject($select);
            $row = $this->resultSetPrototype->initialize($statement->execute())
                ->current();

            $numRows = isset($row['num_rows']) ? (int) $row['num_rows'] : 0;
            if ($numRows > 0) {
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function findPairs($criteria = array())
    {       
        $this->setCriteria($criteria);
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array('a' => $this->table));
            if (!empty($this->crColumns)) {
                $select->columns($this->crColumns);
            }
            
            if (!empty($this->crWhere)) {
                $select->where($this->crWhere);
            }
            
            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }
            
            if (!empty($this->crLimit)) {
                $select->limit($this->crLimit);
            }

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();

            $results = array();
            foreach ($rows as $row) {
                $tmp = array_values(array_slice($row, 0, 2));
                $results[$tmp[0]] = $tmp[1];
            }
            return $results;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function save($data, $id = null)
    {
        try {
            if (empty($id)) {
                $this->insert($data);
                return $this->getLastInsertValue();
            } else {
                $id = (int)$id;
                $this->update($data, array('id' => $id));
                return $id;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getPaginatorForSelect($select, $page, $limit = 20, $pageRange = 10)
    {
        try {
            $resulset = new \Zend\Db\ResultSet\ResultSet();
            $resulset->buffer();
            $paginatorAdapter = new DbSelect($select, $this->getAdapter(), $resulset);
            $paginator = new Paginator($paginatorAdapter);

            $paginator->setItemCountPerPage($limit);
            $paginator->setPageRange($pageRange);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}