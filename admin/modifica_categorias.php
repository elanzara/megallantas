<?php 
include_once 'class/session.php';
include_once 'class/categorias.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

//Si en la grilla selecciono para modificar muestro los datos de la categoria
if (isset($_GET['md'])) {
	//Instancio el objeto categorias
	$cat = new categorias($_GET['md']);
}

 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CAT_DESCRIPCION'])){
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
	if (isset($_POST['CAT_ID'])){
		//Instancio el objeto categoria

            $nombre_archivo = "";
            $tipo_archivo  = "";
            $tamano_archivo  = "";
            $flash = "";
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
/*              $flash = $_FILES["flash"]["name"];
              $tipo_archivo = $_FILES['flash']['type'];
              if (strpos($flash,"swf")){
                  if(is_uploaded_file($_FILES['flash']['tmp_name']))
                    {
                    if(copy($_FILES['flash']['tmp_name'], "flash/".$_FILES["flash"]["name"])){
            //                echo "<br>bien";
                        }  else {
            //                echo "<br>MAL";

                            }
                    }
              }

*/
                $cat = new categorias($_POST['CAT_ID']);
		//Seteo las variables
//		$cat->set_GRP_ID($_POST['grupos']);
                $cat->set_CAT_DESCRIPCION($_POST['CAT_DESCRIPCION']);
                $cat->set_GRP_ID($_POST['grupos']);
                if ($nombre_archivo!=""){
                    $cat->set_CAT_FOTO($nombre_archivo);
                }
/*                if ($flash!=""){
                    $lin->set_LIN_FLASH($flash);
                }
*/			//actualizo los datos
		$resultado=$cat->update_CAT();

		if ($resultado>0){
			$mensaje="La categoría se modificó correctamente";
		} else {
			$mensaje="La categoría no se pudo modificar";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
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
   <h1>Modificar Categorías de Productos </h1>
   
    <!--Start FORM -->
 
    <table class="form">
     <tr>
     <td >
  <?php
//  if (isset($_GET['md'])) {
    echo "<FORM ACTION='modifica_categorias.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='CAT_ID' id='CAT_ID' value='$cat->CAT_ID' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'GRUPO</td>';
    echo '<td class="formFields">';
                include_once 'class/grupos.php'; // incluye las clases
                $gru = new grupos();
                $html = $gru->getgruposCombo($cat->GRP_ID);
                echo $html;
    echo '</td>';
    echo '</tr>';


    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "CATEGORIA:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='CAT_DESCRIPCION' id='CAT_DESCRIPCION' value='$cat->CAT_DESCRIPCION' type='text' class='campos' size='80'  />";
    echo "</td>";
    echo "</tr>";
/*
    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "Descripci&oacute;n:";
    echo "</td>";
    echo "<td class='formFields'>";
    //echo "<input name='LIN_DESCRIPCION' id='LIN_DESCRIPCION' value='$lin->LIN_DESCRIPCION' type='text' class='campos' size='18'  />";
    echo '<textarea name="LIN_DESCRIPCION" id="LIN_DESCRIPCION" class="campos" cols="100" rows="18" >'.$lin->LIN_DESCRIPCION.'</textarea>';
    echo "</td>";
    echo "</tr>";
*/
    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'Foto';
    echo '</td>';
    echo '<td align="left" class="formFields">';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';
    echo '<input name="imagen" id="imagen" type="file" class="campos" />';
    echo '</td>';
    echo '</tr>';
 
 /*
    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'Flash';
    echo '</td>';
    echo '<td class="formFields">';
    echo '<input type="file" id="flash" name="flash" class="campos"  />';
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'Ficha Técnica:';
    echo '</td>';
    echo '<td class="formFields">';
    echo '<input type="file" id="ficha" name="ficha" class="campos"  />';
    echo '</td>';
    echo '</tr>';
*/
    echo '<tr>';
    echo '<td colspan="2" align="right">';
    echo '<a href="alta_productos.php?cat_id='.$cat->CAT_ID.'"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar productos a la categoría</a><br><br>';
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_categorias.php'\" /></td>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='mensaje' colspan=2>";
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
	
/*   } else {
	//Instancio el objeto categorias
        $lin = new lineas();
*/	/*$categorias = $cat->getcategorias();*/
	
        //Paginacion:
/*        $link=Conectarse();
        //Limito la busqueda
        $TAMANO_PAGINA = 10;
        $_pagi_sql = $lin->getlineasSQL();
        //cantidad de resultados por página (opcional, por defecto 20)
        $_pagi_cuantos = 10;
        //cantidad de páginas amostrar en la barra de navegación (default = todas)
        $_pagi_nav_num_enlaces = 10;
        //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
        include("class/paginator.inc.php");
        echo "<p>Listado de lineas ".$_pagi_info."</p>";
        //Incluimos la barra de navegación
        echo"<p>".$_pagi_navegacion."</p>";

        print '<table class="form">'
		  .'<tr>'
                  .'<td width="150px" class="formTitle" >TITULO</td>'
                  .'<td width="150px" class="formTitle">DESCRIPCION</td>'
		  .'<td><img src="images/edit.png" alt="Modificar" align="absmiddle" /> Modificar</td></tr>';

	while ($row=mysql_fetch_Array($_pagi_result)) // recorre las categorias una por una hasta el fin de la tabla
	{
		print '<tr>'
		  //.'<td>'.$row['GRP_ID'] .'</td>'
                  .'<td>'.$row['LIN_TITULO'] .'</td>'
		  .'<td>'.$row['LIN_DESCRIPCION'] .'</td>'
                  .'<td><img src="images/edit.png" alt="Modificar" align="absmiddle" /> <a href="modifica_lineas.php?md='.$row['LIN_ID'].'">Modificar</a></td>'		// lo correcto seria enviarlos por post con un submit por ejem.
                  .'</tr>';
	}
	print '</table>';
  }*/
  ?>
  <?php
/*        if (isset($mensaje)) {
          echo $mensaje;
        }*/
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