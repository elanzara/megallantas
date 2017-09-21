<?php
include_once 'class/session.php';
include_once 'class/ofertas.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['OFE_TITULO'])) {

    $mensajeError="";

    /*validaciones*/
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {

        $nombre_archivo = "";
        $tipo_archivo  = "";
        $tamano_archivo  = "";
        //Manejo imagenes:
//        if($_SERVER["REQUEST_METHOD"] == "POST"){
             $nombre_archivo = $_FILES['imagen']['name'];
             $tipo_archivo = $_FILES['imagen']['type'];
             $tamano_archivo = $_FILES['imagen']['size'];

             if (!((strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "jpeg") ||strpos($tipo_archivo, "gif")) && ($tamano_archivo < 10000000))) {
                  // echo "La extensi?n o el tama?o de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb m?ximo.</td></tr></table>";
             }else{
                   if (move_uploaded_file($_FILES['imagen']['tmp_name'],"imagenes_oferta//$nombre_archivo")){
                   //header ("Location: add_kart.php");
                   }else{
                   //  echo "Ocurri? alg?n error al subir el fichero. No pudo guardarse.";
                   }
              }
	//Instancio el objeto categoria
        $ofe = new ofertas();
	//Seteo las variables
        $ofe->set_OFE_DESCRIPCION($_POST['OFE_DESCRIPCION']);
        $ofe->set_OFE_TITULO($_POST['OFE_TITULO']);
        $ofe->set_OFE_PRECIO($_POST['OFE_PRECIO']);
        $ofe->set_OFE_FOTO($nombre_archivo);
	//Inserto el registro
	$resultado=$ofe->insert_OFE();

	if ($resultado>0){
		$mensaje="La oferta se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta la oferta";
	}
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>.:MEGALLANTAS:.</title>
 <LINK REL="SHORTCUT ICON" HREF="images/mega.png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/megallantas.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/funciones.js" language="javascript"></script>
</head>

<body>
<div id="page"> 
 <!--Start HEADER -->
 <? require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de Ofertas </h1>
   
    <!--Start FORM -->
     <form ACTION="alta_ofertas.php" METHOD="POST" enctype="multipart/form-data">
        
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">
            TITULO</td>
            <td class="formFields">
                <input name="OFE_TITULO" id="OFE_TITULO" type="text" class="campos" size="80" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">
            DESCRIPCION</td>
          	<td>
                <textarea name="OFE_DESCRIPCION" id="OFE_DESCRIPCION" class="campos" cols="100" rows="18" ></textarea>
            </td>
          </tr>
          <tr>
            <td class="formTitle">
            PRECIO</td>
            <td class="formFields">
                <input name="OFE_PRECIO" id="OFE_PRECIO" type="text" class="campos" size="80" />
            </td>
          </tr>
          <tr>
          	<td class="formTitle" align="left">
                    FOTO
          	</td>
          	<td align="left">
                <input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
                <input type="file" id="imagen" name="imagen" />
           </td>
          </tr>
          <tr>
          	<td colspan="2" align="center" class="formFields">
       		  <input type="submit" class="boton" value="Enviar" />
          	</td>
          </tr>
          <tr>
              <td colspan="2" class="mensaje">
          		<?php 
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
          		?>
          	</td>
          </tr>
       </table>
		
       <?php
	        if (isset($_POST["mensaje"])) {
        	if ($_POST["mensaje"]!=""){
        		$mensaje=$_POST["mensaje"];
				echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
			}}
          ?>
    </form>
    
    
    
    <!--End FORM -->

   
 </div> 
<!--End CENTRAL -->
    
  <br clear="all" />
</div>
</body>
</html>