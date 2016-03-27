<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo;
use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo\Solicitud;

class PagoEfectivoProcessor extends AbstractProcessor
{
    const ALIAS = 'PE';
    
    public $ws;
    
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
            $paymentRequest = $this->ws->solicitarPago($xml);                    
            
            $return['data'] = array(
                'status' => $paymentRequest->Estado,
                'token' => $paymentRequest->Token,
                'clientReference' => $paymentRequest->NumeroOrdenPago,
                'reference' => $paymentRequest->CodTrans,
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
        if (!empty($params['data']) && !empty($params['version']) 
            && $params['version'] == 2) {
            
            $data = $params['data'];
            //desencriptar la data y darle formato
            $solData = simplexml_load_string($this->ws->desencriptarData($data));

            //ID Transaccion para guardarla en la BD
            $idPayment = $solData->CodTrans;
            //Según el estado de la solicitud  Procesar	
            Switch ($solData->Estado) {
                case 592: // 
                    echo 'Estado: pendiente de pago';
                    //o bien registrarlo en un log
                    $pagoefectivo->addRowFileLog(__DIR__ . '/log/cip.txt', $solData->CIP->NumeroOrdenPago . ':GENERADO');
                    break;

                case 593: //Cip Pagado
                    $pagoefectivo->addRowFileLog(__DIR__ . '/log/cip.txt', $solData->CIP->NumeroOrdenPago . ':PAGADO');
                    echo 'Estado: Generado';
                    break;

                case 595://Cip Vencido
                    $pagoefectivo->addRowFileLog(__DIR__ . '/log/cip.txt', $solData->CIP->NumeroOrdenPago . ':VENCIDO');
                    echo 'Estado: Vencido';
                    break;

                default: echo 'Estado: ERROR';
                    return;
            }
        }
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
                    'EmailComercio' => $data['mailAdmin'],
                    'FechaAExpirar' => $expirationDate,
                    'UsuarioId' => '001',
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