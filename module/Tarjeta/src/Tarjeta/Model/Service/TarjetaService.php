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
            'promotionbonus' => 'S/. 0.00',
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
                    'promotionbonus' => $data['promotionbonus'], //promotionbonus <equivalente> bonusplusvalue
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
        if (!empty($usuarioId)) {
            $this->_cronMisTarjetas($usuarioId);
        } else {
            $criteria = array(
                'where' => array(

                ),
                'limit' => '10'
            );
            $usuarios = $this->_getUsuarioService()->findAll($criteria);
            
            foreach ($usuarios as $row) {
                $this->_cronMisTarjetas($row['id']);
            }
        }
    }
    
    private function _cronMisTarjetas($usuarioId)
    {
        $criteria1 = array(
            'where' => array(
                'usuario_id' => $usuarioId,
            ),
            'order' => array('fecha_creacion DESC')
        );
        $rows = $this->_repository->findAll($criteria1);
        foreach ($rows as $row) {
            if (empty($row['cguid'])) {
                continue;
            }
            
            $data = $this->_getTrueFiTarjetaService()->getCard(array('CGUID' => $row['cguid']));
            if ($data['success']) {
                $data = $data['result'];
                /*$result = array(
                    'emoney' => 'S/. 0.00',
                    'emoneyvalue' => 0,
                    'bonus' => 'S/. 0.00',
                    'bonusvalue' => 0,
                    'promotionbonus' => 'S/. 0.00',
                    'bonusplusvalue' => 0,
                    'gamepoints' => 0,
                    'gamepointsvalue' => 0,
                    'etickets' => 0,
                );*/
                if (!empty($data)) {
                    $dataIn = array(
                        'emoney' => $data['emoney'],
                        'emoneyvalue' => (float)$data['emoneyvalue'],
                        'bonus' => $data['bonus'],
                        'bonusvalue' => (float)$data['bonusvalue'],
                        'promotionbonus' => $data['promotionbonus'], //promotionbonus <equivalente> bonusplusvalue
                        'bonusplusvalue' => (float)$data['bonusplusvalue'],
                        'gamepoints' => (int)$data['gamepoints'],
                        'gamepointsvalue' => (int)$data['gamepointsvalue'],
                        'etickets' => (float)$data['etickets'],
                        'fecha_edicion' => date('Y-m-d H:i:s'),
                    );
                    
                    $this->_repository->save($dataIn, $row['id']);
                }
            }
        }
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