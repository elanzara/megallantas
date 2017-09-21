<?php
include_once 'class/session.php';
include_once 'class/categorias.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CAT_DESCRIPCION'])) {

    $mensajeError="";

    /*validaciones*/
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {

        $nombre_archivo = "";
        $tipo_archivo  = "";
        $tamano_archivo  = "";
        $flash = "";
        //Manejo imagenes:
//        if($_SERVER["REQUEST_METHOD"] == "POST"){
             $nombre_archivo = $_FILES['imagen']['name'];
             $tipo_archivo = $_FILES['imagen']['type'];
             $tamano_archivo = $_FILES['imagen']['size'];

             if (!((strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "jpeg") ||strpos($tipo_archivo, "gif")) && ($tamano_archivo < 10000000))) {
                  // echo "La extensi?n o el tama?o de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb m?ximo.</td></tr></table>";
             }else{
                   if (move_uploaded_file($_FILES['imagen']['tmp_name'],"imagenes_categoria//$nombre_archivo")){
                   //header ("Location: add_kart.php");
                   }else{
                   //  echo "Ocurri? alg?n error al subir el fichero. No pudo guardarse.";
                   }
              }
//              $flash = $_FILES["flash"]["name"];
//              $tipo_archivo = $_FILES['flash']['type'];
//              if (strpos($flash,"swf")){
//                  if(is_uploaded_file($_FILES['flash']['tmp_name']))
//                    {
//                    if(copy($_FILES['flash']['tmp_name'], "flash/".$_FILES["flash"]["name"])){
            //                echo "<br>bien";
 //                       }  else {
            //                echo "<br>MAL";

  //                          }
    //                }
//              }
	//Instancio el objeto categoria
        $cat = new categorias();
	//Seteo las variables
        $cat->set_CAT_DESCRIPCION($_POST['CAT_DESCRIPCION']);
        $cat->set_CAT_FOTO($nombre_archivo);
        $cat->set_GRP_ID($_POST['grupos']);
	//Inserto el registro
	$resultado=$cat->insert_CAT();

	if ($resultado>0){
		$mensaje="La categoría se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta la categoría";
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
   <h1>Alta de Categorías de Productos </h1>
   
    <!--Start FORM -->
     <form ACTION="alta_categorias.php" METHOD="POST" enctype="multipart/form-data">
        
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">
            GRUPO</td>
            <td class="formFields">
                <?php 
                include_once 'class/grupos.php'; // incluye las clases
                $gru = new grupos();
                $html = $gru->getgruposCombo();
                echo $html;
                ?>                
            </td>
          </tr>
          <tr>
            <td class="formTitle">
            CATEGORIA</td>
            <td class="formFields">
                <input name="CAT_DESCRIPCION" id="CAT_DESCRIPCION" type="text" class="campos" size="80" />
            </td>
          </tr>
          <tr>
          	<td class="formTitle" align="left">
                    FOTO</td>
   	        <td align="left" class="formFields">
                <input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
                <input name='imagen' id='imagen' type='file' />
            </td>
          </tr>
<!--          <tr>
          	<td class="formTitle" align="left">
                    FLASH</td>
   	  <td align="left" class="formFields">
        <input type="file" id="flash" name="flash" />
                <span class="color"></span></td>
          </tr>


    <tr>
    <td class="formTitle">
    Ficha Técnica:
    </td>
    <td class="formFields">
    <input type="file" id="ficha" name="ficha" class="campos"  />
    </td>
    </tr>

-->
          <tr>
          	<td colspan="2" align="center" class="formFields">
       		  <input type="submit" class="boton" value="Enviar" />
<!--                    <a href='index.php'><input type='button' value='Volver' /></a>-->
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