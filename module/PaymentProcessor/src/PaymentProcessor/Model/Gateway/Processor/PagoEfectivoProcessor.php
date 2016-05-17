<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo;
use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo\Solicitud;
use Orden\Model\Repository\OrdenRepository;

class PagoEfectivoProcessor extends AbstractProcessor
{
    const ALIAS = 'PE';    
    
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['pagoEfectivo'];
                                
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
                                    
            $return['data'] = array(
                'status' => (string) $paymentResponse->Estado,
                'token' => (string) $paymentResponse->Token,
                'cip' => (string) $paymentResponse->CIP->NumeroOrdenPago,
                'reference' => (string) $paymentResponse->CIP->IdOrdenPago,
                'clientReference' => (string) $paymentResponse->CodTrans,
            );
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['error']['message'] = $e->getMessage();
            $return['error']['detail'] = $e->getTraceAsString();
        }
                
        return $return; 
    }
    
    public function processCallback($params)
    {        
        $return = array(
            'success' => true,            
        );

        $cDate - date('Y-m-d H:i:s');
        
        if (!empty($params['data']) && !empty($params['version']) 
            && $params['version'] == 2) {
            
            $data = $params['data'];
            
            try {
                //desencriptar la data y darle formato
                $solData = simplexml_load_string($this->ws->desencriptarData($data));

                $return['data']['reference'] = $solData->CodTrans;
                //Según el estado de la solicitud  Procesar	
                Switch ($solData->Estado) {
                    case 592:                        
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PENDIENTE;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        break;
                    case 593: //Cip Pagado
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PAGADO;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        break;
                    case 595://Cip Vencido
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_EXPIRADO;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                    default:
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_ERROR;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                }
                $return['data']['confirmationDate'] = $cDate;
                
            } catch (\Exception $e) {
                $return['success'] = false;
                $return['error']['message'] = $e->getMessage();
                $return['error']['detail'] = $e->getTraceAsString();
            }
        }
        
        return $return;
    }
    
    public function getSolicitud($data)
    {
        $options = $this->ws->getOptions();
        
        $expirationDate = date('d/m/Y H:i:s');
        
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
                    'UsuarioTipoDoc' => $data['comprobante_tipo'],
                    'UsuarioNumeroDoc' => $data['comprobante_numero'],
                    'UsuarioEmail' => $data['usuario_email'],
                    'ConceptoPago' => 'Pago'
            ));
        
        $solicitud->addDetalle(
            array(array(
                'Cod_Origen' => 'CT',
                'TipoOrigen' => 'TO',
                'ConceptoPago' => 'Transaccion comision 1',
                'Importe' => $data['monto'])
            ));
        
        return $solicitud;        
    }
}