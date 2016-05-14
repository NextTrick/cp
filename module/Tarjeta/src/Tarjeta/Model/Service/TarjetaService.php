<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Tarjeta\Model\Service;

class TarjetaService
{
    protected $_repository = null;
    protected $_sl = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function misTarjetas($usuarioId)
    {
        $criteria = array(
            'where' => array(
                'usuario_id' => $usuarioId,
            ),
            'order' => array('fecha_creacion DESC'),
            'limit' => LIMIT_USUARIO_TARJETAS,
        );
        $rows = $this->_repository->findAll($criteria);
        $results = \Common\Helpers\Util::formatoMisTarjeas($rows);
        
        return $results;
    }
    
    public function getTarjetas($usuarioId)
    {
        $criteria = array(
            'where' => array(
                'usuario_id' => $usuarioId,
            ),
            'columns' => array('id', 'nombre'),
            'order' => array('id DESC'),
        );
        
        $results = array();
        $rows = $this->_repository->findPairs($criteria);
        foreach ($rows as $id => $nombre) {
            $codigo = \Common\Helpers\Crypto::encrypt($id, \Common\Helpers\Util::VI_ENCODEID);
            $results[$codigo] = $nombre;
        }
        
        return $results;
    }
    
    public function getRepository()
    {
        return $this->_repository;
    }
}