<?php
/* 
	Ejemplo de como se realiza una integración con la plataforma de pago de CE de Visanet (FORMULARIO)
	Creado por el Dpto. de Operaciones
	Fecha de creación: 05/09/2013
*/
?>
<?php
	session_start(); 
	include('lib.inc');

	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set('date.timezone', 'America/Lima'); 
	header( 'Content-Type: text/html;charset=utf-8' );
?>
<?php
$HTML = "";
	if (isset($_POST["eticket"])) {
		//print_r($_POST);
	
		//Se asigna el Eticket
		$eTicket= $_POST["eticket"];
		$codTienda = CODIGO_TIENDA;
		
		//Se arma el XML de requerimiento
		$xmlIn = "";
		$xmlIn = $xmlIn . "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$xmlIn = $xmlIn . "<consulta_eticket>";
		$xmlIn = $xmlIn . "	<parametros>";
		$xmlIn = $xmlIn . "		<parametro id=\"CODTIENDA\">";
		$xmlIn = $xmlIn . $codTienda;//Aqui se asigna el Código de tienda
		$xmlIn = $xmlIn . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"ETICKET\">";
		$xmlIn = $xmlIn . $eTicket;//Aqui se asigna el eTicket
		$xmlIn = $xmlIn . "</parametro>";
		$xmlIn = $xmlIn . "	</parametros>";
		$xmlIn = $xmlIn . "</consulta_eticket>";
		
		//Se asigna la url del servicio
		$servicio= URL_WSCONSULTAETICKET_VISA; 
		
		//Invocación al web service
		$conf=array();
		//Se habilita el parametro PROXY_ON en el archivo "lib.inc" si se maneja algun proxy para realizar conexiones externas.
		if(PROXY_ON == true){
			$conf=array('proxy_host'     => PROXY_HOST,
		                    'proxy_port'     => PROXY_PORT,
		                    'proxy_login'    => PROXY_LOGIN,
		                    'proxy_password' => PROXY_PASSWORD);
		}
		$client = new SoapClient($servicio, $conf);
		//print_r($client);
		//exit;
		
		//parametros de la llamada
		$parametros=array(); //parametros de la llamada
		$parametros['xmlIn']= $xmlIn;
		//Aqui captura la cadena de resultado
		$result = $client->ConsultaEticket($parametros);
		
		//Muestra la cadena recibida
		//echo '<br><br>Cadena de respuesta: ' . $result->ConsultaEticketResult . '<br>' . '<br>';
		
		//Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
		$xmlDocument = new DOMDocument();
		if ($xmlDocument->loadXML($result->ConsultaEticketResult)) {
		
			//Ejemplo para determinar la cantidad de operaciones 
			//asociadas al Nro. de pedido
			$iCantOpe= CantidadOperaciones($xmlDocument, $eTicket);
			$HTML= $HTML . "<span class='texto'>Cantidad de Operaciones: " . $iCantOpe . "</span><br><br>";
			
			//Ejemplo para mostrar los parଥtros de las operaciones
			//asociadas al Nro. de pedido
			for($iNumOperacion=0;$iNumOperacion < $iCantOpe; $iNumOperacion++){
				$HTML= $HTML . PresentaResultado($xmlDocument, $iNumOperacion+1);
			}
		
			//Ejemplo para determinar la cantidad de mensajes 
			//asociadas al Nro. de pedido
			$iCantMensajes= CantidadMensajes($xmlDocument);
			$HTML= $HTML . '<br><br>Cantidad de Mensajes: ' . $iCantMensajes . '<br>';
		
			//Ejemplo para mostrar los mensajes de las operaciones
			//asociadas al Nro. de pedido
			for($iNumMensaje=0;$iNumMensaje < $iCantMensajes; $iNumMensaje++){
				$HTML= $HTML . 'Mensaje #' . ($iNumMensaje +1) . ': ';
				$HTML= $HTML . RecuperaMensaje($xmlDocument, $iNumMensaje+1);
				$HTML= $HTML . '<BR>';
			}
		}else{
			$HTML= "Error";
		}
	}
?>

