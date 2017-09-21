<?php

// DATOS
$autor	= $_POST["nombre"];
$autor_mail = $_POST["email"];
$deny = array("destinatario","asunto","submit");

// MENSAJE FORM
foreach($_POST as $k => $v){
	if(!in_array($k,$deny)){
		$mensaje.= "<b>".ucfirst($k).":</b> ".$v."<br>";
	}
}

// CABECERAS
$cabeceras  = "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
$cabeceras .= "From: ".$autor."<".$autor_mail.">\nreply-to:".$autor_mail;

// Envio el mail
if(mail($_POST["destinatario"],$_POST["asunto"],$mensaje,$cabeceras)){
	$mensaje = "Su consulta se envi&oacute; correctamente!";
}else{
	$mensaje = "<b>Error!</b> no es posible enviar su consulta, intente nuevamente.";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Reparación de Llantas - Megallantas Argentina - Consultas y Sugerencias - megallantas.com.ar</title>
		<link href="../css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<center>
		  <div style="width:100%;">
				<br><br>
				<span style="font-size:14px; color:#FFFFFF;"><?php print $mensaje; ?></span>
				<br><br><br>
                                <a href="#" style="font-size:14px; color:#FFFFFF;" onclick="window.close();">Cerrar</a>
		  </div>			
		</center>
	</body>
</html>