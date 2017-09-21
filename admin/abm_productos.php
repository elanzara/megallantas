<?php 
include_once 'class/session.php';
include_once 'class/categorias.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/productos.php';
$pro = new productos();
$cat_id = 1;
if (isset($_GET['br'])) {
        //Instancio el objeto categorias
        $pro_id = $_GET['br'];
        //echo "lin_id= ".$lin_id;
        $pro2=new productos($pro_id);
        $pro2->set_PRO_ESTADO(1);
        $resultado=$pro2->baja_PRO();
        //echo $resultado;
        if ($resultado>0){
                $mensaje="El producto fue dado de baja correctamente";
        } else {
                $mensaje="El producto no pudo ser dada de baja";
        }
}
if (isset($_GET['categorias'])) {
    $cat_id = $_GET['categorias'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>.:MEGALLANTAS:.</title>
 <LINK REL="SHORTCUT ICON" HREF="images/megallantas.png" />
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
   <h1>Administración de Productos </h1>
      <!--Start Tabla  -->
     <table class="form">
	<tr>
        <td>
    <?php
    //Instancio el objeto clientes
    /*$cat=new categorias();
    $categorias=$cat->getcategorias();*/
    $link=Conectarse();
    $pro = new productos();
    $productos = $pro->getproductosSQL($cat_id);
    //Paginacion:
    
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $productos;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de productos ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_productos.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Producto</a><br><br>';
    
    echo "<form id='linea' name='linea' action='abm_productos.php' method='GET'>";
    $cat = new categorias();
    $html = $cat->get_select_categorias($cat_id);
    echo $html;
    echo "<input type='submit' value='Actualizar'>";
    echo "</form>";
    
    print '<table class="form">'
		  .'<tr class="rowGris">'
          .'<td  class="formTitle" width="150px" ><b>GRUPO</b></td>'  
          .'<td class="formTitle" width="150px"><b>CATEGORIA</b></td>'
          .'<td width="150px" class="formTitle"><b>TITULO</b></td>'
          .'<td  class="formTitle"><b>DESCRIPCION</b></td>'
		  .'<td width="90px" class="formTitle" ></td>'
          .'<td width="90px" class="formTitle"></td>'
          .'</tr>';

/*.'<td width="90px" class="formTitle"></td>'*/

    while ($row=mysql_fetch_Array($_pagi_result/*$categorias*/)) // recorre las categorias una por una hasta el fin de la tabla
    {
	print '<tr class="rowBlanco">'
		  .'<td class="formFields">'.$row['GRP_DESCRIPCION'] .'</td>'
          .'<td class="formFields">'.$row['CAT_DESCRIPCION'] .'</td>'
		  .'<td class="formFields">'.$row['PRO_CODIGO'] .'</td>'
          .'<td class="formFields">'.$row['PRO_DESCRIPCION'] .'</td>'
		  .'<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" /> <a href="abm_productos.php?br='.$row['PRO_ID'].'">Borrar</a></td>'		// lo correcto seria enviarlos por post con un submit por ejem.
		  .'<td class="formField"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="modifica_productos.php?md='.$row['PRO_ID'].'">Modificar</a></td>'
          .'</tr>';
          
          /*                  .'<td class="formField"><img src="images/photo_camera.png" alt="Fotos" align="absmiddle" /><a href="abm_fotosXproducto.php?pro_id='.$row['PRO_ID'].'">Fotos</a></td>'
*/
    }
    print '</table>';
     ?>
     </td>
     </tr>
     <tr>
     <td class="mensaje">
         <?php
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
         ?>
     </td>
     </tr>
   </table>
      <!--End Tabla -->
</div> 
<!--End CENTRAL -->
  <br clear="all" />
</div>
</body>
</html>