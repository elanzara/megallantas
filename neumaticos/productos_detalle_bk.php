<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php
include "../admin/class/conex.php";
include "../admin/class/grupos.php";
include "../admin/class/categorias.php";
include "../admin/class/productos.php";
$cat_id = 0;
$cat_descripcion = "";
$grp_id=0;
$grp_descripcion = "";
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["cat_id"])){
        $cat_id = $_GET["cat_id"];
        $cat = new categorias($cat_id);
        $cat_descripcion = $cat->get_CAT_DESCRIPCION();
        $grp_id = $cat->get_GRP_ID();
        $grp = new grupos($grp_id);
        $grp_descripcion = $grp->get_GRP_DESCRIPCION();
        /*$pro = new productos();
        $productos = $pro->getproductos($cat_id);*/
               
    }
}



?>
<html>
<head>
<title>Todo para el Automotor - Megallantas Argentina</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<META NAME="Keywords" CONTENT="reparacion,ventas,gomerias, gomeria, goma, llanta,warnes, reparaciondellantas, reparacionllantas,moron,llantas,mega,megallantas,deportivas, 
originales,nuevas,usuadas,moron,reparacion,ventas,llantas,mega,megallantas,deportivas, aleacion, aluminio, rayos, chapa, centrado, golpe, agujeros, cromado, darck, gloss, 
gool, pintado, dorado, momo, magnels, tsw, ruedas, argentina, cron, lux, gris, laqueado, bsa, vaska, tvw, auto, camioneta, touning, sportiva, 
chome, look, ,hiperplata, centro, rim, ford, vw, citroen, audi, mercedez, benz, fiat, toyota, renault, honda, civic, 206, c3, golf, fox, corsa, 
palio, fiat,uno, gol, chome,look, bmw, originales, ruedas, kromma,originales,nuevas,usuadas,diamante, diamantado">
<META NAME="Description" CONTENT="reparacion de llantas,venta de llantas,reparacion llantas,venta llantas,Reparacin y venta de llantas Deportivas y Originales Nuevas y Usadas,
, Reparacion y venta de llantas, venta de llantas, deportivas y originales nuevas y usadas, centrado de llantas, centrado y 
pintado de llantas, reparacion de llantas de chapa, reparacion de llantas de aluminio, centrado en el momento de llantas, llantas deportivas 
reparacion, llantas de chapa reparacion, llantas de aluminio, pintura de llantas darck gloos, pintura de llanta de chapa, pintura hipr plata, 
pintura chrome look, pintura y diamantado de llantas, diamantado y laqueado de llantas, llantas magnels, llantas tsw, llantas tvw, llantas 
ruedas argentinas, ruedas argentinas, llantas originales, llantas cromadas, llantas reparadas a nuevo, como se repara una llanta, conviene 
reparar las llantas, neumaticos rosmi, neumaticos jose, neumaticos ruben, coscolla, mundo ruedas, multiruedas, auto touning, space touning">
<META NAME="Title" CONTENT="megallantas Capital Federal">
<META NAME="Author" CONTENT="VGT Web - Servicios de Internet.  ">
<META NAME="Subject" CONTENT="Todo para el Automotor">

<link rel="shortcut icon" href="favicon.ico">
<link rel="icon" type="image/png" href="../images/inicio/favicon.png">

<link href="../css/neumaticos/style.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script language="Javascript1.2">
message = "Reparacin de Llantas - Megallantas";
function NoRightClick(b) {
   if(((navigator.appName=="Microsoft Internet Explorer")&&(event.button > 1))
   ||((navigator.appName=="Netscape")&&(b.which > 1))){
   alert(message);
   return false;
   }
}
document.onmousedown = NoRightClick;
// -->
</script>

<!--AGREGADO PARA EL MANEJO DEL POP UP -->
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>

<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
	hs.outlineType = 'rounded-white';
	hs.showCredits = false;
	hs.wrapperClassName = 'draggable-header';
</script>


<!-- FIN DEL MANEJO DEL POP UP-->

