<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\Visa;
use Orden\Model\Repository\OrdenRepository;
use Util\Model\Service\ErrorService;

class VisaProcessor extends AbstractProcessor
{
    const ALIAS = 'VISA';
            
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['visa'];
        $this->wsConfig = $wsConfig;
        
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
                        'status' => OrdenRepository::PAGO_ESTADO_NUEVO,
                        'token' => null,
                        'clientReference' => $data['id'],
                        'reference' => $eticket,
                        'redirect' => BASE_URL . 'payment-processor/callback/visa-redirect/eticket/'
                            . base64_encode($eticket),
                    );                    
                } else {
                    $return['success'] = false;
                    $return['error']['code'] = 900;
                    $return['error']['message'] = $this->getErrorMessage($xmlDocument, $countMessages);                    
                }
            } else {
                $return['success'] = false;
                $return['error']['code'] = 901;
                $return['error']['message'] = ErrorService::GENERAL_MESSAGE; //'Error loading Xml';
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
    
    public function processCallback($data)
    {
        $return = array(
            'success' => true,            
        );
           
        try {                                              
            $paymentResponse = $this->ws->retrieveEticket($data);
            $eticket = !empty($data['eticket']) ? $data['eticket'] : null;

            $xmlDocument = new \DOMDocument();
            if ($xmlDocument->loadXML($paymentResponse->ConsultaEticketResult)) {
                $countMessages = $this->ws->cantidadMensajes($xmlDocument);
                if ($countMessages == 0) {

                    $countOperaciones = $this->ws->cantidadOperaciones($xmlDocument, $eticket);

                    $tempData = array();
                    for ($iNumOperacion = 0; $iNumOperacion < $countOperaciones; $iNumOperacion++) {                        
                        $sNumOperacion = $iNumOperacion + 1;                        
                        $tempData['respuesta'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "respuesta");
                        $tempData['estado'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "estado");
                        $tempData['cod_tienda'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "cod_tienda");
                        $tempData['nordent'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "nordent");
                        $tempData['cod_accion'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "cod_accion");
                        $tempData['pan'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "pan");
                        $tempData['nombre_th'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "nombre_th");
                        $tempData['ori_tarjeta'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "ori_tarjeta");
                        $tempData['nom_emisor'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "nom_emisor");
                        $tempData['eci'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "eci");
                        $tempData['dsc_eci'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "dsc_eci");
                        $tempData['cod_autoriza'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "cod_autoriza");
                        $tempData['cod_rescvv2'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "cod_rescvv2");
                        $tempData['id_unico'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "id_unico");
                        $tempData['imp_autorizado'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "imp_autorizado");
                        $tempData['fechayhora_tx'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "fechayhora_tx");
                        $tempData['fechayhora_deposito'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "fechayhora_deposito");
                        $tempData['fechayhora_devolucion'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "fechayhora_devolucion");
                        $tempData['dato_comercio'] = $this->ws->recuperaCampos($xmlDocument, $sNumOperacion, "dato_comercio");
                    }

                    $errorMessages = OrdenRepository::getErrorMessages();

                    if ($tempData['respuesta'] == 1) {
                        $status = OrdenRepository::PAGO_ESTADO_PAGADO;
                        $return['data'] = array(
                            'status' => $status,                                                        
                            'reference' => $eticket,
                            'clientReference' => $tempData['nordent'],
                            'pan' => $tempData['pan'],
                            'confirmationDate' => date_format(date_create_from_format("d/m/Y h:i a",$tempData['fechayhora_tx']), 'Y-m-d H:i:s'),
                            'errorCode' => null,
                            'errorDescription' => null
                        );
                    } else {
                        $status = OrdenRepository::PAGO_ESTADO_ERROR;
                        $return['data'] = array(
                            'status' => $status,
                            'reference' => $eticket,
                            'clientReference' => $tempData['nordent'],
                            'pan' => $tempData['pan'],
                            'confirmationDate' => date_format(date_create_from_format("d/m/Y h:i a",$tempData['fechayhora_tx']), 'Y-m-d H:i:s'),
                            'errorCode' => $tempData['cod_accion'],
                            'errorDescription' => !empty ($errorMessages[$tempData['cod_accion']]['clientMessage'])
                                ? $errorMessages[$tempData['cod_accion']]['commerceMessage'] : 'No se encontró mensaje de error para el código'
                        );
                    }

                } else {
                    if (!empty($eticket)) {
                        $status = OrdenRepository::PAGO_ESTADO_ERROR;
                        $return['success'] = true;
                        $return['data']['errorCode'] = 900;
                        $return['data']['errorDescription'] = $this->getErrorMessage($xmlDocument, $countMessages);
                        $return['data']['reference'] = $eticket;
                        $return['data']['status'] = $status;
                    } else {
                        $return['success'] = false;
                        $return['error']['code'] = 900;
                        $return['error']['message'] = $this->getErrorMessage($xmlDocument, $countMessages);
                    }
                }
            } else {
                if (!empty($eticket)) {
                    $return['success'] = true;
                    $return['data']['errorCode'] = 901;
                    $return['data']['errorDescription'] = ErrorService::GENERAL_MESSAGE;//'Error loading XML';
                    $return['data']['reference'] = $eticket;
                } else {
                    $return['success'] = false;
                    $return['error']['code'] = 901;
                    $return['error']['message'] = ErrorService::GENERAL_MESSAGE;//'Error loading XML';
                }
            }
        } catch (\Exception $e) {
            if (!empty($eticket)) {
                $return['success'] = true;
                $return['data']['errorCode'] = ErrorService::GENERAL_CODE;
                $return['data']['errorDescription'] = $e->getMessage();
                $return['data']['reference'] = $eticket;
            } else {
                $return['success'] = false;
                $return['error']['code'] = ErrorService::GENERAL_CODE;
                $return['error']['message'] = $e->getMessage();
                $return['error']['detail'] = $e->getTraceAsString();
            }
        }

        $requestHistorialData = array(
            'method' => self::METHOD_PROCESSCALLBACK,
            'reference' => !empty($return['data']['reference']) ? $return['data']['reference'] : null,
        );

        $this->saveResquestHistorial($requestHistorialData);
                
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