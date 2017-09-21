<?php
include_once 'class/lib_carrito_stock.php';
include_once 'class/session.php';
include_once 'class/fechas.php';
?>
<!DOCTYPE html>
<?php
include_once 'class/conex.php';
include_once 'class/movimientos_stock.php';
include_once 'class/productos.php';

//echo"1-s1:".$_SESSION["suc_des_id"]." s2:".$_GET['sucursales_des'].'<br>';
$mensaje="";
$tipo = "";
$tip_id = "";
$mar_id="";
$mod_id="";
$pro_med_alto="";
$pro_distribucion="";
$pro_med_ancho="";
$pro_med_diametro="";
$tr_id="";
$pro_nueva="";

if ($_SESSION["fecha"]=='') {
    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
}
if ($_SESSION["suc_id"]=='') {
    $_SESSION["suc_id"]= $_GET['sucursales'];
}
if ($_SESSION["suc_des_id"]=='') {
    $_SESSION["suc_des_id"]= $_GET['sucursales_des'];
}
//echo"2-s1:".$_SESSION["suc_des_id"]." s2:".$_GET['sucursales_des'].'<br>';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
 //echo"get:".$_GET['suc_id']." suc:".$suc_id;
  if ($_GET["error"]==1) {
        $mensajeError .= "La cantidad debe ser mayor a cero.</br>";
  }
  if ($_GET["error"]==2) {
        $mensajeError .= "La cantidad ingresada excede el stock del producto (".$_GET["stock"].").</br>";
  }
  if ($mensajeError!="") {
        $mensaje = $mensajeError;
  }
  //
  if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
  }
  if (isset($_GET['fecha'])) {
    $_SESSION["fecha"] = $_GET['fecha'];
  }
  if (isset($_GET['suc_id']) and $_GET['suc_id']!=0) {
    $_SESSION["suc_id"] = $_GET['suc_id'];
  }
  if (isset($_GET['remito']) and $_GET['remito']!=0) {
    $_SESSION["remito"] = $_GET['remito'];
  }
