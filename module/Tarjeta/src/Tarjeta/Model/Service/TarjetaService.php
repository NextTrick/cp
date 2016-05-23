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
    
    public function getOnlineTarjeta($cguid)
    {
        $result = array(
            'emoney' => 'S/. 0.00',
            'emoneyvalue' => 0,
            'bonus' => 'S/. 0.00',
            'bonusvalue' => 0,
            'bonusplus' => 'S/. 0.00',
            'bonusplusvalue' => 0,
            'gamepoints' => 0,
            'gamepointsvalue' => 0,
            'etickets' => 0,
        );
        $data = $this->_getTrueFiTarjetaService()->getCard(array('CGUID' => $cguid));
        if ($data['success']) {
            $data = $data['result'];
            if (!empty($data)) {
                $result = array(
                    'emoney' => $data['emoney'],
                    'emoneyvalue' => $data['emoneyvalue'],
                    'bonus' => $data['bonus'],
                    'bonusvalue' => $data['bonusvalue'],
                    'bonusplus' => $data['promotionbonus'], //se esta modificando el indice por el nombre correcto
                    'bonusplusvalue' => $data['bonusplusvalue'],
                    'gamepoints' => $data['gamepoints'],
                    'gamepointsvalue' => $data['gamepointsvalue'],
                    'etickets' => $data['etickets'],
                );
            }
        }
        return $result;
    }

    public function getDdlTarjetas($usuarioId)
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
    
    public function cronMisTarjetas($usuarioId = null)
    {
        $criteria = array(
            'where' => array(
                
            ),
        );
        $usuarios = $this->_getUsuarioService()->findAll($criteria);
        
        $criteria1 = array(
            'where' => array(
                'usuario_id' => $usuarioId,
            ),
            'order' => array('fecha_creacion DESC'),
            'limit' => LIMIT_USUARIO_TARJETAS,
        );
        $rows = $this->_repository->findAll($criteria1);
        foreach ($rows as $key => $row) {
            $row[$key] = $this->getOnlineTarjeta($row['cguid']);
        }
        $results = \Common\Helpers\Util::formatoMisTarjeas($rows);
        
        return $results;
    }
    
    public function getRepository()
    {
        return $this->_repository;
    }
    
    private function _getTrueFiTarjetaService()
    {
        return $this->_sl->get('TrueFi\Model\Service\TarjetaService');
    }
    
    private function _getUsuarioService()
    {
        return $this->_sl->get('Usuario\Model\Service\UsuarioService');
    }
}