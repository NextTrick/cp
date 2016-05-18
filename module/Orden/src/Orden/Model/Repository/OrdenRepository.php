<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Repository;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class OrdenRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'orden_orden';
    
    protected $cache;
    
    const PAGO_ESTADO_PENDIENTE = 'PENDIENTE';
    const PAGO_ESTADO_PAGADO    = 'PAGADO';
    const PAGO_ESTADO_ERROR     = 'ERROR';
    const PAGO_ESTADO_EXPIRADO  = 'EXPIRADO';
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }

    public function search($criteria)
    {
        $this->setCriteria($criteria);
        try {
            $sql= new Sql($this->getAdapter());

            $select = $sql->select();
            $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
            $select->from(array('o'=> $this->table));
            $select->columns(array('id', 'usuario_id', 'pago_tarjeta','monto', 'fecha_creacion','documento_numero', 'documento_tipo',
                'fac_direccion_fiscal', 'pago_estado', 'comprobante_tipo', 'comprobante_numero', 'fac_razon_social',
                'nombres', 'pago_referencia', 'estado', 'pago_error', 'pago_error_detalle'
            ));
            $select->join(array('u' => 'usuario_usuario'), 'u.id = o.usuario_id',
                array('id', 'email'), 'inner');

            $where = new \Zend\Db\Sql\Where();
            foreach ($this->crWhere as $key => $value) {
                if (!empty($value) && !empty($key) || $value === '0') {
                    $where->AND->equalTo($key, $value) ;
                }
            }

            foreach ($this->crWhereLike as $key => $value) {
                if (!empty($value) && !empty($key)) {
                    $where->and->like($key, "%$value%") ;
                }
            }

            foreach ($this->crWhereBetween as $key => $value) {
                if (!empty($value['min']) && !empty($key)) {
                    $where->and->greaterThanOrEqualTo($key, $value['min']) ;
                } elseif (!empty($value['max']) && !empty($key)) {
                    $where->and->lessThanOrEqualTo($key, $value['max']) ;
                }
            }

            $select->where($where, \Zend\Db\Sql\Predicate\PredicateSet::OP_OR);

            if (!empty($this->crOrder)) {
                $select->order($this->crOrder);
            }

            if (!empty($this->crLimit)) {
                $select->limit($this->crLimit);
            }
            //echo $select->getSqlString($this->getAdapter()->getPlatform());exit;

            $statement = $sql->prepareStatementForSqlObject($select);
            $rows      = $this->resultSetPrototype->initialize($statement->execute())->toArray();

            return $rows;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getIdByPagoReference($pagoReferencia)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('pago_referencia', $pagoReferencia);

        $criteria = array(
            'where'   => $where,
            'columns' => array('id')
        );

        return $this->findOne($criteria);
    }

    public static function getErrorMessages()
    {
       return array(
            101 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta Vencida.',
                    'clientMessage' => 'Operación Denegada. Tarjeta Vencida. Verifique los datos en su tarjeta e ingréselos correctamente.'
                ),
            102 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con la entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            104 => array(
                    'commerceMessage' => 'Operación Denegada. Operación no permitida para esta tarjeta.',
                    'clientMessage' => 'Operación Denegada. Operación no permitida para esta tarjeta. Contactar con la entidad emisora de su tarjeta.'
                ),

            106 => array(
                    'commerceMessage' => 'Operación Denegada. Exceso de intentos de ingreso de clave secreta.',
                    'clientMessage' => 'Operación Denegada. Intentos de clave secreta excedidos. Contactar con la entidad emisora de su tarjeta.'
                ),
            107 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con la entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con la entidad emisora de su tarjeta.'
                ),
            108 => array(
                    'commerceMessage' => 'Operación Denegada. Exceso de actividad.',
                    'clientMessage' => 'Operación Denegada. Contactar con la entidad emisora de su tarjeta.'
                ),
            109 => array(
                    'commerceMessage' => 'Operación Denegada. Identificación inválida de establecimiento.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            110 => array(
                    'commerceMessage' => 'Operación Denegada. Operación no permitida para esta tarjeta.',
                    'clientMessage' => 'Operación Denegada. Operación no permitida para esta tarjeta. Contactar con la entidad emisora de su tarjeta.'
                ),
            111 => array(
                    'commerceMessage' => 'Operación Denegada. El monto de la transacción supera el valor máximo permitido para operaciones virtuales',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            112 => array(
                    'commerceMessage' => 'Operación Denegada. Se requiere clave secreta.',
                    'clientMessage' => 'Operación Denegada. Se requiere clave secreta.'
                ),
            116 => array(
                    'commerceMessage' => 'Operación Denegada. Fondos insuficientes.',
                    'clientMessage' => 'Operación Denegada. Fondos insuficientes. Contactar con entidad emisora de su tarjeta'
                ),
            117 => array(
                    'commerceMessage' => 'Operación Denegada. Clave secreta incorrecta.',
                    'clientMessage' => 'Operación Denegada. Clave secreta incorrecta.'
                ),
            118 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta inválida.',
                    'clientMessage' => 'Operación Denegada. Tarjeta Inválida. Contactar con entidad emisora de su tarjeta.'
                ),
            119 => array(
                    'commerceMessage' => 'Operación Denegada. Exceso de intentos de ingreso de clave secreta.',
                    'clientMessage' => 'Operación Denegada. Intentos de clave secreta excedidos. Contactar con entidad emisora de su tarjeta.'
                ),
            121 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            126 => array(
                    'commerceMessage' => 'Operación Denegada. Clave secreta inválida.',
                    'clientMessage' => 'Operación Denegada. Clave secreta inválida.'
                ),
            129 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta no operativa.',
                    'clientMessage' => 'Operación Denegada. Código de seguridad invalido. Contactar con entidad emisora de su tarjeta'
                ),
            180 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta inválida.',
                    'clientMessage' => 'Operación Denegada. Tarjeta Inválida. Contactar con entidad emisora de su tarjeta.'
                ),
            181 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta con restricciones de Débito.',
                    'clientMessage' => 'Operación Denegada. Tarjeta con restricciones de débito. Contactar con entidad emisora de su tarjeta.'
                ),
            182 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta con restricciones de Crédito.',
                    'clientMessage' => 'Operación Denegada. Tarjeta con restricciones de crédito. Contactar con entidad emisora de su tarjeta.'
                ),
            183 => array(
                    'commerceMessage' => 'Operación Denegada. Error de sistema.',
                    'clientMessage' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'
                ),
            190 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            191 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            192 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            199 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            201 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta vencida.',
                    'clientMessage' => 'Operación Denegada. Tarjeta vencida. Contactar con entidad emisora de su tarjeta.'
                ),
            202 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            204 => array(
                    'commerceMessage' => 'Operación Denegada. Operación no permitida para esta tarjeta.',
                    'clientMessage' => 'Operación Denegada. Operación no permitida para esta tarjeta. Contactar con entidad emisora de su tarjeta.'
                ),
            206 => array(
                    'commerceMessage' => 'Operación Denegada. Exceso de intentos de ingreso de clave secreta.',
                    'clientMessage' => 'Operación Denegada. Intentos de clave secreta excedidos. Contactar con la entidad emisora de su tarjeta.'
                ),
            207 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            208 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta perdida.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            209 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta perdida.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            263 => array(
                    'commerceMessage' => 'Operación Denegada. Error en el envío de parámetros.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            264 => array(
                    'commerceMessage' => 'Operación Denegada. Entidad emisora no está disponible para realizar la autenticación.',
                    'clientMessage' => 'Operación Denegada. Entidad emisora de la tarjeta no está disponible para realizar la autenticación.'
                ),
            265 => array(
                    'commerceMessage' => 'Operación Denegada. Clave secreta del tarjetahabiente incorrecta.',
                    'clientMessage' => 'Operación Denegada. Clave secreta del tarjetahabiente incorrecta. Contactar con entidad emisora de su tarjeta.'
                ),
            266 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta vencida.',
                    'clientMessage' => 'Operación Denegada. Tarjeta Vencida. Contactar con entidad emisora de su tarjeta.'
                ),
            280 => array(
                    'commerceMessage' => 'Operación Denegada. Clave errónea.',
                    'clientMessage' => 'Operación Denegada. Clave secreta errónea. Contactar con entidad emisora de su tarjeta.'
                ),
            290 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            300 => array(
                    'commerceMessage' => 'Operación Denegada. Número de pedido del comercio duplicado. Favor no atender.',
                    'clientMessage' => 'Operación Denegada. Número de pedido del comercio duplicado. Favor no atender.'
                ),
            306 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            401 => array(
                    'commerceMessage' => 'Operación Denegada. Tienda inhabilitada.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            402 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            403 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta no autenticada',
                    'clientMessage' => 'Operación Denegada. Tarjeta no autenticada.'
                ),
            404 => array(
                    'commerceMessage' => 'Operación Denegada. El monto de la transacción supera el valor máximo permitido.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            405 => array(
                    'commerceMessage' => 'Operación Denegada. La tarjeta ha superado la cantidad máxima de transacciones en el día.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.',
                ),
            406 => array(
                    'commerceMessage' => 'Operación Denegada. La tienda ha superado la cantidad máxima de transacciones en el día.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            407 => array(
                    'commerceMessage' => 'Operación Denegada. El monto de la transacción no llega al mínimo permitido.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            408 => array(
                    'commerceMessage' => 'Operación Denegada. CVV2 no coincide.',
                    'clientMessage' => 'Operación Denegada. Código de seguridad no coincide. Contactar con entidad emisora de su tarjeta'
                ),
            409 => array(
                    'commerceMessage' => 'Operación Denegada. CVV2 no procesado por entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Código de seguridad no procesado por la entidad emisora de la tarjeta'
                ),
            410 => array(
                    'commerceMessage' => 'Operación Denegada. CVV2 no procesado por no ingresado.',
                    'clientMessage' => 'Operación Denegada. Código de seguridad no ingresado.'
                ),
            411 => array(
                    'commerceMessage' => 'Operación Denegada. CVV2 no procesado por entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Código de seguridad no procesado por la entidad emisora de la tarjeta'
                ),
            412 => array(
                    'commerceMessage' => 'Operación Denegada. CVV2 no reconocido por entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Código de seguridad no reconocido por la entidad emisora de la tarjeta'
                ),
            413 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'peración Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            414 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            415 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            416 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            417 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            418 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'                    
                ),
            419 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            420 => array(
                    'commerceMessage' => 'Operación Denegada. Tarjeta no es VISA.',
                    'clientMessage' => 'Operación Denegada. Tarjeta no es VISA.'
                ),
            421 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada. Contactar con entidad emisora de su tarjeta.'
                ),
            422 => array(
                    'commerceMessage' => 'Operación Denegada. El comercio no está configurado para usar este medio de pago.',
                    'clientMessage' => 'Operación Denegada. El comercio no está configurado para usar este medio de pago. Contactar con el comercio.'
                ),
            423 => array(
                    'commerceMessage' => 'Operación Denegada. Se canceló el proceso de pago.',
                    'clientMessage' => 'Operación Denegada. Se canceló el proceso de pago.'
                ),
            424 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            666 => array(
                    'commerceMessage' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.',
                    'clientMessage' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'
                ),
            667 => array(
                    'commerceMessage' => 'Operación Denegada. Transacción sin autenticación. Inicio del Proceso de Pago',
                    'clientMessage' => 'Operación Denegada. Transacción sin respuesta de Verified by Visa.'
                ),
            668 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            669 => array(
                    'commerceMessage' => 'Operación Denegada. Módulo antifraude.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            670 => array(
                    'commerceMessage' => 'Operación Denegada. Módulo antifraude.',
                    'clientMessage' => 'Operación Denegada. Contactar con el comercio.'
                ),
            904 => array(
                    'commerceMessage' => 'Operación Denegada. Formato de mensaje erróneo.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            909 => array(
                    'commerceMessage' => 'Operación Denegada. Error de sistema.',
                    'clientMessage' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'
                ),
            910 => array(
                    'commerceMessage' => 'Operación Denegada. Error de sistema.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            912 => array(
                    'commerceMessage' => 'Operación Denegada. Entidad emisora no disponible.',
                    'clientMessage' => 'Operación Denegada. Entidad emisora de la tarjeta no disponible'
                ),
            913 => array(
                    'commerceMessage' => 'Operación Denegada. Transmisión duplicada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            916 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            928 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            940 => array(
                    'commerceMessage' => 'Operación Denegada. Transacción anulada previamente.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            941 => array(
                    'commerceMessage' => 'Operación Denegada. Transacción ya anulada previamente.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            942 => array(
                    'commerceMessage' => 'Operación Denegada.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            943 => array(
                    'commerceMessage' => 'Operación Denegada. Datos originales distintos.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            945 => array(
                    'commerceMessage' => 'Operación Denegada. Referencia repetida.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            946 => array(
                    'commerceMessage' => 'Operación Denegada. Operación de anulación en proceso.',
                    'clientMessage' => 'Operación Denegada. Operación de anulación en proceso.'
                ),
            947 => array(
                    'commerceMessage' => 'Operación Denegada. Comunicación duplicada.',
                    'clientMessage' => 'Operación Denegada. Problemas de comunicación. Intente más tarde.'
                ),
            948 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            949 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada.'
                ),
            965 => array(
                    'commerceMessage' => 'Operación Denegada. Contactar con entidad emisora.',
                    'clientMessage' => 'Operación Denegada.'
                ),
        );
    }
}
