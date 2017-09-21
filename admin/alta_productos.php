<?php
include_once 'class/session.php';
include_once 'class/categorias.php'; // incluye las clases
include_once 'class/grupos.php';
include_once 'class/conex.php';
include_once 'class/productos.php'; // incluye las clases
$mensaje="";
$grupo="";
$categoria="";

$cat_id =1;
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["cat_id"])){
        $cat_id = $_GET["cat_id"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['PRO_DESCRIPCION'])) {

    $mensajeError="";

    /*validaciones*/
    /*validaciones*/
//    echo "Entro por el POST<br>";

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {


//        echo "Comienza a hacer el upload<br>";

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


/*        $nombre_pdf = "";
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
//                echo "Hace el upload de la animación swf.<br>";
                  {
                if(copy($_FILES['flash']['tmp_name'], "flash_productos/".$_FILES["flash"]["name"])){
        //                echo "<br>bien";
                    }  else {
        //                echo "<br>MAL";

                        }
                }
          }
*/
//	echo "Instancio el objeto de productos.<br>";
        //Instancio el objeto categoria
        $cat = new categorias();
        $pro = new productos();

//        echo "Seteo los datos del producto.<br>";
	//Seteo las variables
        $pro->set_PRO_DESCRIPCION($_POST["PRO_DESCRIPCION"]);
        $pro->set_CAT_ID($_POST["categorias"]);
        $pro->set_PRO_CODIGO($_POST["PRO_CODIGO"]);
        $pro->set_GRP_ID($_POST["grupos"]);
        $pro->set_PRO_FOTO($nombre_archivo);
        $grupo=$_POST["grupos"];
        $categoria=$_POST["categorias"];        
        
        //Inserto el registro
//        echo "Intento insertar los datos.<br>";
	    $resultado=$pro->insert_PRO();
//        echo "Termino de insertar el objeto en la BBDD.<br>";
//        $lin->set_LIN_TITULO($_POST['LIN_TITULO']);
//        $lin->set_LIN_DESCRIPCION($_POST['LIN_DESCRIPCION']);
//        $lin->set_LIN_FOTO($nombre_archivo);
//        $lin->set_LIN_FLASH($flash);
	//Inserto el registro
//	$resultado=$lin->insert_LIN();

//        echo "SQL: ".$resultado;
        
	if ($resultado>0){
		$mensaje="El producto se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta el Producto";
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
   <h1>Alta de  Productos </h1>
   
   <!--Start FORM -->
   <form ACTION="alta_productos.php" METHOD="POST" enctype="multipart/form-data">
      
    <table class="form" border="0"  align="center">
          <tr>
            <td class="formTitle">
            GRUPO</td>
            <td>
                <?php
                $grp = new grupos();
                $res = $grp->getgruposCombo($grupo);
                print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">
            CATEGORÍA</td>
            <td>
                <?php
                if ($categoria!=""){
                    $cat = new categorias();
                    $res = $cat->get_select_categorias($categoria);
                    print $res;
                } else {
                //$cat = new categorias();
                //$res = $cat->get_select_categorias();
                //print $res;
                ?>
                <select disabled="disabled" name="categorias" id="categorias">
                        <option value="0">Selecciona opci&oacute;n...</option>
                </select>
                <?php } ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">
            TITULO</td>
          	<td>
                <input type="text" name="PRO_CODIGO" id="PRO_CODIGO" class="campos" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">
            DESCRIPCION</td>
          	<td>
                    <textarea name="PRO_DESCRIPCION" id="PRO_DESCRIPCION" class="campos" cols="100" rows="18" ></textarea>
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
          	<td colspan="2" >
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