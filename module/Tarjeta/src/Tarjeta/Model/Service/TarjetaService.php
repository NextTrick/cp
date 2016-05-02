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
            'order' => 'fecha_creacion DESC',
            'limit' => LIMIT_USUARIO_TARJETAS,
        );
        $rows = $this->_repository->findAll($criteria);
        
        foreach ($rows as $key => $row) {
            $row['show'] = 1;
            $rows[$key] = $row;
        }

        $factor = 2;
        $totalRows = count($rows);
        if (!empty($rows)) {
            $factor1 = (int)($totalRows/3);
            if ((float)($totalRows/3) > (int)($totalRows/3)) {
                $factor1 = (int)($totalRows/3) + 1;
            }
            $factor = ($factor1 > 2) ? $factor1 : $factor; 
        }
        $totalViews = $factor * 3; //total a mostrar en html
        
        $diferencia = $totalViews - $totalRows;
        if ($diferencia > 0) {
            $rows[] = array('show' => 2);
            $diferencia = $diferencia - 1;
        }
        
        if ($diferencia > 0) {
            for ($i = 0; $i < $diferencia; $i++) {
                $rows[] = array('show' => 3);
            }
        }
        
        return $rows;
    }
    
    public function getRepository()
    {
        return $this->_repository;
    }
}