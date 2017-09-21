<?php 
include_once 'class/session.php';
include_once 'class/categorias.php'; // incluye las clases
include_once 'class/grupos.php';
include_once 'class/conex.php';
include_once 'class/productos.php';
$mensaje="";

//Si en la grilla selecciono para modificar muestro los datos de la categoria
if (isset($_GET['md'])) {
	//Instancio el objeto categorias
	$pro = new productos($_GET['md']);
}

 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['PRO_DESCRIPCION'])){
    $mensajeError="";

    /*validaciones*/
/*    if (isset($_POST['grupos'])) {
        if ($_POST['grupos']==0) {
            $mensajeError .= "Falta completar el campo Grupo.</br>";
        }
    }*/
    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['PRO_ID'])){
		//Instancio el objeto categoria

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
                   if (move_uploaded_file($_FILES['imagen']['tmp_name'],"imagenes_producto//$nombre_archivo")){
                   //header ("Location: add_kart.php");
                   }else{
                   //  echo "Ocurri? alg?n error al subir el fichero. No pudo guardarse.";
                   }
              }


/*            $nombre_pdf = "";
            $tipo_archivo  = "";
            $tamano_archivo  = "";
            $flash = "";
              $nombre_pdf = $_FILES["pdf"]["name"];
              $tipo_archivo = $_FILES['pdf']['type'];
              if (strpos($nombre_pdf,"pdf")){
                  if(is_uploaded_file($_FILES['pdf']['tmp_name']))
                    {
                    if(copy($_FILES['pdf']['tmp_name'], "pdf_productos/".$_FILES["pdf"]["name"])){
            //                echo "<br>bien";
                        }  else {
            //                echo "<br>MAL";

                            }
                    }
              }

            $nombre_archivo = "";
            $tipo_archivo  = "";
            $tamano_archivo  = "";
            $flash = "";
              $flash = $_FILES["flash"]["name"];
              $tipo_archivo = $_FILES['flash']['type'];
              if (strpos($flash,"swf")){
                  if(is_uploaded_file($_FILES['flash']['tmp_name']))
                    {
                    if(copy($_FILES['flash']['tmp_name'], "flash_productos/".$_FILES["flash"]["name"])){
            //                echo "<br>bien";
                        }  else {
            //                echo "<br>MAL";

                            }
                    }
              }
*/

        $pro = new productos($_POST['PRO_ID']);
		//Seteo las variables
//		$cat->set_GRP_ID($_POST['grupos']);
        $pro->set_PRO_DESCRIPCION($_POST["PRO_DESCRIPCION"]);
        $pro->set_CAT_ID($_POST["categorias"]);
        $pro->set_PRO_CODIGO($_POST["PRO_CODIGO"]);
        $pro->set_GRP_ID($_POST["grupos"]);
        if ($nombre_archivo!=""){
            $pro->set_PRO_FOTO($nombre_archivo);
        }
			//actualizo los datos
		$resultado=$pro->update_PRO();
//        echo $resultado;

		if ($resultado>0){
			$mensaje="El producto se modificó correctamente";
		} else {
			$mensaje="El producto no se pudo modificar";
		}
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
<script type="text/javascript" src="select_dependientes.js"></script>
</head>

<body>
<div id="page"> 
 <!--Start HEADER -->
 <? require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Modificar   Productos </h1>
   
<!--Start FORM -->
 
 <table  class="form">
     <tr>
     <td>
  <?php
  /*if (isset($_GET['md'])) {*/
    echo "<FORM ACTION='modifica_productos.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='PRO_ID' id='PRO_ID' value='$pro->PRO_ID' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'GRUPO</td>';
    echo '<td>';
        $grp = new grupos();
        $res = $grp->getgruposCombo($pro->GRP_ID);
        print $res;
    echo '</td>';
    echo '</tr>';


    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'CATEGORIA</td>';
    echo '<td class="formFields">';
                $cat = new categorias();
                $res = $cat->get_select_categorias($pro->CAT_ID);
                print $res;
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'TITULO</td>';
    echo '<td>';
    echo '<input type="text" name="PRO_CODIGO" id="PRO_CODIGO" class="campos" value="'.$pro->PRO_CODIGO.'" />';
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "Descripci&oacute;n";
    echo "</td>";
    echo "<td class='formFields'>";
    echo '<textarea name="PRO_DESCRIPCION" id="PRO_DESCRIPCION" class="campos" cols="100" rows="18" >'.$pro->PRO_DESCRIPCION.'</textarea>';
    echo "</td>";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle" align="left">';
    echo 'FOTO';
    echo '</td>';
    echo '<td align="left">';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';
    echo '<input type="file" id="imagen" name="imagen" />';
    echo '</td>';
    echo '</tr>';


    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<a href='abm_productos.php'><input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_productos.php'\" /></td>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='mensaje'>";
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
	
  ?>
  </td>
  </tr>
 </table>
    <!--End FORM -->

   
 </div> 
<!--End CENTRAL -->
    
  <br clear="all" />
</div>
</body>
</html>