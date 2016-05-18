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
    const DI_DNI            = 1;
    const DI_PASAPORTE      = 2;
    const DI_NAME_DNI       = 'DNI';
    const DI_NAME_PASAPORTE = 'Pasaporte';

    const ESTADO_BAJA        = 0;
    const ESTADO_ACTIVO      = 1;
    const ESTADO_NAME_BAJA   = 'Inactivo';
    const ESTADO_NAME_ACTIVO = 'Activo';
    
    protected $_repository = null;
    protected $_sl         = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
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
    
    public function recoverPasswordEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->recoverPassword($data);
    }
    
    public function logonEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->logon($data);
    }
    
    public function registrarUsuarioDeTrueFi($mguid, $email, $password)
    {
        $result = $this->_getTrueFiUsuarioService()->getMember(array('MGUID' => $mguid));
        if ($result['success']) {
            
        }
        return null;
    }

    private function _testAsociarTarjeta($data)
    {
        $usuario = $this->_repository->findOne(array('where' => array('id' => $data['usuario_id'])));
        $result = array(
            'success' => false,
            'message' => 'Error al asociar la tarjeta.',
        );
        if (!empty($usuario)) {
            $tarjeta = $this->_getTarjetaService()->getRepository()
                    ->findOne(array('where' => array('numero' => $data['numero'])));
            if (!empty($tarjeta)) {
                return array(
                    'success' => false,
                    'message' => 'La tarjeta pertenece a otro cliente',
                );
            }
            
            $cardsTest = array(
                '000-102079-1' => '{584FA19C-9D70-45FD-8A89-6B6F64E3118C}',
                '003-034796-5' => '{584FA19C-9D72-45TY-8A89-6B6F6GS5129C}',
                '000-123456-3' => '{584FA19C-9D74-45ZS-8A89-6BHU64E8173C}',
            );
            $cards = array_keys($cardsTest);
            if (in_array($data['numero'], $cards)) {
                $save = $this->_getTarjetaService()->getRepository()->save(array(
                    'numero' => $data['numero'],
                    'usuario_id' => $data['usuario_id'],
                    'nombre' => $data['nombre'],
                    'cguid' => $cardsTest[$data['numero']],
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'estado_truefi' => 1,
                ));
                if (!empty($save)) {
                    $result['success'] = true;
                    $result['message'] = null;
                }
            }
        }
        
        return $result;
    }
    
    public function asociarTarjeta($data)
    {
        if (defined('TEST_MOCK') && TEST_MOCK == 1) {
            return $this->_testAsociarTarjeta($data);
        }
        
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
                    'numero' => $data['numero'],
                    'usuario_id' => $data['usuario_id'],
                    'nombre' => $data['nombre'],
                    'cguid' => $card['cguid'],
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                ));
                if (!empty($save)) {
                    $result['success'] = true;
                    $result['message'] = null;
                }
            } else {
                $result['message'] = $res['message'];
            }
            
            //sincronizar tarjetas registrados por otro sistema
            $this->syncTarjetasCliente($usuario['id'], $usuario['mguid']);
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

            $betwween = array(
                'fecha_creacion' => array(
                    'min'=> String::xssClean($params['txtFechaIni']),
                    'max'=> String::xssClean($params['txtFechaFin'])
                )
            );

            $criteria = array(
                'whereLike'    => $paramsLike,
                'limit'        => LIMIT_BUSCAR,
                'where'        => $paramsWhere,
                'whereBetween' => $betwween
            );

        }

        return $criteria;
    }

    public function getEstados()
    {
        return array(
            self::ESTADO_BAJA   => self::ESTADO_NAME_BAJA,
            self::ESTADO_ACTIVO => self::ESTADO_NAME_ACTIVO,
        );
    }

    public function getDocumentoIdentidadTipo()
    {
        return array(
            self::DI_DNI       => self::DI_NAME_DNI,
            self::DI_PASAPORTE => self::DI_NAME_PASAPORTE,
        );
    }

    public static function getNombreTipoDocumento($tipoDocumento)
    {
        $result = null;
        if (empty($tipoDocumento)) {
            return $result;
        }

        if (self::DI_DNI == $tipoDocumento) {
            $result = self::DI_NAME_DNI;
        } elseif (self::DI_PASAPORTE == $tipoDocumento) {
            $result = self::DI_NAME_PASAPORTE;
        }

        return $result;
    }


    public static function getNombreEstado($estado)
    {
        $result = null;
        if (!isset($estado)) {
            return $result;
        }

        if (self::ESTADO_ACTIVO == $estado) {
            $result = self::ESTADO_NAME_ACTIVO;
        } elseif (self::ESTADO_BAJA == $estado) {
            $result = self::ESTADO_NAME_BAJA;
        }

        return $result;
    }

    /**
     * Retorna un array que se utilizar en la busqueda de usuario
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function getFiltrosBuscar()
    {
        return array(
            'di_valor' => 'Nro. Documento',
            'email'    => 'Correo',
            'nombres'  => 'Nombre',
            'paterno'  => 'A. Paterno',
            'materno'  => 'A. Materno',
        );
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
}