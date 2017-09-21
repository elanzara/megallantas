<?php
include_once 'class/session.php';
include_once 'class/movimientos_stock.php';
include_once 'class/productos.php';
include_once 'class/fechas.php';
include_once 'class/conex.php';

$mensaje="";
$suc_id = "";
$suc_des_id = "";
$tip_id = "";
$pro_id = "";
$fecha=date("d/m/Y");
$cantidad = "";
$observaciones = "";
//Llantas_originales:
//$mod_id="";
//$mar_id="";
//$pro_med_ancho="";
//$pro_med_diametro="";
//$pro_distribucion="";
//$tr_id="";
$pro_nueva="1";
////Neumaticos:
//$pro_med_alto="";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $tipo = $_GET['tipo'];
    $suc_id = $_GET['suc_id'];
    $suc_des_id = $_GET['suc_des_id'];
    if (isset($_GET['tip_id'])) {
      //echo"Gfiltro-t:".$_GET['tip_id'];
      $tip_id = $_GET['tip_id'];
      $pro_id = $_GET['pro_id'];}
}

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
  $tipo = $_POST['tipo'];
  if (isset($_POST['filtrar'])) {
      //echo"Pfiltro-t:".$_POST['tip_id'];
    $tip_id = $_POST['tip_id'];
    $mar_id = $_POST['marcas'];
    $mod_id = $_POST['modelos'];
    $tr_id = $_POST['tipo_rango'];
    $pro_med_ancho= $_POST['pro_med_ancho'];
    $pro_med_diametro= $_POST['pro_med_diametro'];
    $pro_distribucion= $_POST['pro_distribucion'];
    $pro_med_alto= $_POST['pro_med_alto'];
    $pro_nueva= $_POST['pro_nueva'];
    if ($pro_nueva=="Nuevo"){
        $pro_nueva = 1;
    } else {
        $pro_nueva = 0;
    }
    $pro_descripcion= $_POST['pro_descripcion'];
  } else {
      //echo"NOfiltro";
    $mensajeError="";
    $suc_id = $_POST['sucursales'];
    $suc_des_id = $_POST['sucursales_des'];
    $tip_id = $_POST['tipo_productos'];
    $pro_id = $_POST['productos_ms'];
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $observaciones = $_POST['observaciones'];

    /*validaciones*/
    if (isset($_POST['productos_ms'])) {
        if ($_POST['productos_ms']=="" or $_POST['productos_ms']=="Selecciona opción...") {
            $mensajeError .= "Falta completar el campo Producto.</br>";
        }
    }else{
            $mensajeError .= "Falta completar el campo Producto.</br>";
    }
    if (isset($_POST['cantidad'])) {
        if ($_POST['cantidad']<=0) {
            $mensajeError .= "La cantidad debe ser mayor a cero.</br>";
        }
        if ($tipo == "E" or $_POST["tipo"] == "T") {
            $pro = new productos();
            $cant_prod=$pro->getCantidadProducto($pro_id,$suc_id);
            if ($_POST['cantidad']>$cant_prod) {
                $mensajeError .= "La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
            }
        }
    }else{
            $mensajeError .= "Falta completar el campo Cantidad.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {
	//Instancio el objeto 
        $mov = new movimientos_stock();
	//Seteo las variables
        if ($_POST["tipo"] == "T") {
            $trans_id = $mov->getNumeroTrans();
            $mov->set_trans_id($trans_id);
        }
        //Ingreso o Transferencia
        if (($_POST["tipo"] == "I") or ($_POST["tipo"] == "T")) {
            $fechasql = new fechas();
            $f = $_POST['fecha'];
            $fechaconv =$fechasql->cambiaf_a_mysql($f);
            $mov->set_fecha($fechaconv);
            if ($_POST["tipo"] == "I") {
                $mov->set_suc_id($_POST['sucursales']);
            }else{
                $mov->set_suc_id($_POST['sucursales_des']);
            }
            $mov->set_pro_id($_POST['productos_ms']);
            $mov->set_tim_id(1);
            $mov->set_cantidad($_POST['cantidad']);
            $mov->set_observaciones($_POST['observaciones']);
            //Inserto el registro
            $resultado=$mov->insert_mov();
        }
        //Egreso o Transferencia
        if (($_POST["tipo"] == "E") or ($_POST["tipo"] == "T")) {
            $fechasql = new fechas();
            $f = $_POST['fecha'];
            $fechaconv =$fechasql->cambiaf_a_mysql($f);
            $mov->set_fecha($fechaconv);
            $mov->set_suc_id($_POST['sucursales']);
            $mov->set_pro_id($_POST['productos_ms']);
            $mov->set_tim_id(2);
            $mov->set_cantidad($_POST['cantidad']);
            $mov->set_observaciones($_POST['observaciones']);
            //Inserto el registro
            $resultado2=$mov->insert_mov();
        }
        //echo'resultado'.$resultado;

        //Ingreso o Transferencia
        if (($_POST["tipo"] == "I") or ($_POST["tipo"] == "T")) {
            if ($resultado>0){
                $mensaje="El movimiento stock se dio de alta correctamente";
                $suc_id = "";
                $suc_des_id = "";
                $tip_id = "";
                $pro_id = "";
                $fecha=date("d/m/Y");
                $cantidad = "";
                $observaciones = "";
            } else {
                    $mensaje="No se pudo dar de alta el movimiento stock";
            }
        }
        if (($_POST["tipo"] == "E") or ($_POST["tipo"] == "T")) {
            if ($resultado2>0){
                $mensaje="El movimiento stock se dio de alta correctamente";
                $suc_id = "";
                $suc_des_id = "";
                $tip_id = "";
                $pro_id = "";
                $fecha=date("d/m/Y");
                $cantidad = "";
                $observaciones = "";
            } else {
                    $mensaje="No se pudo dar de alta el movimiento stock";
            }
        }
    }
  } //(isset($_POST['filtrar']))
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body onLoad="Irfoco('fecha')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de Stock </h1>
     <!--Start FORM -->
     <form ACTION="alta_movimientos_stock.php?tipo=<?php print $tipo.'&tip_id='.$tip_id;?>" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <input name="tipo" id="tipo" type="hidden" class="campos" size="10" value="<?php print $tipo;?>" />
          <tr>
            <td class="formTitle">FECHA</td>
            <td class="formFields">
                <input name="fecha" id="fecha" type="text" class="campos" size="10" value="<?php print $fecha;?>" />
            </td>
          </tr>
          <?php
          if (($tipo == "I") or ($tipo == "E")) {
          ?>
          <tr>
            <td class="formTitle">SUCURSAL</td>
            <td class="formFields">
                <?php 
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($suc_id);
                echo $html;
                ?>                
            </td>
          </tr>
          <?php
          } else {//($tipo == "T") {
          ?>
          <tr>
            <td class="formTitle">SUCURSAL ORIGEN</td>
            <td class="formFields">
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($suc_id);
                echo $html;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">SUCURSAL DESTINO</td>
            <td class="formFields">
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursales_desCombo($suc_des_id);
                echo $html;
                ?>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td>
                <?php
          //echo"tipo:".$tipo;
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    //$res = $tip->getTipCombo($tip_id);
                    $res = $tip->getTipComboMvtoStock($tip_id,$tipo);
                    print $res;
                ?>
                <input type="hidden" id="tip_id" name="tip_id" value="<?php echo $tip_id;?>" />
            </td>
          </tr>
          <?php
          //echo"tip_id:".$tip_id;
          if ($tip_id!='') {
            //Neumaticos:
            if ($tip_id==4) {
          ?>
              <tr>
                <td class="formTitle">MARCA</td>
                <td>
                    <?php
                        include_once 'class/marcas.php';
                        $mar = new marcas();
                        $res = $mar->getmarcasxTipIdComboNulo($tip_id, $mar_id);
                        print $res;
                    ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">MODELO</td>
                <td>
                  <?php
                   include_once 'class/modelos.php';
                   if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                        $mod = new modelos();
                        $res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                        print $res;
                     } else {
                        print '<select disabled="disabled" name="modelos" id="modelos">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                     }
                  ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">ANCHO</td>
                <td><input type="text" name="pro_med_ancho" id="pro_med_ancho" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_ancho;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">ALTO</td>
                <td><input type="text" name="pro_med_alto" id="pro_med_alto" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_alto;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">DIAMETRO</td>
                <td><input type="text" name="pro_med_diametro" id="pro_med_diametro" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_diametro;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">RANGO</td>
                <td>
                    <?php
                        include_once 'class/tipo_rango.php';
                        $tpr = new tipo_rango();
                        $res = $tpr->gettipo_rangoCombo($tr_id);
                        print $res;
                    ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">ESTADO</td>
                <td>
                    <?php if ($pro_nueva==1){?>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="1" checked="true">Nuevo</input>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="0">Usado</input>
                    <?php } else {?>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="1">Nuevo</input>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="0" checked="true">Usado</input>
                    <?php }?>
                </td>
              </tr>
          <?php
            //Llantas_deportivas/Llantas_originales:
            } elseif (($tip_id==3 || $tip_id==2) or ($tip_id==9)) {
          ?>
              <tr>
                <td class="formTitle">MARCA</td>
                <td>
                    <?php
                        include_once 'class/marcas.php';
                        $mar = new marcas();
                        $res = $mar->getmarcasxTipIdComboNulo($tip_id, $mar_id);
                        print $res;
                    ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">MODELO</td>
                <td>
                  <?php
                   include_once 'class/modelos.php';
                   if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                        $mod = new modelos();
                        $res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                        print $res;
                     } else {
                        print '<select disabled="disabled" name="modelos" id="modelos">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                     }
                  ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">ANCHO</td>
                <td><input type="text" name="pro_med_ancho" id="pro_med_ancho" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_ancho;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">DIAMETRO</td>
                <td><input type="text" name="pro_med_diametro" id="pro_med_diametro" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_diametro;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">DISTRIBUCION</td>
                <td><input type="text" name="pro_distribucion" id="pro_distribucion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_distribucion;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">RANGO</td>
                <td>
                    <?php
                        include_once 'class/tipo_rango.php';
                        $tpr = new tipo_rango();
                        $res = $tpr->gettipo_rangoCombo($tr_id);
                        print $res;
                    ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">ESTADO</td>
                <td>
                  <?php if ($pro_nueva==1){?>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="1" checked="true">Nuevo</input>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="0">Usado</input>
                    <?php } else {?>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="1">Nuevo</input>
                        <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="0" checked="true">Usado</input>
                  <?php }?>
                </td>
              </tr>
          <?php
            } else { ?>
              <tr>
                <td class="formTitle">MARCA</td>
                <td>
                    <?php
                        include_once 'class/marcas.php';
                        $mar = new marcas();
                        $res = $mar->getmarcasxTipIdComboNulo($tip_id, $mar_id);
                        print $res;
                    ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">MODELO</td>
                <td>
                  <?php
                   include_once 'class/modelos.php';
                   if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                        $mod = new modelos();
                        $res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                        print $res;
                     } else {
                        print '<select disabled="disabled" name="modelos" id="modelos">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                     }
                  ?>
                </td>
              </tr>
              <tr>
                <td class="formTitle">DESCRIPCIÓN</td>
                <td>
                <textarea name="pro_descripcion" id="pro_descripcion" class="campos" cols="100" rows="2" onkeyup="this.value=this.value.toUpperCase()" ><?php print $pro_descripcion;?></textarea>
                </td>
              </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="2" align="center" class="formFields">
                  <input id="filtrar" name="filtrar" type="submit" class="boton" value="Filtrar" ></input>
                </td>
            </tr>
            <?php
            if (isset($_POST['filtrar'])) {
            ?>
              <tr>
                <td class="formTitle">PRODUCTO</td>
                <td>
                    <?php
//echo"tip_id:".$tip_id." mar_id:".$mar_id." mod_id:".$mod_id." anch:".$pro_med_ancho." diam:".$pro_med_diametro
//   ." dist:".$pro_distribucion." tr:".$tr_id." nueva:".$pro_nueva." alto:".$pro_med_alto;
                    if (isset($tip_id)) {
                     if ($tip_id!="") {
                        include_once 'class/productos.php';
                        $pro = new productos();
                        $res = $pro->getproductosCombo_MS($tip_id,$mar_id,$mod_id,$pro_med_ancho,$pro_med_diametro
                                ,$pro_distribucion,$tr_id,$pro_nueva,$pro_med_alto,$pro_descripcion);
                        print $res;
                     } else {
                        print '<select disabled="disabled" name="productos_ms" id="productos_ms">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                     }
                    }
                    ?>
                </td>
              </tr>
            <?php
            }
          }//if ($tip_id!='')
          ?>
          <tr>
            <td class="formTitle">CANTIDAD</td>
            <td class="formFields">
                <input name="cantidad" id="cantidad" type="text" class="campos" size="20" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $cantidad;?>" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields">
                <textarea id="observaciones" name="observaciones" rows="3" cols="60" onkeyup="this.value=this.value.toUpperCase()"><?php print $observaciones;?></textarea>
            </td>
          </tr>
          <tr>
          	<td colspan="2" align="center" class="formFields">
       		  <input type="submit" class="boton" value="Enviar" />
<!--              <a href='index.php'><input type='button' value='Volver' /></a>-->
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
		}
        }
          ?>
    </form>
    <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<!--<script type="text/javascript" src="select_dependientes_tip.js"></script>-->
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}
</script>
<script type="text/javascript">
  function armaFiltro(idSelectOrigen,tipo)
  {
    //alert('tipo'+tipo);
    // Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
    var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
    // Obtengo el select que el usuario modifico
    var selectOrigen=document.getElementById(idSelectOrigen);
    // Obtengo la opcion que el usuario selecciono
    var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
    if(opcionSeleccionada!=0)
    {
        // Obtengo el elemento del select que debo cargar
        var idSelectDestino=listadoSelects[posicionSelectDestino];
        var selectDestino=document.getElementById(idSelectDestino);
        location.href = 'alta_movimientos_stock.php?tipo='+tipo+'&tip_id='+opcionSeleccionada;
    }
  }
</script>
</body>
</html>