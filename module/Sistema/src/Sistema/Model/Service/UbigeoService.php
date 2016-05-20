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
    const COD_PAIS_PERU = 'PE';
    const COD_DEPA_LIMA = '15';
    const COD_PROV_LIMA = '01';
    
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
            'columns' => array('id', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getDepartamentos($paisId)
    {
        $codPais = $this->getCodPais($paisId);
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $codPais);
        $where->notEqualTo('cod_depa', '00');
        $where->equalTo('cod_prov', '00');
        $where->equalTo('cod_dist', '00');
        
        $criteria = array(
            'where'   => $where,
            'columns' => array('id', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getProvincias($paisId, $departamentoId)
    {
        $codPais = $this->getCodPais($paisId);
        $codDepartamento = $this->getCodDepartamento($departamentoId);
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
    
    public function getDistritos($codPais, $codDepartamento, $provinciaId = null)
    {
        $codPais = $this->getCodPais($codPais);
        $codDepartamento = $this->getCodDepartamento($codDepartamento);
        
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $codPais);
        $where->equalTo('cod_depa', $codDepartamento);
        
        if (!empty($provinciaId)) {
            $codProvincia = $this->getCodProvincia($provinciaId);
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

    public function getCodPais($paisId)
    {
        $data = $this->_repository->findOne(array('where' => array('id' => $paisId)));
        if (isset($data['cod_pais'])) {
            return $data['cod_pais'];
        }
        
        return null;
    }
    
    public function getCodDepartamento($departamentoId)
    {
        $data = $this->_repository->findOne(array('where' => array('id' => $departamentoId)));
        if (isset($data['cod_depa'])) {
            return $data['cod_depa'];
        }
        
        return null;
    }
    
    public function getCodDistrito($distritoId)
    {
        $data = $this->_repository->findOne(array('where' => array('id' => $distritoId)));
        if (isset($data['cod_dist'])) {
            return $data['cod_dist'];
        }
        
        return null;
    }
    
    public function getCodProvincia($provinciaId)
    {
        $data = $this->_repository->findOne(array('where' => array('id' => $provinciaId)));
        if (isset($data['cod_prov'])) {
            return $data['cod_prov'];
        }
        
        return null;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}