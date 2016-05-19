<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo;
use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo\Solicitud;
use Orden\Model\Repository\OrdenRepository;
use Util\Model\Service\ErrorService;

class PagoEfectivoProcessor extends AbstractProcessor
{
    const ALIAS = 'PE';    
    
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['pagoEfectivo'];
        $this->wsConfig = $wsConfig;
                                
        $this->ws = new PagoEfectivo($wsConfig);
    }
    
    public function createCharge($data) 
    {
        $return = array(
            'success' => true,            
        );
        
        //Creación de la solicitud        
        $xml = $this->getSolicitud($data);
                        
        try {            
            //Obtención del valor del Cip                                    
            $paymentResponse = $this->ws->solicitarPago($xml);
            $estado = (string) $paymentResponse->Estado;
            if ($estado == '1') {
                $return['data'] = array(
                    'status' => OrdenRepository::PAGO_ESTADO_PENDIENTE,
                    'token' => (string) $paymentResponse->Token,
                    'cip' => (string) $paymentResponse->CIP->NumeroOrdenPago,
                    'reference' => (string) $paymentResponse->CIP->IdOrdenPago,
                    'clientReference' => (string) $paymentResponse->CodTrans,
                    'redirect' => $this->wsConfig['baseUrl'] . $this->wsConfig['wsgenpago'] . '?token='
                        . (string) $paymentResponse->Token
                );
            } else {
                $return['success'] = false;
                $return['error']['code'] = 900;
                $return['error']['message'] = (string) $paymentResponse->Mensaje;
            }
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['error']['code'] = ErrorService::GENERAL_CODE;
            $return['error']['message'] = $e->getMessage();
            $return['error']['detail'] = $e->getTraceAsString();
        }

        $requestHistorialData = array(
            'ordenId' => $data['id'],
            'method' => self::METHOD_CREATECHARGE,
            'reference' => !empty($return['data']['reference']) ? $return['data']['reference'] : null,
        );

        $this->saveResquestHistorial($requestHistorialData);
                
        return $return; 
    }
    
    public function processCallback($params)
    {        
        $return = array(
            'success' => true,            
        );

        $cDate = date('Y-m-d H:i:s');
        
        if (!empty($params['data']) && !empty($params['version']) 
            && $params['version'] == 2) {
            
            $data = $params['data'];
            
            try {
                //desencriptar la data y darle formato
                $solData = simplexml_load_string($this->ws->desencriptarData($data));

                $return['data']['clientReference'] = $solData->CodTrans;
                //Según el estado de la solicitud  Procesar
                Switch ($solData->Estado) {
                    case 592:                        
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PENDIENTE;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                        break;
                    case 593: //Cip Pagado
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PAGADO;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                        break;
                    case 595://Cip Vencido
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_EXPIRADO;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                    default:
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_ERROR;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                }
                $return['data']['confirmationDate'] = $cDate;
                
            } catch (\Exception $e) {
                $return['success'] = false;
                $return['error']['code'] = ErrorService::GENERAL_CODE;
                $return['error']['message'] = $e->getMessage();
                $return['error']['detail'] = $e->getTraceAsString();
            }
        } else {
            $return['success'] = false;
            $return['error']['code'] = ErrorService::GENERAL_CODE;
            $return['error']['message'] = ErrorService::GENERAL_MESSAGE;
        }

        $requestHistorialData = array(
            'method' => self::METHOD_PROCESSCALLBACK,
            'reference' => !empty($return['data']['reference']) ? $return['data']['reference'] : null,
        );

        $this->saveResquestHistorial($requestHistorialData);
        
        return $return;
    }
    
    public function getSolicitud($data)
    {
        $options = $this->ws->getOptions();
        $expirationDays = $this->wsConfig['cipExpiracionDias'];

        $cDate = date('Y-m-d H:i:s');
        $expirationDate = date('d/m/Y H:i:s', strtotime($cDate. " + $expirationDays days"));
        
        $solicitud = new Solicitud();                        
        $solicitud->addContenido(array(
                'IdMoneda' => 1,
                'Total' => $data['monto'],
                    'MetodosPago' => $options['medioPago'],
                    'CodServicio' => $options['apiKey'],
                    'Codtransaccion' => $data['id'],
                    'EmailComercio' => $options['mailAdmin'],
                    'FechaAExpirar' => $expirationDate,
                    'UsuarioId' => $data['usuario_id'],
                    'DataAdicional' => '',
                    'UsuarioNombre' => $data['perfilpago_nombres'],
                    'UsuarioApellidos' => $data['perfilpago_paterno'] . ' ' . $data['perfilpago_materno'],
                    'UsuarioLocalidad' => 'LIMA',
                    'UsuarioProvincia' => 'LIMA',
                    'UsuarioPais' => 'PERU',
                    'UsuarioAlias' => $data['perfilpago_nombres'],
                    'UsuarioTipoDoc' => $data['documento_tipo'],
                    'UsuarioNumeroDoc' => $data['documento_numero'],
                    'UsuarioEmail' => $data['usuario_email'],
                    'ConceptoPago' => 'Pago',
            ));
        
        $solicitud->addDetalle(
            array(array(
                'Cod_Origen' => 'CT',
                'TipoOrigen' => 'TO',
                'ConceptoPago' => $this->wsConfig['conceptoPago'],
                'Importe' => $data['monto'])
            ));
        
        return $solicitud;        
    }
}