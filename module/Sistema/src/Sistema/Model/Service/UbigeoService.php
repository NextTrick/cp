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
    const COD_DEPA_CALLAO = '07';
    const COD_PROV_CALLAO = '01';
    
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
        $data = $this->getCodPais($paisId);
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $data->cod_pais);
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
    
    public function getProvincias($departamentoId)
    {
        $data = $this->getCodDepartamento($departamentoId);
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $data->cod_pais);
        $where->equalTo('cod_depa', $data->cod_depa);
        $where->notEqualTo('cod_prov', '00');
        $where->equalTo('cod_dist', '00');

        $criteria = array(
            'where'   => $where,
            'columns' => array('id', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getDistritos($provinciaId)
    {
        $data = $this->getCodProvincia($provinciaId);
        
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', $data->cod_pais);
        $where->equalTo('cod_depa', $data->cod_depa);
        $where->equalTo('cod_prov', $data->cod_prov);
        $where->notEqualTo('cod_dist', '00');
        
        $criteria = array(
            'where'   => $where,
            'columns' => array('id', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }
    
    public function getSoloDistritosLimaYCallao()
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', self::COD_PAIS_PERU);
        $where->in('cod_depa', array(self::COD_DEPA_LIMA, self::COD_DEPA_CALLAO));
        $where->in('cod_prov', array(self::COD_PROV_LIMA, self::COD_PROV_CALLAO));
        $where->notEqualTo('cod_dist', '00');

        $criteria = array(
            'where'   => $where,
            'columns' => array('id', 'nombre'),
            'order'   => array('nombre ASC'),
        );
        return $this->getRepository()->findPairs($criteria);
    }

    public function getCodPais($paisId)
    {
        $result = new \stdClass();
        $result->cod_pais = null;
        $data = $this->_repository->findOne(array('where' => array('id' => $paisId)));
        if (isset($data['cod_pais'])) {
            $result->cod_pais = $data['cod_pais'];
        }
        
        return $result;
    }
    
    public function getCodDepartamento($departamentoId)
    {
        $result = new \stdClass();
        $result->cod_pais = null;
        $result->cod_depa = null;
        $data = $this->_repository->findOne(array('where' => array('id' => $departamentoId)));
        if (isset($data['cod_depa'])) {
            $result->cod_pais = $data['cod_pais'];
            $result->cod_depa = $data['cod_depa'];
        }
        
        return $result;
    }

    public function getCodProvincia($provinciaId)
    {
        $result = new \stdClass();
        $result->cod_pais = null;
        $result->cod_depa = null;
        $result->cod_prov = null;
        $data = $this->_repository->findOne(array('where' => array('id' => $provinciaId)));
        if (isset($data['cod_prov'])) {
            $result->cod_pais = $data['cod_pais'];
            $result->cod_depa = $data['cod_depa'];
            $result->cod_prov = $data['cod_prov'];
        }
        
        return $result;
    }

    public function getCodDistrito($distritoId)
    {
        $result = new \stdClass();
        $result->cod_pais = null;
        $result->cod_depa = null;
        $result->cod_prov = null;
        $result->cod_dist = null;
        $data = $this->_repository->findOne(array('where' => array('id' => $distritoId)));
        if (isset($data['cod_dist'])) {
            $result->cod_pais = $data['cod_pais'];
            $result->cod_depa = $data['cod_depa'];
            $result->cod_prov = $data['cod_prov'];
            $result->cod_dist = $data['cod_dist'];
        }
        
        return $result;
    }
    
    public function getPePaisId()
    {
        $criteria = array('where' => array(
            'cod_pais' => \Sistema\Model\Service\UbigeoService::COD_PAIS_PERU,
            'cod_depa' => '00',
            'cod_prov' => '00',
            'cod_dist' => '00',
        ));
        $row = $this->getRepository()->findOne($criteria);
        
        return isset($row['id']) ? $row['id'] : null;
    }

    public function getPeDepartamentos()
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('cod_pais', self::COD_PAIS_PERU);
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
    
    public function getRepository()
    {
        return $this->_repository;
    }
}