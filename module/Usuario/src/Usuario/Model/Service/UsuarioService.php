<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use \Common\Helpers\String;


class UsuarioService
{
    const DI_DNI       = 1;
    const DI_PASAPORTE = 2;
    
    protected $_repository = null;
    protected $_sl         = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
    }

    public function getDocumentoIdentidadTipo()
    {
        return array(
            self::DI_DNI       => 'DNI',
            self::DI_PASAPORTE => 'Pasaporte',
        );
    }

    public function registrarEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->newMember($data);
    }
    
    public function traerDeTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->getMember($data);
    }
    
    public function activarEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->activateMember($data);
    }
    
    public function usuarioEnTrueFi($data)
    {
        return array();
    }

    public function asociarTarjeta($data)
    {
        $usuario = $this->_repository->findOne(array('where' => array('id' => $data['usuario_id'])));
        $result = array(
            'success' => false,
            'message' => 'Error al asociar la tarjeta.',
        );
        if (!empty($usuario)) {
            $dataServ = array(
                'MGUID' => $usuario['mguid'],
                'Card' => $data['numero'],
            );
            $res = $this->_getTrueFiTarjetaService()->addCard($dataServ);
            if ($res['success']) {
                $card = $res['result'];
                $save = $this->_getTarjetaService()->getRepository()->save(array(
                    'usuario_id' => $data['usuario_id'],
                    'nombre' => $data['nombre'],
                    'cguid' => $card['cguid'],
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'estado_truefi' => $card['status'],
                ));
                if (!empty($save)) {
                    $result['success'] = true;
                    $result['message'] = null;
                }
            } else {
                $result['message'] = $res['message'];
            }
        }
        return $result;
    }

    public function syncTarjetasCliente($usuarioId, $mguid)
    {
        $result = $this->traerDeTrueFi(array('MGUID' => $mguid));
        if ($result['success']) {
            $cards = $result['result']['cards'];
            if (!empty($cards)) {
                $repositoryTar = $this->_getTarjetaService()->getRepository();
                foreach ($cards as $card) {
                    $row = $repositoryTar->findOne(array(
                        'where' => array('usuario_id' => $usuarioId, 'cguid' => $card['cguid'])
                    ));
                    if (!empty($row)) {
                        $repositoryTar->save(array(
                            'estado_truefi' => $card['status'],
                            'fecha_edicion' => date('Y-m-d H:i:s'),
                        ), $row['id']);
                    } else {
                        $repositoryTar->save(array(
                            'usuario_id' => $usuarioId,
                            'numero' => $card['number'],
                            'cguid' => $card['cguid'],
                            'fecha_creacion' => date('Y-m-d H:i:s'),
                            'estado_truefi' => $card['status'],
                        ));
                    }
                }
                return true;
            }
        }
        
        return false;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
    
    private function _getTrueFiUsuarioService()
    {
        return $this->_sl->get('TrueFi\Model\Service\UsuarioService');
    }
    
    private function _getTrueFiTarjetaService()
    {
        return $this->_sl->get('TrueFi\Model\Service\TarjetaService');
    }
    
    private function _getTarjetaService()
    {
        return $this->_sl->get('Tarjeta\Model\Service\TarjetaService');
    }

    public function getDataCriteria($params)
    {
        $criteria = array(
            'whereLike' => null,
            'limit'     => null,
            'where'     => null
        );

        if (!empty($params)) {
            $nameFilter = String::xssClean($params['cmbFiltro']);

            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                'di_tipo'  => String::xssClean($params['cmbTipoDoc']),
                'estado'   => String::xssClean($params['cmbEstado']),
                'cod_pais' => String::xssClean($params['cmbPais']),
                'cod_depa' => String::xssClean($params['cmbDepartamento']),
                'cod_prov' => String::xssClean($params['cmbProvincia']),
                'cod_dist' => String::xssClean($params['cmbDistrito']),
            );

            $criteria = array(
                'whereLike' => $paramsLike,
                'limit'     => LIMIT_BUSCAR,
                'where'     => $paramsWhere
            );
        }

        return $criteria;
    }

}