</head>
<body onLoad="MM_preloadImages('../images/neumaticos/m1-1.gif','../images/neumaticos/m2-2.gif','../images/neumaticos/m3-3.gif','../images/neumaticos/m4-4.gif','../images/neumaticos/m5.gif')">
<table cellpadding="0" cellspacing="0" border="0"  align="center" style="width:766px; height:0px">
	<tr>
		<td valign="top" width="766" height="20" >		
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,24" width="766" height="120">
    <param name="movie" value="../images/neumaticos/top_neumaticos_sec.swf">
    <param name="quality" value="high">
    <param name="menu" value="false">
    <!--[if !IE]> <-->
    <object data="../images/neumaticos/top_neumaticos_sec.swf"
            width="766" height="120" type="application/x-shockwave-flash"> 
     <param name="quality" value="high">
     <param name="menu" value="false">
     <param name="pluginurl" value="http://www.macromedia.com/go/getflashplayer">     
    </object>
    <!--> <![endif]-->
  </object>
</td>
	</tr>

	<tr>
		<td valign="top" width="766" height="20" style= "background:   url(../images/neumaticos/top4.jpg)">		
			<table height="63" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="766" height="20">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="504" height="20"> </td>
								<td valign="top" width="262" height="0" class="header"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="766" height="0">				    
					<a href="ofertas.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','../images/neumaticos/m1-1.gif',1)"><img alt="" src="../images/neumaticos/m1.gif" name="Image17" width="101" style="margin-left:52px" height="33" border="0"></a><a href="../reparacion/index.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','../images/neumaticos/m2-2.gif',1)"><img style="margin-left:39px" alt="" src="../images/neumaticos/m2.gif" name="Image18" width="101" height="33" border="0"></a><a href="servicios.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image19','','../images/neumaticos/m3-3.gif',1)"><img style="margin-left:39px" alt="" src="../images/neumaticos/m3.gif" name="Image19" width="101" height="33" border="0"></a><a href="productos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image20','','../images/neumaticos/m4-4.gif',1)"><img style="margin-left:39px" alt="" src="../images/neumaticos/m4.gif" name="Image20" width="101" height="33" border="0"></a><a href="#" onClick="MM_openBrWindow('../popup/neumaticos/consultas.html','','width=500,height=500')" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image21','','../images/neumaticos/m5-5.gif',1)"><img style="margin-left:39px" alt="" src="../images/neumaticos/m5.gif" name="Image21" width="101" height="33" border="0"></a>
					</td>
				</tr>
		  </table>			
		</td>
	</tr>
	<tr>
		<td valign="top" width="766" height="307" style="background-image:   url(../images/neumaticos/1_bg.gif)">
			<table cellpadding="0" cellspacing="0" border="0" style="background:   url(../images/neumaticos/1_bg1.gif) no-repeat top">
				<tr>
					<td valign="top" width="766" height="307" style="background:   url(../images/neumaticos/1_bg2.gif) no-repeat bottom" >
						<table cellpadding="0" cellspacing="0" border="0" >
							<tr>
								<td valign="top" width="70" height="1014"></td>
								<td valign="top" width="625" height="1014"><br>
								  <br>
								<!--/* inicio menu central */-->
<div align="center">

  <table border="0" width="600" id="table6" cellspacing="0" cellpadding="4" style="border-width: 0px" background= "../images/neumaticos/1_bg2.gif)%20no-repeat%20top">
	<tr>
		<td width="600" style="border-style: none; border-width: medium">
		<font size="1"></font>		
<!--MENU IZQUIERDA -->
		  <table border="1" width="100%" id="table8" cellspacing="0" cellpadding="0">
			<tr>
				<td width="126" valign="top" style="background:   url(../images/neumaticos/1_bg1.gif) no-repeat top">
<!--				<p align="left" style="margin-top: 0; margin-bottom: 0; font-size: 12;">				
				<a href="cubiertas/neumaticos.html" class="popup-titulo">&nbsp;<span class="popup-texto2">Neum&aacute;ticos</span></a></p>
 -->
    				<table border="0" width="100%" id="table12" cellspacing="0" cellpadding="0">
