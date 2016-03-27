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
        $xml = $this->getSolicitud($data);        
        
        //Creación de la solicitud
        $paymentRequest = $this->ws->solicitarPago($xml);
        
        //Obtención del valor del Cip
        echo 'CIP: '. $paymentRequest->NumeroOrdenPago; exit;
    }        
    
    public function getSolicitud($data)
    {
        $options = $this->ws->getOptions();
        
        $expiationDate = date('d/m/Y H:i:s');
        
        $solicitud = new Solicitud();                        
        $solicitud->addContenido(array(
                'IdMoneda' => 1,
                'Total' => $data['monto'],
                    'MetodosPago' => $options['medioPago'],
                    'CodServicio' => $options['apiKey'],
                    'Codtransaccion' => $data['id'],
                    'EmailComercio' => $data['mailAdmin'],
                    'FechaAExpirar' => $expiationDate,
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