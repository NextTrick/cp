<?php

namespace PaymentProcessor\Model\Gateway\Processor\Ws;

use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Model\ViewModel;

class Visa
{
    protected $client;
    
    protected $wsdl;
    
    protected $environment;
    
    protected $config;

    public function __construct($config, $environment) 
    {
        $this->environment = $environment;      
        
        $this->config = $config;
    }
    
    public function createEticket($data)
    {                          
        $this->wsdl = __DIR__ . '/Visa/Wsdl/WSEticketQAS.wsdl';
        if ($this->environment == 'production') {
            $this->wsdl = __DIR__ . '/Visa/Wsdl/WSEticket.wsdl';
        }
        
        $this->client = new \SoapClient($this->wsdl, array('trace' => 1));
                
        $requestData = $this->getCreateEticketRequestData($data); 
        
        $response = $this->client->GeneraEticket($requestData);
        
        return $response;        
    }
    
    public function processResponse($response)
    {
        //Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
        $xmlDocument = new \DOMDocument();

        if ($xmlDocument->loadXML($response->GeneraEticketResult)) {
                /////////////////////////[MENSAJES]////////////////////////
                //Ejemplo para determinar la cantidad de mensajes en el XML
                $iCantMensajes= $this->cantidadMensajes($xmlDocument);
                //echo 'Cantidad de Mensajes: ' . $iCantMensajes . '<br>';

                //Ejemplo para mostrar los mensajes del XML 
                for($iNumMensaje=0;$iNumMensaje < $iCantMensajes; $iNumMensaje++){
                        echo 'Mensaje #' . ($iNumMensaje +1) . ': ';
                        echo $this->recuperaMensaje($xmlDocument, $iNumMensaje+1);
                        echo '<BR>';
                        echo "Numero de pedido: " . $numPedido;
                }
                /////////////////////////[MENSAJES]////////////////////////

                if ($iCantMensajes == 0){
                        $Eticket= $this->recuperaEticket($xmlDocument);
                        //echo 'Eticket: ' . $Eticket;

                        $html= $this->htmlRedirecFormEticket($Eticket);
                        echo $html;

                        exit;
                }

        } else {
                echo "Error cargando XML";
        }
    }
                
    //Funcion de ejemplo que obtiene la cantidad de mensajes
    public function cantidadMensajes($xmlDoc)
    {
        $cantMensajes= 0;
        $xpath = new DOMXPath($xmlDoc);
        $nodeList = $xpath->query('//mensajes', $xmlDoc);

        $XmlNode= $nodeList->item(0);

        if ($XmlNode == null) {
                $cantMensajes= 0;
        } else {
                $cantMensajes= $XmlNode->childNodes->length;
        }
        
        return $cantMensajes; 
    }
    
    //Funcion que recupera el valor de uno de los mensajes XML de respuesta
    public function recuperaMensaje($xmlDoc, $iNumMensaje)
    {
        $strReturn = "";

        $xpath = new DOMXPath($xmlDoc);
        $nodeList = $xpath->query("//mensajes/mensaje[@id='" . $iNumMensaje . "']");

        $XmlNode= $nodeList->item(0);

        if ($XmlNode == null) {
            $strReturn = "";
        } else {
            $strReturn = $XmlNode->nodeValue;
        }

        return $strReturn;
    }
        
    /**
     * Funcion que recupera el valor del Eticket
     * 
     * @param xml $xmlDoc
     * @return string
     */
    public function recuperaEticket($xmlDoc)
    {
        $strReturn = "";

        $xpath = new DOMXPath($xmlDoc);
        $nodeList = $xpath->query("//registro/campo[@id='ETICKET']");

        $XmlNode= $nodeList->item(0);

        if ($XmlNode == null) {
                $strReturn = "";
        } else {
                $strReturn = $XmlNode->nodeValue;
        }
        
        return $strReturn;
    }
    
    public function htmlRedirecFormEticket($eticket)
    {
        $formUrl = $this->config['baseUrl'] . $this->config['formularioPago'];
        $html='<Html>
        <head>
        <title>Pagina prueba Visa</title>
        </head>
        <Body onload="fm.submit();">

        <form name="fm" method="post" action="' . $formUrl . '">
            <input type="hidden" name="ETICKET" value="#ETICKET#" /><BR>
            <!--<input type="submit" name="boton" value="Pagar" /><BR>-->
        </form>
        </Body>
        </Html>';

        $html= str_replace("#ETICKET#", $eticket, $html);

        return $html;
    }
    
    public function retrieveTicket($data)
    {
        $this->wsdl = __DIR__ . '/Visa/Wsdl/WSConsultaEticketQAS.wsdl';
        if ($this->environment == 'production') {
            $this->wsdl = __DIR__ . '/Visa/Wsdl/WSConsultaEticket.wsdl';
        }        
        $this->client = new \SoapClient($this->wsdl, array('trace' => 1));
        
        $requestData = $this->getRetrieveEticketRequestData($data);         
        $response = $this->client->ConsultaEticket($requestData);
    }
    
    protected function getCreateEticketRequestData($data)
    {                
        $createEticketRequestData = array(
            'commerceCode' => $this->config['codigoComercio'],
            'id' => $data['id'],
            'amount' => $data['monto'],
            'profileName' => $data['perfilpago_nombres'],
            'profileLastName' => $data['perfilpago_paterno'] . ' ' . $data['perfilpago_materno'],
            'city' => 'LIMA',
            'address' => $data['perfilpago_direccion'],
            'userEmail' => $data['usuario_email'],            
        );
                        
        $createEticketRequestXml = $this->getViewXml('eticket.xml', $createEticketRequestData);
        
        return array('xmlIn' => $createEticketRequestXml);
    }
    
    protected function getRetrieveEticketRequestData($data)
    {
        $retrieveEticketRequestData = array(
            
        );
        
        return $retrieveEticketRequestData;
    }
    
    public function getViewXml($path, $data = array())
    {
        $resolver = new TemplatePathStack(array(
            'script_paths' => array(__DIR__ . '/Visa/Xml/')
        ));                
        
        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        $view = new ViewModel();
        $view->setTemplate($path);
                
        $view->setVariables($data);
        
        return $renderer->render($view);
    }
    
    public function getClient()
    {
        return $this->client;
    }
}