<?php
    $gru = new grupos();
    $grupos = $gru->getgrupos();
    while ($row = mysql_fetch_assoc($grupos)) {

      echo '<tr>';
     	echo '<td height="18">&nbsp;</td>';
    	echo '</tr>';

    	echo '<tr>';
    	echo '<td align="left" height="18">';
    	echo '<p align="left" style="margin-top: 0; margin-bottom: 0">';
    	echo '<a href="productos.php?grp_id='.$row["GRP_ID"].'" class="popup-titulo" style="text-decoration: none">&nbsp;<span class="popup-texto2">'.$row["GRP_DESCRIPCION"].'</span></a>';
    	echo '</td>';
    	echo '</tr>';

        $cat = new categorias();
        $categorias = $cat->getcategoriasGrupo($row["GRP_ID"]);
        $cont = 1;
        while ($row2 = mysql_fetch_assoc($categorias)) {
    		echo '<tr>';
    		echo '<td height="18" align="left" background="../images/neumaticos/1_mn1.jpg" class="avisos">';
    		echo '<font face="Arial" size="2">&nbsp;&nbsp;&nbsp;';
    		echo '</font>';
    		echo '<font color="#FF9A00" face="Arial" size="2">';
    		echo '<b><a href="productos_detalle.php?cat_id='.$row2["CAT_ID"].'">';
    		echo '<span style="text-decoration: none">'.$row2["CAT_DESCRIPCION"].'</span></a></b></font></td>';
    		echo '</tr>';
        }
    }
?>
    				</table>
<!--FIN MENU IZQUIERDA -->
				<br>
				<table border="1" width="100%" id="table13" style="border-width: 0px" cellspacing="1">
					<tr>
						<td style="border-style: none; border-width: medium" >
						<p align="left">&nbsp;&nbsp;<span class="popup-texto2">&nbsp;Tel&eacute;fonos</span></td>
					</tr>
				</table>
				<p align="left" style="margin-top: 0; margin-bottom: 0"><br>
				<b>
				<font color="#FFCF00" face="Arial" size="2">&nbsp;En Chacarita</font></b></p>
				<p align="left" style="margin-top: 0; margin-bottom: 0">&nbsp;<span class="popup-texto2">
													C&eacute;spedes 3821</span>
													<br style="line-height:15px">													 
													<span class="popup-texto2">&nbsp; +54 11 4555-0344 /<br>
                                                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4553-3977<br>
				  &nbsp;&nbsp;Id 597*1138</span>
				  <p align="left" style="margin-top: 0; margin-bottom: 0"><br>
				<b>
				<font color="#FFCF00" face="Arial" size="2">&nbsp;En Palermo</font></b></p>
				<p align="left" style="margin-top: 0; margin-bottom: 0">&nbsp;<span class="popup-texto2">
													Av C&oacute;rdoba 4171</span>
													<br style="line-height:15px">													 
													<span class="popup-texto2">&nbsp; +54 11 4866-5947 /<br>
                                                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4861-2980<br>
				  &nbsp;&nbsp;Id 597*1138</span>
				  <span class="popup-texto2"><br>
				  <br><font color="#FFCF00" face="Arial" size="2">&nbsp;Horarios</font><br>
				  &nbsp;&nbsp;Lunes a Viernes<br>
				  &nbsp;&nbsp;08:00 a 19:00 Hs<br>
				  &nbsp;&nbsp;Sabados<br>
				  &nbsp;&nbsp;08:00 a 14:00 Hs<br></span></p><br>				
                  <a href="#" onClick="MM_openBrWindow('../popup/neumaticos/consultas.html','','width=500,height=500')">
						<span style="text-decoration: none"><b>
				<font color="#FFCF00" face="Arial" size="2">&nbsp;Contactanos</font></b></p></span></a>				
				<p align="left" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
				<table border="1" width="100%" id="table14" style="border-width: 0px" cellspacing="1">
					<tr>
						<td style="border-style: none; border-width: medium" >
						<p align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span class="popup-texto2">Forma de pago</span></td>
					</tr>
				</table>
				<p align="center" style="margin-top: 0; margin-bottom: 0"><br>
				<a href="tarjetas.html">
				<img border="0" src="../images/neumaticos/tarjetas.jpg" width="125" height="94"></a></p>
				</td>
				<td valign="top">								
				<table border="0" width="90%" id="table75" style="border-width: 0px" cellspacing="0" cellpadding="4">
					<tr>
						<td style="border-style: none; border-width: medium">
            				<table border="0" width="465" id="table76" cellspacing="0" cellpadding="0" height="40" background="../images/neumaticos/titulos.jpg no-repeat top">
            					<tr>
            						<td width="465">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            						<i class="ofertat"><?php echo $grp_descripcion . " - " . $cat_descripcion;?></i></td>
            					</tr>
            				</table>
				<p align="center" style="margin-top: 0; margin-bottom: 0">
  	        </td>
		</tr>
	</table>				