<?php
	//Funcion de ejemplo que obtiene la cantidad de operaciones
	function CantidadOperaciones($xmlDoc, $eTicket){
		$cantidaOpe= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//pedido[@eticket="' . $eTicket . '"]', $xmlDoc);
		
		$XmlNode= $nodeList->item(0);
		
		if($XmlNode==null){
			$cantidaOpe= 0;
		}else{
			$cantidaOpe= $XmlNode->childNodes->length;
		}
		return $cantidaOpe; 
	}
	//Funcion que recupera el valor de uno de los campos del XML de respuesta
	function RecuperaCampos($xmlDoc,$sNumOperacion,$nomCampo){
			$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//operacion[@id='" . $sNumOperacion . "']/campo[@id='" . $nomCampo . "']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
	//Funcion que muestra en pantalla los parଥtros de cada operacion
	//asociada al Nro. de pedido consultado
	function PresentaResultado($xmlDoc, $iNumOperacion){
			//ESTA FUNCION ES SOLAMENTE UN EJEMPLO DE COMO ANALIZAR LA RESPUESTA
			$sNumOperacion = "";
	
			$sNumOperacion = $iNumOperacion;
	
			$strValor = "";
			$strValor = $strValor . "<UL>";
			$strValor = $strValor . "<span class='texto'><LI> Respuesta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "respuesta") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Estado: " . RecuperaCampos($xmlDoc, $sNumOperacion, "estado") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Cod_tienda: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_tienda") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Nordent: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nordent") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Cod_accion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_accion") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Pan: " . RecuperaCampos($xmlDoc, $sNumOperacion, "pan") . "<BR>";
			$strValor = $strValor . "<span class='texto'><LI> Nombre_th: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nombre_th") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Ori_tarjeta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "ori_tarjeta") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Nom_emisor: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> ECI: " . RecuperaCampos($xmlDoc, $sNumOperacion, "eci") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Dsc_ECI: " . RecuperaCampos($xmlDoc, $sNumOperacion, "dsc_eci") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Cod_autoriza: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_autoriza") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Cod_rescvv2: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_rescvv2") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> ID_UNICO: " . RecuperaCampos($xmlDoc, $sNumOperacion, "id_unico") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Imp_autorizado: " . RecuperaCampos($xmlDoc, $sNumOperacion, "imp_autorizado") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Fechayhora_tx: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_tx") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Fechayhora_deposito: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_deposito") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Fechayhora_devolucion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_devolucion") . "</span><BR>";
			$strValor = $strValor . "<span class='texto'><LI> Dato_comercio: " . RecuperaCampos($xmlDoc, $sNumOperacion, "dato_comercio") . "</span><BR>";
			$strValor = $strValor . "</UL>";
			
			return $strValor;
	}
	//Funcion de ejemplo que obtiene la cantidad de mensajes
	function CantidadMensajes($xmlDoc){
		$cantMensajes= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//mensajes', $xmlDoc);
		
		$XmlNode= $nodeList->item(0);
		
		if($XmlNode==null){
			$cantMensajes= 0;
		}else{
			$cantMensajes= $XmlNode->childNodes->length;
		}
		return $cantMensajes; 
	}
	//Funcion que recupera el valor de uno de los mensajes XML de respuesta
	function RecuperaMensaje($xmlDoc,$iNumMensaje){
		$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//mensajes/mensaje[@id='" . $iNumMensaje . "']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<title>VisaNet - Comercio Electr&oacute;nico</title>
<style type="text/css">
body {
	background-color: #FFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/bgsite.jpg);
	background-repeat:repeat;
	background-attachment:fixed;
	background-size: 100% 100%, auto;
}
SPAN.texto {
	font-family: Calibri, Helvetica, Geneva, Arial,SunSans-Regular, sans-serif;
}
DIV.texto {
	font-family: Calibri, Helvetica, Geneva, Arial,SunSans-Regular, sans-serif;
}
</style>
</head>

<body >
	
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    	<div class="MainBox" id="MainBox" style="visibility:;" >
<!-- contenido del header -->
      <div class="Header" style="visibility:;">
				<br/><br/>
        <h1><img src="images/logo_visanet.jpg" alt="VisaNet" /></h1>
        <div id="Newsletter" style="width:88px">
            <span title="Nueva Compra" id="Btn8">
            	<img src="images/news_home.png" width="13" height="10" alt="" /><span class="texto"><a href="index.php">Registro</a></span>
            </span> 
        </div>        
      </div>
      <br><br>
<!-- fin contenido del header -->      
      
<!-- contenido del Main -->      
      <div class="MainArea" style="visibility:;">
      	<table border="0" align="center" width="1000">
      		<tr>
      			<td>
      				<?php
								echo $HTML;
							?>
      			</td>
      			<td>
      				<!-- imagen banner !-->
				      <div class="img_back" align="center"> 
				            <img src="images/GraciasPorLaCompra.jpg" alt="Gracias" border="0" /> <br>
				            <img src="images/Gracias.gif" alt="Gracias" border="0" /> 
							</div>				        
				      <!--fin imagen banner!--> 
      			</td>
      		</tr>
      		<tr>
      			<td></td>
      			<td></td>
      		</tr>
      	</table>
      	
	      
	      
				
				
	      
	  		</div>
      </div>
<!-- contenido del Main -->      
      <br/><br/>
<!-- contenido del Footer -->            
      <div class="Footer" style="visibility:;">
        <!-- contenido del footer -->
        <h4><img src="images/mas_personas_van_con_visa_es.gif" alt="M&aacute;s personas van con ViSA" width="199" height="18" /></h4>
        <h5><a href="http://www.visanet.com.pe">Acerca de VisaNet</a>
          &nbsp;|&nbsp;Publicidad
          &nbsp;|&nbsp;Pol&iacute;tica de Privacidad
          &nbsp;|&nbsp;Pol&iacute;tica Legal
          &nbsp;|&nbsp;Visa en el Mundo<br />
        	<span>2001-2012 Visa. All Rights Reserved.</span>
				</h5>
          
      <!-- fin contenido del footer -->
      
      </div>
<!-- contenido del Footer -->                  
    </div>
    </td>
  </tr>
</table>
</body>
</html>
