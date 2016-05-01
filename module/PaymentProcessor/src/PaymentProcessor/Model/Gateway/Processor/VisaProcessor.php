<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\Visa;
use Orden\Model\Repository\OrdenRepository;

class VisaProcessor extends AbstractProcessor
{
    const ALIAS = 'VISA';
            
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['visa'];
        
        $environment = $config['app']['environment'];
        
        $this->ws = new Visa($wsConfig, $environment);
    }
    
    public function createCharge($data) 
    {        
        $return = array(
            'success' => true,            
        );
           
        try {                                              
            $paymentResponse = $this->ws->createEticket($data);     
                        
            $xmlDocument = new \DOMDocument();
            if ($xmlDocument->loadXML($paymentResponse->GeneraEticketResult)) {
                $countMessages = $this->ws->cantidadMensajes($xmlDocument);
                if ($countMessages == 0) {
                    $eticket = $this->ws->recuperaEticket($xmlDocument);
                    $html = $this->ws->htmlRedirecFormEticket($eticket);                    
                    $return['data'] = array(
                        'status' => OrdenRepository::PAGO_ESTADO_PENDIENTE,
                        'token' => null,
                        'clientReference' => null,
                        'reference' => $eticket,
                        'html' => $html,
                    );                    
                } else {
                    $return['success'] = false;
                    $return['error']['message'] = $this->getErrorMessage($xmlDocument, $countMessages);                    
                }
            } else {
                $return['success'] = false;
                $return['error']['message'] = 'Error loading Xml';                
            }
                        
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['error']['message'] = $e->getMessage();
            $return['error']['detail'] = $e->getTraceAsString();
        }
                
        return $return;
    }
    
    public function processCallback($data)
    {
        $return = array(
            'success' => true,            
        );
           
        try {                                              
            $paymentResponse = $this->ws->retrieveEticket($data);     
                        
            $xmlDocument = new \DOMDocument();
            if ($xmlDocument->loadXML($paymentResponse->ConsultaEticketResult)) {
                $countMessages = $this->ws->cantidadMensajes($xmlDocument);
                if ($countMessages == 0) {
                    $eTicket = $data['reference'];
                    $countOperaciones = $this->ws->cantidadOperaciones($xmlDocument, $eTicket);
                                        
                    for ($iNumOperacion = 0; $iNumOperacion < $countOperaciones; $iNumOperacion++) {                        
                        $sNumOperacion = $iNumOperacion + 1;                        
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "respuesta");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "estado");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "cod_tienda");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "nordent");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "cod_accion");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "pan");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "nombre_th");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "ori_tarjeta");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "eci");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "dsc_eci");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "cod_autoriza");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "cod_rescvv2");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "id_unico");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "imp_autorizado");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_tx");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_deposito");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_devolucion");
                        $this->recuperaCampos($xmlDoc, $sNumOperacion, "dato_comercio");			
                    }
                                                           
                    $eticket = $this->ws->recuperaEticket($xmlDocument);
                    $html = $this->ws->htmlRedirecFormEticket($eticket);                    
                    $return['data'] = array(
                        'status' => OrdenRepository::PAGO_ESTADO_PENDIENTE,
                        'token' => null,
                        'clientReference' => null,
                        'reference' => $eticket,
                        'html' => $html,
                    );                    
                } else {
                    $return['success'] = false;
                    $return['error']['message'] = $this->getErrorMessage($xmlDocument, $countMessages);                    
                }
            } else {
                $return['success'] = false;
                $return['error']['message'] = 'Error loading Xml';                
            }
                        
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['error']['message'] = $e->getMessage();
            $return['error']['detail'] = $e->getTraceAsString();
        }
                
        return $return;
    }        
    
    protected function getErrorMessage($xmlDocument, $countMessages)
    {
        $returnArray = array();
        for ($iNumMensaje = 0; $iNumMensaje < $countMessages; $iNumMensaje++){            
            $returnArray[] = $this->ws->recuperaMensaje($xmlDocument, $iNumMensaje + 1);                
        }
        
        return implode('=', $returnArray);
    }
}