<!--IMAGENES CENTRAL -->
<table width="100%" border="1" cellpadding="4" cellspacing="0" id="table71" style="border-width: 1px">
					<tr>
						<td style="border-style: none; border-width: medium" align="left">
						<!--<font color="#FFFFFF" face="Arial" size="2">Contamos con todas las marcas. Las
						mejores llantas y mejores los neumáticos del mercado:</font>-->

<!-- GRUPO-->
<?php
    $pro = new productos();
    //$productos = $pro->getproductos($cat_id);

    //Paginacion:
    $link=Conectarse();
   //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $pro->getproductosSQL($cat_id);
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 18;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 4;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    $_pagi_nav_estilo = "navegador";
    
    include("../admin/class/paginator.inc.php");
    echo "<p><font color='FFFFFF' face='Arial' size='2'>Productos ".$_pagi_info."</font></p>";
    //Incluimos la barra de navegación
    echo"<p><font color='FFFFFF' face='Arial' size='2'>".$_pagi_navegacion."</font></p>";

    echo '<table border="1" width="100%" id="table72" style="border-width: 0px" cellspacing="0" cellpadding="4">';
    $cont = 1;
    while ($row = mysql_fetch_assoc($_pagi_result)) {
    	if ($cont == 1){
    	   echo '<tr>';
    	}
        echo '<td style="border-style: none; border-width: medium" align="center">';
    	echo '<a href="productos_detalle.php" onclick="return hs.htmlExpand(this, { headingText: \''.$row["PRO_CODIGO"].'\' })" >';
    	echo '<img src="../admin/imagenes_producto/'.$row["PRO_FOTO"].'" width="120" height="120" border="0" alt="'.$row["PRO_CODIGO"].'" />';
        echo '<br/><p><font color="FFFFFF" face="Arial">'.$row["PRO_CODIGO"].'</font></p><br/><br/></a>';
        echo '<div class="highslide-maincontent">
            <table>
            <tr><td>
            <img src="../admin/imagenes_producto/'.$row["PRO_FOTO"].'" alt="Foto" width="180" height="180"/>
            </td><td>'.$row["PRO_DESCRIPCION"].'</td></tr></table>
            </div>';    	
        echo '</td>';
        if ($cont == 3){
            echo '</tr>';
            $cont = 0;
        }
        $cont = $cont + 1;
    }
    echo '</table>';    
        
?>
						<p></td>
					</tr>
				</table>
<!--FIN IMAGENES CENTRAL -->                     
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>      			              </td>
					                 <td valign="top" width="71" height="1014"></td>
			              </tr>
		              </table>
	              </td>
              </tr>
          </table>
      </td>
    <tr><!--/* Inicio footer */-->
		<td>
          <table border="0" width="772" id="table19" cellspacing="0" cellpadding="4">
	      <tr>
		   <td height="28" class="menu">			
				<p align="center" style="margin-top: 0; margin-bottom: 0"><b>
				<font color="#FFFFFF" face="Arial" size="1">
				<a href="neumaticostaller.html"><span style="text-decoration: none">
				nosotros</span></a> - <a href="servicios.html">
				<span style="text-decoration: none">servicios</span></a> -
				<a href="productos.php"><span style="text-decoration: none">
				productos</span></a> - <a href="ofertas.php">
				<span style="text-decoration: none">ofertas</span></a> - 				
                        <a style="text-decoration: none" href="#" onClick="MM_openBrWindow('../popup/neumaticos/trabajos.html','','width=320,height=250')">trabajar en Megallantas</a> - 
			<a style="text-decoration: none" href="#" onClick="MM_openBrWindow('../popup/neumaticos/consultas.html','','width=500,height=500')">contactanos</a> - <a href="../admin/login.php">
				<span style="text-decoration: none">admin</span></a>
                </font></b></p></td>
		 </tr>
	  </table>
     </td>
  </tr>
 </tr>
 <tr>	    
  <td valign="top" width="766" height="70" class="footer" style="background:   url(../images/neumaticos/foot.jpg)">
		<div style="margin:43 0 0 390px "> <a href="#" onClick="MM_openBrWindow('popup/neumaticos/terminosycondiciones.html','','scrollbars=yes,width=600,height=600')">T&eacute;rminos y Condiciones</a></div></td>
 </tr>
</table>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-6014574-1");
pageTracker._trackPageview();
</script>

</body>
</html>