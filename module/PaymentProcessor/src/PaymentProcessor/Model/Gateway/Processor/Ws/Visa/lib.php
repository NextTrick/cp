<?php
define('CODIGO_TIENDA','517598001');

//// CALIDAD
define('URL_FORMULARIO_VISA','http://qas.multimerchantvisanet.com/formularioweb/formulariopago.aspx');
define('URL_WSGENERAETICKET_VISA','http://qas.multimerchantvisanet.com/WSGenerarEticket/WSEticket.asmx?wsdl');
define('URL_WSCONSULTAETICKET_VISA','http://qas.multimerchantvisanet.com/WSConsulta/WSConsultaEticket.asmx?wsdl');
//// CALIDAD LOCAL
//define('URL_WSGENERAETICKET_VISA','WSEticketQAS.wsdl');
//define('URL_WSCONSULTAETICKET_VISA','WSConsultaEticketQAS.wsdl');

//// PRODUCCIÓN
//define('URL_FORMULARIO_VISA','https://www.multimerchantvisanet.com/formularioweb/formulariopago.aspx');
//define('URL_WSGENERAETICKET_VISA','https://www.multimerchantvisanet.com/WSGenerarEticket/WSEticket.asmx?wsdl');
//define('URL_WSCONSULTAETICKET_VISA','https://www.multimerchantvisanet.com/WSConsulta/WSConsultaEticket.asmx?wsdl');
//// PRODUCCION LOCAL
//define('URL_WSGENERAETICKET_VISA','WSEticket.wsdl');
//define('URL_WSCONSULTAETICKET_VISA','WSConsultaEticket.wsdl');

///PROXY
define('PROXY_ON', false);
define('PROXY_HOST','000.000.000.000');
define('PROXY_PORT',3128);
define('PROXY_LOGIN','dom\usuario');
define('PROXY_PASSWORD','clave');

function noCache() {
  header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}
function htmlRedirecFormAnt($CODTIENDA, $NUMORDEN, $MOUNT){
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body onload="fm.submit();">

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="CODTIENDA" value="#CODTIENDA#" /><BR>
	    <input type="hidden" name="NUMORDEN" value="#NUMORDEN#" /><BR>
	    <input type="hidden" name="MOUNT" value="#MOUNT#" /><BR>
	</form>
	</Body>
	</Html>';

	$html=ereg_replace("#CODTIENDA#",$CODTIENDA,$html);
	$html=ereg_replace("#NUMORDEN#",$NUMORDEN,$html);
	$html=ereg_replace("#MOUNT#",$MOUNT,$html);

	return $html;
}
function htmlRedirecFormEticket_bak($ETICKET){
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body >

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="ETICKET" value="#ETICKET#" /><BR>
	    <input type="submit" name="boton" value="Pagar" /><BR>
	</form>
	#ETICKET#
	</Body>
	</Html>';

	$html= str_replace("#ETICKET#", $ETICKET, $html);

	return $html;
}
function htmlRedirecFormEticket($ETICKET){
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body onload="fm.submit();">

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="ETICKET" value="#ETICKET#" /><BR>
	    <!--<input type="submit" name="boton" value="Pagar" /><BR>-->
	</form>
	</Body>
	</Html>';

	$html= str_replace("#ETICKET#", $ETICKET, $html);

	return $html;
}

?>
