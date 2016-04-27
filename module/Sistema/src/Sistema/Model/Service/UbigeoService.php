<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Sistema\Model\Service;

class UbigeoService
{
    protected $_repository = null;
    protected $_sl         = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
    }

    public function getPaises()
    {
        $criteria = array(
            'where' => array(
                'cod_depa' => '00',
                'cod_prov' => '00',
                'cod_dist' => '00',
            ),
            'columns' => array('cod_pais', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getDepartamentos($codPais)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $codPais);
        $where->notEqualTo('cod_depa', '00');
        $where->equalTo('cod_prov', '00');
        $where->equalTo('cod_dist', '00');
        
        $criteria = array(
            'where'   => $where,
            'columns' => array('cod_depa', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getProvincias($codPais, $codDepartamento)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $codPais);
        $where->equalTo('cod_depa', $codDepartamento);
        $where->notEqualTo('cod_prov', '00');
        $where->equalTo('cod_dist', '00');

        $criteria = array(
            'where'   => $where,
            'columns' => array('cod_prov', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getDistritos($codPais, $codDepartamento, $codProvincia = null)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $codPais);
        $where->equalTo('cod_depa', $codDepartamento);
        
        if (!empty($codProvincia)) {
            $where->equalTo('cod_prov', $codProvincia);
        } else {
            $where->notEqualTo('cod_prov', '00');
        }
        
        $criteria = array(
            'where'   => $where,
            'columns' => array('cod_dist', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}