//echo"s3:".$_SESSION["suc_des_id"]." s2:".$_GET['suc_des_id'].'<br>';
  if (isset($_GET['suc_des_id']) and $_GET['suc_des_id']!=0) {
    $_SESSION["suc_des_id"] = $_GET['suc_des_id'];
  }
  if (isset($_GET['tip_id'])) {
      //echo"Gfiltro-t:".$_GET['tip_id'];
      $tip_id = $_GET['tip_id'];
      $pro_id = $_GET['pro_id'];
  }
  if ($_GET["limpiar_form"]=='S'){
    //echo"4";
        $_SESSION["ocarrito_stock"] = new carrito_stock();
        $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
  }
}
//echo"s4:".$_SESSION["suc_des_id"]." s2:".$_GET['suc_des_id'].'<br>';

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
    $pro_nueva= $_POST['estados'];
  } else {//if (isset($_POST['agregar'])) {
    //echo"agregar";
    $mensajeError="";
    $suc_id = $_POST['sucursales'];
    $suc_des_id = $_POST['sucursales_des'];
    $tip_id = $_POST['tipo_productos'];
    $pro_id = $_POST['productos_ms'];
    $fecha = $_POST['fecha'];

    /*validaciones*/
//    if (isset($_POST['productos_ms'])) {
//        if ($_POST['productos_ms']=="" or $_POST['productos_ms']=="Selecciona opción...") {
//            $mensajeError .= "Falta completar el campo Producto.</br>";
//        }
//    }else{
//            $mensajeError .= "Falta completar el campo Producto.</br>";
//    }
//    if (isset($_POST['cantidad'])) {
//        if ($_POST['cantidad']<=0) {
//            $mensajeError .= "La cantidad debe ser mayor a cero.</br>";
//        }
//        if ($tipo == "E" or $_POST["tipo"] == "T") {
//            $pro = new productos();
//            $cant_prod=$pro->getCantidadProducto($pro_id,$suc_id);
//            if ($_POST['cantidad']>$cant_prod) {
//                $mensajeError .= "La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
//            }
//        }
//    }else{
//            $mensajeError .= "Falta completar el campo Cantidad.</br>";
//    }
    /*validaciones*/
  }//filtrar
  if ($mensajeError!="") {
        $mensaje = $mensajeError;
  } else {
      if (isset($_POST['enviar'])) {
        //echo"enviar";
        $cantidad = $_SESSION["ocarrito_stock"]->get_num_productos();
        for ($i=0;$i<$cantidad;$i++){
            //Instancio el objeto
            $mov = new movimientos_stock();
            if ($i==0){
                $encabezado_id = $mov->getNumeroEncabezado();
            }
            $mov->set_encabezado_id($encabezado_id);
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
                $mov->set_tim_id(1);
                $rec= $_SESSION["ocarrito_stock"]->recupera_linea($i);
                $mov->set_pro_id($rec[1]);
                $mov->set_cantidad($rec[3]);
                $mov->set_observaciones($rec[4]);
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
                $mov->set_tim_id(2);
                $rec= $_SESSION["ocarrito_stock"]->recupera_linea($i);
                $mov->set_pro_id($rec[1]);
                $mov->set_cantidad($rec[3]);
                $mov->set_observaciones($rec[4]);
                //Inserto el registro
                $resultado2=$mov->insert_mov();
            }
            //echo'resultado'.$resultado;
        }//for ($i=0;$i<$cantidad;$i++)

        //Ingreso o Transferencia
        if (($_POST["tipo"] == "I") or ($_POST["tipo"] == "T")) {
            if ($resultado>0){
                $mensaje="El movimiento stock se dio de alta correctamente";
                $_SESSION["ocarrito_stock"] = new carrito_stock();
                $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
            } else {
                    $mensaje="No se pudo dar de alta el movimiento stock";
            }
        }
        //Egreso o Transferencia
        if (($_POST["tipo"] == "E") or ($_POST["tipo"] == "T")) {
            if ($resultado2>0){
                $mensaje="El movimiento stock se dio de alta correctamente";
                $_SESSION["ocarrito_stock"] = new carrito_stock();
                $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
            } else {
                    $mensaje="No se pudo dar de alta el movimiento stock";
            }
        }
    }//enviar
  }//else($mensajeError!="")
}//POST
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
                <input name="fecha" id="fecha" type="text" class="campos" size="10" value="<?php print $_SESSION["fecha"];?>" />
            </td>
            <td class="formTitle">REMITO</td>
            <td class="formFields">
                <input name="remito" id="remito" type="text" class="campos" size="10" value="<?php print $_SESSION["remito"];?>" />
            </td>
          <?php
          if (($tipo == "I") or ($tipo == "E")) {
          ?>
            <td class="formTitle">SUCURSAL</td>
            <td class="formFields">
                <?php 
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($_SESSION["suc_id"]);
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
                $html = $suc->getsucursalesCombo($_SESSION["suc_id"]);
                echo $html;
                ?>
            </td>
            <td class="formTitle">SUCURSAL DESTINO</td>
            <td class="formFields">
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html1 = $suc->getsucursales_desCombo($_SESSION["suc_des_id"]);
                echo $html1;
                ?>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td colspan="5" class="formFields">
                <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    $res = $tip->getTipComboMvtoStock($tip_id,$tipo);
                    print $res;
                ?>
                <input type="hidden" id="tip_id" name="tip_id" value="<?php echo $tip_id;?>" />
            </td>
          </tr>
          <?php
          //echo"tip_id:".$tip_id;
          if ($tip_id!='') {
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
          <?php
            //Neumaticos:
            if ($tip_id==4) {
          ?>
              <tr>
                <td class="formTitle">ALTO</td>
                <td><input type="text" name="pro_med_alto" id="pro_med_alto" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_alto;?>" /></td>
          <?php
            //Llantas_deportivas/Llantas_originales/Llantas Replicas:
            } elseif (($tip_id==3 || $tip_id==2) or ($tip_id==9)) {
          ?>
              <tr>
                <td class="formTitle">DISTRIBUCION</td>
                <td><input type="text" name="pro_distribucion" id="pro_distribucion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_distribucion;?>" /></td>
          <?php
            } 
          ?>
          <?php
            //Neumaticos-Llantas_deportivas/Llantas_originales/Llantas Replicas:
            if (($tip_id==4) or (($tip_id==3 || $tip_id==2) or ($tip_id==9))) {
          ?>
                <td class="formTitle">ANCHO</td>
                <td><input type="text" name="pro_med_ancho" id="pro_med_ancho" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_ancho;?>" /></td>
                <td class="formTitle">DIAMETRO</td>
                <td><input type="text" name="pro_med_diametro" id="pro_med_diametro" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_diametro;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">RANGO</td>
                <td>
                    <?php
                        include_once 'class/tipo_rango.php';
                        $tpr = new tipo_rango();
                        $res = $tpr->gettipo_rangoComboNulo($tr_id);
                        print $res;
                    ?>
                </td>
                <td class="formTitle">ESTADO</td>
                <td>
                <select name='estados' id='estados' class='formFields' >
                <?php if ($pro_nueva=='1'){?>
                    <option value=''></option>
                    <option value='1' selected>Nuevo</option>
                    <option value='0'>Usado</option>
                <?php } elseif ($pro_nueva=='0'){?>
                    <option value=''></option>
                    <option value='1'>Nuevo</option>
                    <option value='0' selected>Usado</option>
                <?php } else {?>
                    <option value='' selected></option>
                    <option value='1'>Nuevo</option>
                    <option value='0'>Usado</option>
                <?php }?>
                </select>
                </td>
              </tr>
          <?php
            }
          ?>
              <tr>
                <td colspan="6" align="center" class="formFields">
                  <input id="filtrar" name="filtrar" type="submit" class="boton" value="Filtrar" ></input>
                </td>
              </tr>
            <?php
            if (isset($_POST['filtrar']) or isset($_POST['agregar'])) {
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
                                ,$pro_distribucion,$tr_id,$pro_nueva,$pro_med_alto,'',$tipo,$_SESSION["suc_id"]);
                        print $res;
                     } else {
                        print '<select disabled="disabled" name="productos_ms" id="productos_ms">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                     }
                    }
                    ?>
                </td>
            <?php
            }//(isset($_POST['filtrar']) or isset($_POST['agregar']))
          }//if ($tip_id!='')
          ?>
            <td class="formTitle">CANTIDAD</td>
            <td class="formFields">
                <input name="cantidad" id="cantidad" type="text" class="campos" size="20" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields">
                <textarea id="observaciones" name="observaciones" rows="1" cols="30" onkeyup="this.value=this.value.toUpperCase()"></textarea>
            </td>
          </tr>
          <tr>
            <td colspan="6" align="center" class="formFields">
              <!--<input id="agregar" name="agregar" type="submit" class="boton" value="Agregar" />-->
              <input type="button" id="btn_agregar" name="btn_agregar" class="boton" value="Agregar" onclick="agregar();" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="rowGris">Código</td>
            <td class="rowGris">Descripción</td>
            <td class="rowGris">Cantidad</td>
            <td class="rowGris">Observaciones</td>
            <td class="rowGris"></td>
          </tr>
            <?php
            $mostrar = $_SESSION["ocarrito_stock"]->imprime_carrito($tipo,$tip_id,$_SESSION["suc_id"]);
            echo $mostrar;
            ?>
          <tr>
            <td colspan="6" align="center" class="formFields">
              <input id="enviar" name="enviar" type="submit" class="boton" value="Enviar" />
              <a href="alta_movimientos_stock.php?tipo=<?php echo$tipo;?>&tip_id=<?php echo$tip_id;?>&limpiar_form=S">
                  <input class="boton" type="button" value="Limpiar" />
              </a>
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
    </form>
    <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
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

    var fecha = document.getElementById('fecha').value;
    var suc_id = document.getElementById('sucursales').value;
    if(tipo=='T'){
        var suc_des_id = document.getElementById('sucursales_des').value;
    }else{
        var suc_des_id =0;
    }
    if(opcionSeleccionada!=0)
    {
        // Obtengo el elemento del select que debo cargar
        var idSelectDestino=listadoSelects[posicionSelectDestino];
        var selectDestino=document.getElementById(idSelectDestino);
        location.href = 'alta_movimientos_stock.php?tipo='+tipo+'&tip_id='+opcionSeleccionada+'&fecha='+fecha+'&suc_id='+suc_id+'&suc_des_id='+suc_des_id;
    }
  }
</script>
<script type="text/javascript" language="JavaScript">
function agregar(){
  var posicion=document.getElementById('productos_ms').options.selectedIndex; //posicion
  var descripcion=(document.getElementById('productos_ms').options[posicion].text); //valor
  var pro_id=(document.getElementById('productos_ms').options[posicion].value); //valor
  var cantidad = document.getElementById('cantidad').value;
  var observaciones = document.getElementById('observaciones').value;
  var sucursal = document.getElementById('sucursales').value;
  var tipo = document.getElementById('tipo').value;
  var tip_id = document.getElementById('tip_id').value;
  /*$_SESSION["suc_id"] = sucursal;
  alert ('Valor:' + sucursal);*/
  location.href = 'class/agregar_carrito_stock.php?pro_id=' + pro_id + '&pro_descripcion=' + descripcion 
      + '&pro_cantidad=' + cantidad + '&observaciones=' + observaciones + '&sucursal=' + sucursal + '&tipo=' + tipo
      + '&tip_id=' + tip_id;
}
</script>
</body>
</html>