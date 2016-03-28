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
	if (isset($_POST["btPagar_x"])) {
		//Se asigna el código de comercio y Nro. de pedido
		$numPedido= NumPedido();//$_POST["numPedido"];
		$codTienda= CODIGO_TIENDA;
		$mount= $_POST["montoTotal"];
		
		$nombre= $_POST["nombre"];
		$apellido= $_POST["apellido"];
		$ciudad= $_POST["ciudad"];
		$direccion= $_POST["direccion"];
		$correo= $_POST["correo"];
		
		$datoComercio= "EJEMPLO VISANET";
		
		//Se arma el XML de requerimiento
		$xmlIn = "";
		$xmlIn = $xmlIn . "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$xmlIn = $xmlIn . "<nuevo_eticket>";
		$xmlIn = $xmlIn . "	<parametros>";
		$xmlIn = $xmlIn . "		<parametro id=\"CANAL\">3</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"PRODUCTO\">1</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"CODTIENDA\">" . $codTienda . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"NUMORDEN\">" . $numPedido . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"MOUNT\">" . $mount . "</parametro>";
		
		$xmlIn = $xmlIn . "		<parametro id=\"NOMBRE\">" . $nombre . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"APELLIDO\">" . $apellido . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"CIUDAD\">" . $ciudad . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"DIRECCION\">" . $direccion . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"CORREO\">" . $correo . "</parametro>";
		
		$xmlIn = $xmlIn . "		<parametro id=\"DATO_COMERCIO\">" . $datoComercio . "</parametro>";
		$xmlIn = $xmlIn . "	</parametros>";
		$xmlIn = $xmlIn . "</nuevo_eticket>";
		
		//Se asigna la url del servicio
		$servicio= URL_WSGENERAETICKET_VISA;
		
		//Invocación del web service
		$conf=array();
		//Se habilita el parametro PROXY_ON en el archivo "lib.inc" si se maneja algun proxy para realizar conexiones externas.
		if(PROXY_ON == true){
			$conf=array('proxy_host'     => PROXY_HOST,
		                    'proxy_port'     => PROXY_PORT,
		                    'proxy_login'    => PROXY_LOGIN,
		                    'proxy_password' => PROXY_PASSWORD);
		}
		
		$client = new SoapClient($servicio, $conf);
    
    //parametros de la llamada
		$parametros=array(); 
		$parametros['xmlIn']= $xmlIn;
		
		//Aqui captura la cadena de resultado
		$result = $client->GeneraEticket($parametros);
		//Muestra la cadena recibida
		//echo 'Cadena de respuesta: ' . $result->GeneraEticketResult . '<br>' . '<br>';
		
		//Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
		$xmlDocument = new DOMDocument();
		
		if ($xmlDocument->loadXML($result->GeneraEticketResult)){
			/////////////////////////[MENSAJES]////////////////////////
			//Ejemplo para determinar la cantidad de mensajes en el XML
			$iCantMensajes= CantidadMensajes($xmlDocument);
			//echo 'Cantidad de Mensajes: ' . $iCantMensajes . '<br>';
			
			//Ejemplo para mostrar los mensajes del XML 
			for($iNumMensaje=0;$iNumMensaje < $iCantMensajes; $iNumMensaje++){
				echo 'Mensaje #' . ($iNumMensaje +1) . ': ';
				echo RecuperaMensaje($xmlDocument, $iNumMensaje+1);
				echo '<BR>';
				echo "Numero de pedido: " . $numPedido;
			}
			/////////////////////////[MENSAJES]////////////////////////
			
			if ($iCantMensajes == 0){
				$Eticket= RecuperaEticket($xmlDocument);
				//echo 'Eticket: ' . $Eticket;
				
				$html= htmlRedirecFormEticket($Eticket);
				echo $html;
				
				exit;
			}
					
		}else{
			echo "Error cargando XML";
		}	
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
<SCRIPT>
<!--
function ActualizaPrecio(campo) { 
	var precioUnidad= 0.95;
	var cantidad= campo.value;
	var precioTotal= precioUnidad*cantidad;
	var numero = new Number(precioTotal);
	precioTotal = numero.toFixed(2);
	
	var precio= "Precio: S/. " + precioTotal;
	document.getElementById("precio").innerHTML=precio;
	document.frmPago.montoTotal.value= precioTotal
}
function ValidaForm(){
	var precioTotal = new Number(document.frmPago.montoTotal.value);
	if(precioTotal > 0){
		return true;
	}else{
		alert("Seleccione al menos un producto");
		return false;
	}
}
//--> 
</SCRIPT>
</head>

<body >
	
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    	<div class="MainBox" id="MainBox" style="visibility:;" >
<!-- contenido del header -->
      <div class="Header" style="visibility:;">
					
        <h1><img src="images/logo_visanet.jpg" alt="VisaNet" /></h1>
        
      </div>
<!-- fin contenido del header -->      
      
<!-- contenido del Main -->      
      <div class="MainArea" style="visibility:;">
	      <!-- imagen banner !-->
	      <div class="img_back" align="center"> 
	            <img src="images/3_esp_img.png" alt="go" border="0" /> 
				</div>				        
	      <!--fin imagen banner!--> 
	      <div class="LeftCol cajasflotantes">
	        <div id="Newsletter" style="width:88px">
            <span title="Productos" id="Btn8">
            	<img src="images/news_home.png" width="13" height="10" alt="" /><span class="texto">Productos</span>
            </span> 
        </div>
					<form name="frmPago" method="post" action="index.php" onSubmit="return ValidaForm();">
					
						<table width="600" align="center" border="0">
							<tr>
								<td rowspan="7" valign="top"><img src="images/POS.gif" alt="POS" border="0"/></td>
								<td>
									<div align="left">
										<span class="texto">Cantidad:</span>
										<select name="cantidad" id="Select1" size="1" width="20px" onChange="ActualizaPrecio(this);" class="texto">
											<option value="0">--------</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>						
										</select>
									</div>
								</td>
								<td>
									<div align="center" id="precio" class="texto">
										Precio: S/. 0.00
									</div>
								</td>
								<td align="center"><input name="btPagar" type="image" src="images/go.gif" class="Estilo2" value="Pagar"></td>
							</tr>
							<tr>
								<td colspan="3">
									<div align="left">
										<span class="texto">Nombre:</span>
										<input name="nombre" type="text" size="26" maxlength="100" value="Nombre del Cliente">
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div align="left">
										<span class="texto">Apellido:</span>
										<input name="apellido" type="text" size="26" maxlength="100" value="Apellido del Cliente">
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div align="left">
										<span class="texto">Ciudad:</span>
										<input name="ciudad" type="text" size="26" maxlength="100" value="Ciudad">
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div align="left">
										<span class="texto">Direccion:</span>
										<input name="direccion" type="text" size="26" maxlength="100" value="Direccion del Cliente">
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div align="left">
										<span class="texto">Correo:</span>
										<input name="correo" type="text" size="26" maxlength="100" value="Correo del Cliente">
									</div>
								</td>
							</tr>
							<tr>
								<td valign="top">&nbsp;</td>
								<td>
									 
								</td>
								<td valign="top">&nbsp;</td>
							</tr>
							
						</table>
						<input name="montoTotal" type="hidden" size="10" maxlength="9" value="0.00">
					</form>
	      
	  		</div>
      </div>
<!-- contenido del Main -->      
      <br/>
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

<?php
	//Funcion que genera Numero de Pedido
	function NumPedido(){
		$archivo = "NumPedido.txt"; 
		$numPedido = 0; 
		
		$fp = fopen($archivo,"r"); 
		$numPedido = fgets($fp, 26); 
		fclose($fp); 
		
		++$numPedido; 
		
		$fp = fopen($archivo,"w+"); 
		fwrite($fp, $numPedido, 26); 
		fclose($fp); 
		
		return $numPedido;
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
	//Funcion que recupera el valor del Eticket
	function RecuperaEticket($xmlDoc){
		$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//registro/campo[@id='ETICKET']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
?>