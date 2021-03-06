<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use \Common\Helpers\String;
use Tarjeta\Model\Service\TarjetaService;


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
    
    public function modificarPasswordEnDb($id, $email, $password)
    {
        $dataIn1 = array(
            'password' => \Common\Helpers\Util::passwordEncrypt($password, $email)
        );
        return $this->_repository->save($dataIn1, $id);
    }
    
    public function modificarPasswordEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->changePassword($data);
    }
    
    public function actualizarEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->setMember($data);
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
    
    public function registrarUsuarioDesdeTrueFi($mguid, $password)
    {
        $result = $this->_getTrueFiUsuarioService()->getMember(array('MGUID' => $mguid));
        if ($result['success']) {
            $result = $result['result'];
            
            $password = \Common\Helpers\Util::passwordEncrypt($password, $result['email']);
            $lastName = explode(' ', $result['lastname']);
            $data = array(
                'mguid' => $mguid,
                'nombres' => $result['firstname'],
                'paterno' => isset($lastName[0]) ? $lastName[0] : $result['lastname'],
                'materno' => isset($lastName[1]) ? $lastName[1] : null,
                'email' => $result['email'],
                'password' => $password,
                'estado' => (int)$result['active'],
                'fecha_creacion' => date('Y-m-d H:i:s'),
            );

            try {
                $this->_repository->save($data);
                return true;
            } catch (\Exception $e) {
                \Common\Helpers\Error::initialize()->logException($e);
            }
        }
        return false;
    }
    
    public function actualizarUsuarioDesdeTrueFi($id)
    {
        $criteria = array('where' => array('id' => $id));
        $usuarioData = $this->_repository->findOne($criteria);
        
        if (empty($usuarioData)) {
            return false;
        }

        $result = $this->_getTrueFiUsuarioService()->getMember(array('MGUID' => $usuarioData['mguid']));
        if ($result['success']) {
            $result = $result['result'];

            $lastName = \Common\Helpers\Util::clearBlankSpaceMiddle($result['lastname'], true);
            $paterno = isset($lastName[0]) ? $lastName[0] : $result['lastname'];
            unset($lastName[0]);
            $materno = implode(' ', $lastName);
            
            $data = array(
                'mguid' => $usuarioData['mguid'],
                'nombres' => $result['firstname'],
                'paterno' => $paterno,
                'materno' => $materno,
                'email' => $result['email'],
                'estado' => (int)$result['active'],
            );
            
            if (!empty($result['birthdate'])) {
                $data['fecha_nac'] = $result['birthdate'];
            }
            if (!empty($result['idnumber'])) {
                $data['di_valor'] = $result['idnumber'];
            }

            try {
                $this->_repository->save($data, $id);
                return true;
            } catch (\Exception $e) {
                \Common\Helpers\Error::initialize()->logException($e);
            }
        }
        return false;
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
                $tarjetaId = $this->_getTarjetaService()->getRepository()->save(array(
                    'numero' => $data['numero'],
                    'usuario_id' => $data['usuario_id'],
                    'nombre' => $data['nombre'],
                    'cguid' => $card['cguid'],
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'fecha_actualizacion' => date('Y-m-d H:i:s'),
                ));
                if (!empty($tarjetaId)) {
                    $this->_getTarjetaService()->cronTarjetas($card['cguid'], false);
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
                $index = 0;
                foreach ($cards as $card) {
                    $index++;
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
                            'nombre' => 'Tarjeta ' . $index,
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
        $order    = array('id DESC', 'fecha_creacion DESC');
        $criteria = array(
            'whereLike' => null,
            'limit'     => null,
            'where'     => null,
            'order'     => $order
        );

        if (!empty($params)) {
            $params['txtFechaFin'] = (!empty($params['txtFechaFin']))? $params['txtFechaFin']." 23:59:59" : null;
            $nameFilter            = String::xssClean($params['cmbFiltro']);

            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                'di_tipo'         => String::xssClean($params['cmbTipoDoc']),
                'estado'          => String::xssClean($params['cmbEstado']),
                //'pais_id'         => String::xssClean($params['cmbPais']),
                'departamento_id' => String::xssClean($params['cmbDepartamento']),
                'provincia_id'    => String::xssClean($params['cmbProvincia']),
                'distrito_id'     => String::xssClean($params['cmbDistrito']),
            );

            $betwween = array(
                'fecha_creacion' => array(
                    'min' => String::xssClean($params['txtFechaIni']),
                    'max' => String::xssClean($params['txtFechaFin'])
                )
            );

            $criteria = array(
                'whereLike'    => $paramsLike,
                //'limit'        => LIMIT_BUSCAR,
                'where'        => $paramsWhere,
                'whereBetween' => $betwween,
                'order'        => $order
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
            //self::DI_PASAPORTE => self::DI_NAME_PASAPORTE,
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

    /**
     * @return TarjetaService
     */
    private function _getTarjetaService()
    {
        return $this->_sl->get('Tarjeta\Model\Service\TarjetaService');
    }
}