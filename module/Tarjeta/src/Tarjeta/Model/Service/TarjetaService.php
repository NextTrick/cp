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
    protected $_restarTiempo;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
        $this->_restarTiempo = strtotime('-60 minute');
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

    public function getRestarTiempo()
    {
        return $this->_restarTiempo;
    }

    public function cronTarjetas($cguid = null, $validarFechaActualizacion = true)
    {
        if (empty($cguid)) {
            $fecha = date('Y-m-d H:i:s', $this->_restarTiempo);
            $where = new \Zend\Db\Sql\Where();

            if ($validarFechaActualizacion) {
                $where->equalTo('sincronizar', 1);
                $where->isNotNull('fecha_actualizacion');
                $where->addPredicate(new \Zend\Db\Sql\Predicate\Expression("fecha_actualizacion < ?", $fecha));
            }

            $criteria = array(
                'where' => $where,
                'order' => array('fecha_actualizacion DESC'),
                'limit' => 50,
            );
            $rows = $this->_repository->findAll($criteria);
            foreach ($rows as $row) {
                try {
                    $this->_cronTarjetas($row['id'], $row['cguid']);
                } catch (\Exception $e) {
                    \Common\Helpers\Error::initialize()->logException($e);
                }
            }
        } else {

            $row = $this->getRepository()->getParaSyncByIdTiempo($cguid, $this->_restarTiempo, $validarFechaActualizacion);
            if (!empty($row)) {
                try {
                    $this->_cronTarjetas($row['id'], $row['cguid']);
                } catch (\Exception $e) {
                    \Common\Helpers\Error::initialize()->logException($e);
                }
            }
        }
        
    }
    
    public function _cronTarjetas($tarjetaId, $cguid)
    {
        $data = $this->_getTrueFiTarjetaService()->getCard(array('CGUID' => $cguid));
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
                    'fecha_actualizacion' => date('Y-m-d H:i:s'),
                );

                $this->_repository->save($dataIn, $tarjetaId);
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
}