<?php 
include_once 'class/session.php';
include_once 'class/ofertas.php'; // incluye las clases
include_once 'class/conex.php';
$ofe = new ofertas();

if (isset($_GET['br'])) {
        //Instancio el objeto categorias
        $ofe_id = $_GET['br'];
        //echo "lin_id= ".$lin_id;
        $ofe=new ofertas($ofe_id);
        $ofe->set_OFE_ESTADO(1);
        $resultado=$ofe->baja_OFE();
        //echo $resultado;
        if ($resultado>0){
                $mensaje="La oferta fue dada de baja correctamente";
        } else {
                $mensaje="La oferta no pudo ser dada de baja";
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
   <h1>Administración de Ofertas </h1>
    <!--Start Tabla  -->
    <table   border="0" class="form">
	<tr>
        <td>
    <?php
    //Instancio el objeto clientes
    /*$cat=new categorias();
    $categorias=$cat->getcategorias();*/
    $link=Conectarse();
    $ofe = new ofertas();
    $ofertas = $ofe->getofertasSQL();
    //Paginacion:
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $ofertas;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    //$_pagi_nav_estilo = "navegador";
    include("class/paginator.inc.php");
    echo "<h3>Listado de ofertas ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_ofertas.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar ofertas</a><br><br>';
    print '<table class="form">'
		  .'<tr class="rowGris">'
          .'<td  class="formTitle" width="150px"><b>TITULO</b></td>'
          .'<td class="formTitle" ><b>DESCRIPCION</b></td>'
		  .'<td  class="formTitle" width="150px"><b>PRECIO</b></td>'
          .'<td class="formTitle" width="90px"> </td>'
          .'<td class="formTitle" width="90px"></td></tr>';
         /* .'<td class="formTitle" width="120px"></td></tr>';*/
//<img src="images/delete.png" alt="Borrar" align="absmiddle" /> <b>Borrar</b>
//<img src="images/edit.png" alt="Modificar" align="absmiddle" /> <b>Modificar</b>
    while ($row=mysql_fetch_Array($_pagi_result/*$categorias*/)) // recorre las categorias una por una hasta el fin de la tabla
    {
	print '<tr class="rowBlanco">'
		  .'<td class="formFields">'.$row['OFE_TITULO'].'</td>'
		  .'<td class="formFields">'.$row['OFE_DESCRIPCION'].'</td>'
		  .'<td class="formFields">'.$row['OFE_PRECIO'].'</td>'
          .'<td class="formFields" width="90px"> <img src="images/delete.png" alt="Borrar" align="absmiddle" /><a href="abm_ofertas.php?br='.$row['OFE_ID'].'">  Borrar</a></td>'		// lo correcto seria enviarlos por post con un submit por ejem.
          .'<td class="formFields" width="90px"><img src="images/edit.png" alt="Modificar" align="absmiddle" /> <a href="modifica_ofertas.php?md='.$row['OFE_ID'].'"> Modificar</a></td>'
		  .'</tr>';
          
          /*.'<td class="formFields" width="120px"><img src="images/search.png" alt="Ver productos" align="absmiddle" /> <a href="abm_productos.php?lineas='.$row['LIN_ID'].'"> Ver Productos</a></td>'
*/
    }
    print '</table>';
     ?>     </td>
     </tr>
     <tr>
     <td  class="mensaje">
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