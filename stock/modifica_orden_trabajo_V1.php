<?php
include_once 'class/lib_carrito.php';
include_once 'class/session.php';
include_once 'class/fechas.php';
?>
<!DOCTYPE html>
<?php
include_once 'class/conex.php';
include_once 'class/orden_trabajo_enc.php'; // incluye las clases
include_once 'class/orden_trabajo_det.php'; // incluye las clases
include_once 'class/clientes.php';
include_once 'class/vehiculos.php';
include_once 'class/productos.php';
include_once 'class/movimientos_stock.php';
include_once 'class/promociones.php';
include_once 'class/marcas.php';
include_once 'class/modelos.php';

//echo"sess-suc_id:".$_SESSION["suc_id"]."</br>";
$mensaje="";
$mensajeError="";

$cli_razon_social = "";
$cli_id="";
$cli_apellido="";
$cli_nombre="";
$mar_id="";
$mod_id="";
$veh_patente = "";
$veh_km = "";
$tip_id = "";
$pro_id = "";
$pro_id_seleccion = ""; 
$pro_descripcion_seleccion = "";
$pmo_id = 0;

$precio = (isset($_GET['precio'])) ? (double) $_GET['precio'] : 0;
$cantidad = (isset($_GET['cantidad'])) ? (double) $_GET['cantidad'] : 0;
$descuento = (isset($_GET['descuento'])) ? (double) $_GET['descuento'] : 0;
if ($_SESSION["fecha"]=='') {
    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
}
if (isset($_GET["suc_id"])){
    $_SESSION["suc_id"] = $_GET["suc_id"];
} elseif (isset($_GET["sucursales"])){
    $_SESSION["suc_id"] = $_GET["sucursales"];
} elseif (isset($_POST["sucursales"])){
    $_SESSION["suc_id"] = $_POST["sucursales"];
} elseif ($suc_id!=''){
    $_SESSION["suc_id"] = $suc_id;
}


/*CARGA LOS DATOS DE LA OT*/
if (isset($_GET['md'])) {
    $modif =  (isset($_GET['modif'])) ? $_GET['modif'] : 'N';
    $ote = new orden_trabajo_enc($_GET['md']);
    $_SESSION["ote_id"] = $_GET['md'];
    $_SESSION["suc_id"] = $ote->get_suc_id();
    $_SESSION["cli_id"] = $ote->get_cli_id();
    $_SESSION["veh_id"] = $ote->get_veh_id();
    $_SESSION["fecha"]= $ote->get_fecha();
    $_SESSION["observaciones"] = $ote->get_observaciones();
    $_SESSION["realizo"] = $ote->get_realizo();
    $_SESSION["numero"] = $ote->get_numero();
    $_SESSION["pmo_id"] = $ote->get_pmo_id();
    $_SESSION["ocarrito"] = new carrito();
    $otd = new orden_trabajo_det();

    //$sql = $otd->getorden_trabajo_det_X_ote_id($_SESSION["ote_id"]);
    //$link=Conectarse();
    //$consulta= mysql_query($sql, $link);
    $consulta = $otd->getorden_trabajo_det_X_ote_id($_SESSION["ote_id"]);
    while($row= mysql_fetch_assoc($consulta)) {
        /*Buscar el estado por cada pro_id y concatenarlo a la descripcion*/
       $pro_bus = new productos($row['pro_id']);
       $pro_nueva_bus = $pro_bus->get_pro_nueva();
       if ($pro_nueva_bus == 1){
            $nueva_bus = " - Nuevo";
       } else {
            $nueva_bus = " - Usado";
       }
       $_SESSION["ocarrito"]->introduce_producto($row['pro_id'], $row['pro_descripcion'].$nueva_bus, $row['cantidad'],$row['precio'],0);//$pro_descuento );
       //header ("location: class/agregar_carrito.php?esModificacion='SI'&pro_id=".$row['pro_id']."&pro_descripcion=''&pro_cantidad=".$row['cantidad']."&sucursal=''&cli_id=".$_SESSION["cli_id"]."&veh_id=".$_SESSION["veh_id"]."&tip_id=''&pro_id=".$row['pro_id']."&precio=".$row['precio']."&pro_descuento=0");
    }
       
}
/*FIN CARGA LOS DATOS DE LA OT*/
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //echo"1";
    if (isset($_GET['cli_id'])) {
          $_SESSION["cli_id"] = $_GET['cli_id'];
    }
    if (isset($_GET['veh_id'])) {
          $_SESSION["veh_id"] = $_GET['veh_id'];
    }
    if (isset($_GET['tip_id'])) {
          $tip_id = $_GET['tip_id'];
    }
    if (isset($_GET['pro_id'])) {
          $pro_id = $_GET['pro_id'];
    }
    if (isset($_GET['observaciones'])) {
          $_SESSION["observaciones"] = $_GET['observaciones'];
    }
  /*  if (isset($_GET['realizo'])) {
          $_SESSION["realizo"] = $_GET['realizo'];
    }*/

    if ($_GET["error"]==1) {
        $mensajeError .= "La cantidad debe ser mayor a cero.</br>";
    }
    if ($_GET["error"]==2) {
        $mensajeError .= "La cantidad ingresada excede el stock del producto (".$_GET["stock"].").</br>";
    }
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    }

    $pro_id_seleccion = (isset($_GET['pro_id_seleccion'])) ? (int) $_GET['pro_id_seleccion'] : 0; 
    $tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
    $pmo_id = (isset($_GET['promociones'])) ? (int) $_GET['promociones'] : 0;
    if ($pmo_id>0){$_SESSION["pmo_id"] = $pmo_id;}
    if ($pro_id_seleccion != 0){
        
        $pro_sel = new productos($pro_id_seleccion);
        $descripcion = $pro_sel->get_pro_descripcion();
        $med_diametro = $pro_sel->get_pro_med_diametro();
        $med_ancho = $pro_sel->get_pro_med_ancho();
        $med_alto = $pro_sel->get_pro_med_alto(); 
        $distribucion = $pro_sel->get_pro_distribucion();
        $pro_mar_id = $pro_sel->get_mar_id();
        $pro_mod_id = $pro_sel->get_mod_id();
        
        $pro_mar = new marcas($pro_mar_id);
        $pro_marca = $pro_mar->get_mar_descripcion();
        
        $pro_mod = new modelos($pro_mod_id);
        $pro_modelo = $pro_mod->get_mod_descripcion();  
        
        $pro_estado_seleccion = $pro_sel->get_pro_nueva();
        if ($pro_estado_seleccion == 1){
            $estado_pro = " - Nuevo";
        } else {
            $estado_pro = " - Usado";
        }
        
        switch ($tip_id){
            case 9: 
                $pro_descripcion_seleccion = "Llanta original ". $estado_pro . " " . $pro_marca . " " . $pro_modelo . " " . $med_diametro . "-" . $med_ancho . "-" . $distribucion . " " . $descripcion;
                break;
            case 2: 
                $pro_descripcion_seleccion = "Llanta deportiva ". $estado_pro . " " . $med_diametro . "-" . $med_ancho . "-" . $distribucion . " " . $descripcion;
                break;
            case 4: 
                $pro_descripcion_seleccion = "Neumático ". $estado_pro . " " . $pro_marca . " " . $pro_modelo . " " . $med_ancho . "-" . $med_alto . "-" . $med_diametro . " " . $descripcion;
                break;
            default:
                $pro_descripcion_seleccion = $descripcion;
                break;
        }
    } 
    

    if ($_GET["limpiar_form"]=='S'){
    //echo"4";
        $_SESSION["ocarrito"] = new carrito();
        $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
        $_SESSION["observaciones"] = "";
        $_SESSION["numero"]= "";
        $_SESSION["cli_id"] = "0";
        $_SESSION["veh_id"] = "";
        $_SESSION["suc_id"] = "";
        $_SESSION["realizo"] = "";
        $_SESSION["pmo_id"] = "0";
    }
}//($_SERVER["REQUEST_METHOD"] == "GET")

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    if (isset($_POST['filtrar_cli'])) {
        //echo"Pfiltro-t:".$_POST['tip_id'];
        $_SESSION["cli_id"] = $_POST['clientes'];
        $cliB = new clientes($_POST['clientes']);
        $cli_razon_social = $cliB->get_cli_razon_social();
        $cli_apellido = $cliB->get_cli_apellido();
        $cli_nombre= $cliB->get_cli_nombre();
        //$cli_razon_social = $_POST['cli_razon_social'];
        //$cli_apellido = $_POST['cli_apellido'];
        //$cli_nombre= $_POST['cli_nombre'];
    }
    if (isset($_POST['filtrar_veh'])) {
        //$_SESSION["cli_id"] = $_POST['clientes'];
/*        if (isset($_SESSION["cli_id"])) {
            if ($_SESSION["cli_id"]=="" or $_SESSION["cli_id"]=="0") {
                $mensajeError .= "Falta completar el campo Cliente.</br>";
            }
        }else{
                $mensajeError .= "Falta completar el campo Cliente.</br>";
        }
*/
        $_SESSION["veh_id"] = $_POST['vehiculos'];
        $veh = new vehiculos($_SESSION["veh_id"]);
        $mar_id = $veh->get_mar_id();//$_POST['marcas'];
        $mod_id = $veh->get_mod_id();//$_POST['modelos'];
        $veh_patente= $veh->get_veh_patente();//$_POST['veh_patente'];
        $veh_km= $veh->get_veh_km();//$_POST['veh_km'];
        if ($_SESSION["cli_id"]=="" or $_SESSION["cli_id"]=="0") {
            $_SESSION["cli_id"] = $veh->get_cli_id();
            $cliB = new clientes($_SESSION["cli_id"]);
            $cli_razon_social = $cliB->get_cli_razon_social();
            $cli_apellido = $cliB->get_cli_apellido();
            $cli_nombre= $cliB->get_cli_nombre();
            } 
    }
    if (isset($_POST['btn_guardar'])) {
        /*validaciones*/
        $_SESSION["cli_id"] = $_POST['clientes'];
        if (isset($_SESSION["cli_id"])) {
            if ($_SESSION["cli_id"]=="" or $_SESSION["cli_id"]=="0") {
                $mensajeError .= "Falta completar el campo Cliente.</br>";
            }
        }else{
                $mensajeError .= "Falta completar el campo Cliente.</br>";
        }
        $_SESSION["veh_id"] = $_POST['vehiculos'];
        if (isset($_SESSION["veh_id"])) {
            if ($_SESSION["veh_id"]=="" or $_SESSION["veh_id"]=="0") {
                $mensajeError .= "Falta completar el campo Vehiculo.</br>";
            }
        }else{
                $mensajeError .= "Falta completar el campo Vehiculo.</br>";
        }
        /*validaciones*/
    }//(isset($_POST["btn_guardar"]))
   
    if ($mensajeError!="") {
            $mensaje = $mensajeError;
    } else {
        if (isset($_POST["btn_guardar"])) {
          $_SESSION["observaciones"] = $_POST["observaciones"];
          $_SESSION["realizo"] = $_POST["realizo"];
          $_SESSION["pmo_id"] = $_POST["promociones"];
          
          $cantidad = $_SESSION["ocarrito"]->get_num_productos();
          //echo'cant:'.$cantidad;
          if($cantidad!='' and $cantidad>0){
            //Instancio el objeto
            $ote = new orden_trabajo_enc($_SESSION["ote_id"]);
            //Seteo las variables
            ///$ote->set_usuarios_usu_id($usuarios_usu_id);
            $fechasql = new fechas();
            $f = $_POST['fecha'];
            $fechaconv =$fechasql->cambiaf_a_mysql($f);
            //$ote->set_fecha($fechaconv);
            $ote->set_suc_id($_SESSION["suc_id"]);
            //$_SESSION["numero"] = $ote->getNumeroOrden($_SESSION["suc_id"]);
            $ote->set_numero($_SESSION["numero"]);
            $ote->set_veh_id($_SESSION["veh_id"]);
            $ote->set_cli_id($_SESSION["cli_id"]);
            $ote->set_observaciones($_SESSION["observaciones"]);
            $ote->set_realizo($_SESSION["realizo"]);
            $ote->set_pmo_id($_SESSION["pmo_id"]);
            //Inserto el registro
            $resultado=$ote->update_ote();
            
            $ote->EliminaMovimientosDet($_SESSION["ote_id"]);
            
            for ($i=0;$i<$cantidad;$i++){
              $rec= $_SESSION["ocarrito"]->recupera_linea($i);
              if ($rec[1]!='' and $rec[1]!=0){
                $pde = new orden_trabajo_det();
                $pde->set_pro_id($rec[1]);
                $pde->set_cantidad($rec[3]);
                $pde->set_precio($rec[4]);
                $pde->set_ote_id($_SESSION["ote_id"]);
                $resultado2=$pde->insert_otd();
                
                $mov = new movimientos_stock();
                if ($i<1){
                    $encabezado_id = $mov->getNumeroEncabezado();
                }
                $mov->set_tim_id(2);
                $mov->set_suc_id($_SESSION["suc_id"]);
                $mov->set_pro_id($rec[1]);
                $mov->set_fecha($fechaconv);
                $mov->set_cantidad($rec[3]);
                $mov->set_observaciones('O.T. Nro.:'.$_SESSION["numero"]);
                $mov->set_encabezado_id($encabezado_id);
                $mov->set_ote_id($_SESSION["ote_id"]);
                $mov->insert_mov();  
                
              }//($rec[1]!='' and $rec[1]!=0)
            }//for

            if ($resultado>0 and $resultado2>0){
                    $mensaje="La orden se modifico correctamente con el número:".$_SESSION["numero"];
                    $_SESSION["ocarrito"] = new carrito();
                    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
                    $_SESSION["observaciones"] = "";
                    $_SESSION["cli_id"] = "0";
                    $_SESSION["veh_id"] = "";
                    $_SESSION["numero"] = "";
                    $_SESSION["pmo_id"] = "0";
            } else {
                    $mensaje="No se pudo modificar la orden";
            }
          } else {
                $mensaje .= "Se debe ingresar al menos un detalle.</br>";
          }//($cantidad>0)
        }//(isset($_POST["btn_guardar"]))
    }//else
}//($_SERVER["REQUEST_METHOD"] == "POST")
    //echo"sess-suc_id:".$_SESSION["suc_id"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<?php
    if ($pro_id_seleccion != 0){?>
        <body onLoad="Irfoco('cantidad')">
<?php    }  else { ?>
        <body onLoad="Irfoco('numero')">
<?php    }
?>
<!--<body onLoad="Irfoco('numero')">-->
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Modificación de Orden de trabajo </h1>
   <!--Start FORM -->
   <div class="containmsg">
     <form action="modifica_orden_trabajo.php" method="POST" enctype="multipart/form-data">
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">NUMERO</td>
            <td class="formFields">
              <input name="numero" id="numero" type="text" class="campos" size="10" readonly value="<?php print $_SESSION["numero"];?>" />
            </td>
            <td class="formTitle">FECHA</td>
            <td class="formFields">
              <input name="fecha" id="fecha" type="text" class="campos" size="10" value="<?php print $_SESSION["fecha"];?>" />
            </td>
            <td class="formTitle">SUCURSAL</td>
            <td class="formFields">
                <?php
//    echo"sess-suc_id:".$_SESSION["suc_id"]." suc_id:".$suc_id;
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($_SESSION["suc_id"]);
                echo $html;
                ?>
            </td>
            <td class="formTitle">PROMOCION</td>
            <td class="formFields">
                <?php
//    echo"sess-suc_id:".$_SESSION["suc_id"]." suc_id:".$suc_id;
                include_once 'class/promociones.php';
                $pmo = new promociones();
                $html = $pmo->getPromocionesCombo($_SESSION["pmo_id"]);
                echo $html;
                ?>
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
             <table align="left" cellpadding="0" cellspacing="1" class="formMedIz">
                <tr>
                  <td class="formTitle">CLIENTE</td>
                  <td class="formFields" colspan="3">
                        <?php
                        include_once 'class/clientes.php';
                        $cli = new clientes();
                        if($cli_razon_social=='' and $cli_apellido=='' and $cli_nombre==''){
                            $res = $cli->getclientesComboNulo($_SESSION["cli_id"]);
                        }else{
                            $res = $cli->getclientesCombo_OT($cli_razon_social,$cli_apellido,$cli_nombre);
                        }
                        print $res;
                        ?>
                  </td>
                  <td class="formFields">
                    <input id="filtrar_cli" name="filtrar_cli" type="submit" class="boton" value="Filtrar" ></input>
                  </td>
                </tr>
<!--                <tr>
                  <td class="formTitle">R.SOCIAL</td>
                  <td class="formFields">
                    <input name="cli_razon_social" id="cli_razon_social" type="text" class="campos" size="10" value="<?php //print $cli_razon_social;?>"/>
                  </td>
                </tr>
                <tr>
                  <td class="formTitle">APELLIDO</td>
                  <td class="formFields">
                    <input name="cli_apellido" id="cli_apellido" type="text" class="campos" size="10" value="<?php //print $cli_apellido;?>"/>
                  </td>
                  <td class="formTitle">NOMBRE</td>
                  <td class="formFields">
                    <input name="cli_nombre" id="cli_nombre" type="text" class="campos" size="10" value="<?php //print $cli_nombre;?>"/>
                  </td>
                </tr>
-->             </table>
             <table align="center" cellpadding="0" cellspacing="1" class="formMedDer">
                <tr>
                  <td class="formTitle">VEHICULO</td>
                  <td class="formFields">
                    <?php
                    include_once 'class/vehiculos.php';
                    $veh = new vehiculos();
                    if(($mar_id=='' or $mar_id=='0') and ($mod_id=='' or $mod_id=='0') and $veh_patente==''
                        and $veh_km==''){
                        if ($_SESSION["cli_id"]==0){
                            $res = $veh->getvehiculosComboNulo();
                        } else {
                            $res = $veh->getvehiculosComboNuloxCliId($_SESSION["cli_id"],$_SESSION["veh_id"]);
                            }
                    }else{
                        $res = $veh->getvehiculosCombo_OT($_SESSION["cli_id"],$mar_id,$mod_id,$veh_patente,$veh_km);
                    }
                    print $res;
                    ?>
                  </td>
                  <td class="formFields">
                     <input id="filtrar_veh" name="filtrar_veh" type="submit" class="boton" value="Filtrar" ></input>
                  </td>
                </tr>
<!--                <tr>
                  <td class="formTitle">MARCA</td>
                  <td class="formFields">
                        <?php
/*                        include_once 'class/marcas.php';
                        $mar = new marcas();
                        $html = $mar->getmarcasComboNuloTodos($mar_id,'N');
                        echo $html;
*/                        ?>
                  </td>
                  <td class="formTitle">MODELO</td>
                  <td class="formFields">
                        <?php
/*                        include_once 'class/modelos.php';
                        $mod = new modelos();
                        $res = $mod->get_select_modelosNuloTodos($mod_id,'N');
                        print $res;
*/                        ?>
                  </td>
                </tr>
                <tr>
                  <td class="formTitle">PATENTE</td>
                  <td class="formFields">
                    <input name="veh_patente" id="veh_patente" type="text" class="campos" size="10" value="<?php //print $veh_patente;?>" />
                  </td>
                  <td class="formTitle">KM.</td>
                  <td class="formFields">
                     <input name="veh_km" id="veh_km" type="text" class="campos" size="20" value="<?php //print $veh_km;?>" />
                  </td>
                </tr>
-->             </table>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields" align="left">    
               <textarea name="observaciones" id="observaciones" cols="70" rows="2" style="text-align: left;" value='<?php print $_SESSION["observaciones"];?>' onkeyup="this.value=this.value.toUpperCase()" ><?php print $_SESSION["observaciones"];?></textarea>
            </td>
            <td class="formTitle">REALIZO</td>
            <td class="formFields" align="left">
                <input type="text" id="realizo" name="realizo" value="<?php print $_SESSION["realizo"]; ?>" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DETALLE:</td>
          </tr>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td class="formFields">
                <?php
                include_once 'class/tipo_productos.php';
                $tip = new tipo_productos();
                $res = $tip->getTipnuloComboOT($tip_id);
                print $res;
                ?>
            </td>
            <td class="formFields">
                <input type="button" id="busca_producto" name="busca_producto" class="boton" value="Buscar" onclick="seleccionar(<?php echo $_SESSION["suc_id"];?>);" />
            </td>
            <td class="formTitle">PRODUCTO</td>
            <td class="formFields" colspan="4">
               <input size="100" readonly="true" type="text" id="producto" name="producto" value="<?php echo $pro_descripcion_seleccion; ?>" />
            </td>
            <td id="oculto">   
               <input type="text" id="pro_id" name="pro_id" value="<?php echo $pro_id_seleccion; ?>" />
            </td>
          </tr>
          <tr>

          </tr>
          <tr>
            <td class="formTitle">CANTIDAD</td>
            <td class="formFields">
                <input type="text" id="cantidad" name="cantidad" value="<?php print $cantidad; ?>" />
            </td>
            <td class="formTitle">PRECIO</td>
            <td class="formFields">
                <input type="text" id="precio" name="precio" ondblclick="selectprecio();" value="<?php print $precio; ?>" />
            </td>
            <td class="formTitle">DESCUENTO(%)</td>
            <td class="formFields">
                <input type="text" id="descuento" name="descuento" value="<?php print $descuento; ?>" />
            </td>
            <td align="center" class="formFields">
              <input type="button" id="btn_agregar" name="btn_agregar" class="boton" value="Agregar" onclick="agregar();" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="rowGris">Código</td>
            <td class="rowGris">Descripción</td>
            <td class="rowGris">Cantidad</td>
            <td class="rowGris">Precio</td>
            <td class="rowGris">Dto.</td>
            <td class="rowGris">Importe</td>
<!--            <td class="rowGris">I.V.A.</td>-->
            <td class="rowGris"></td>
          </tr>
            <?php
            $mostrar = $_SESSION["ocarrito"]->imprime_carrito3();
            echo $mostrar;
            ?>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td colspan="6" class="formTitle">TOTAL</td>
          </tr>
          <tr>
            <td class="formTitle">BRUTO</td>
            <td class="formFields">
                <input name="BRUTO" id="BRUTO" type="text" class="campos" size="40" readonly value="<?php echo $_SESSION["ocarrito"]->get_total_bruto();?>" />
            </td>
<!--            <td class="formTitle">I.V.A.</td>
            <td class="formFields">
                <input name="IVA" id="IVA" type="text" class="campos" size="40" readonly value="<?php echo $_SESSION["ocarrito"]->get_total_iva();?>" />
            </td>-->
            <td class="formTitle">NETO</td>
            <td class="formFields">
                <input name="NETO" id="NETO" type="text" class="campos" size="40" readonly value="<?php echo $_SESSION["ocarrito"]->get_total();?>" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td colspan="2" align="center" class="formFields">
              <?php if ($modif != 's') {?>
              <input type="submit" id="btn_guardar" name="btn_guardar" class="boton" value="Guardar" />
              <a href="modifica_orden_trabajo.php?limpiar_form=S"><input class="boton" type="button" value="Cancelar" /></a>
              <?php }?>
              <a href='abm_orden_trabajo.php?limpiar_form=S'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_orden_trabajo.php?limpiar_form=S'" />
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
       <?php
       if (isset($_POST["mensaje"])) {
        	if ($_POST["mensaje"]!=""){
        		$mensaje=$_POST["mensaje"];
			echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
       }}
       ?>
     </form>
   </div>
   <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<script type="text/javascript" src="select_dependientes_tip_pro.js"></script>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}

</script>
<script type="text/javascript" language="JavaScript">
function selectprecio(){
    var pro_id= document.getElementById('pro_id').value;
    var tip_id=document.getElementById('tipo_productos').value;
    var suc_id=document.getElementById('sucursales').value; 

    var observaciones=document.getElementById('observaciones').value; 
    var realizo=document.getElementById('realizo').value; 
    var cantidad=document.getElementById('cantidad').value; 
    var descuento=document.getElementById('descuento').value; 
    
    window.open('seleccion_precio_producto.php?pro_id='+pro_id+'&tip_id='+tip_id+'&suc_id='+suc_id+'&observaciones='+observaciones+'&realizo='+realizo+'&cantidad='+cantidad+'&descuento='+descuento+'&esModificacion=S','Selecciona precio por producto','scrollbars=No,status=yes,width=400,height=200,left=200,top=150 1');    
}

function agregar(){
  //var posicion=document.getElementById('productos').options.selectedIndex; //posicion
  //var descripcion=(document.getElementById('productos').options[posicion].text); //valor
  //var pro_id=(document.getElementById('productos').options[posicion].value); //valor
  var pro_id= document.getElementById('pro_id').value;
  var descripcion=document.getElementById('producto').value;
  var cantidad = document.getElementById('cantidad').value;
  var sucursal = document.getElementById('sucursales').value;
  var cli_id = document.getElementById('clientes').value;
  var veh_id = document.getElementById('vehiculos').value;
  var tip_id = document.getElementById('tipo_productos').value;
  //var pro_id = document.getElementById('productos').value;
  var observaciones = document.getElementById('observaciones').value;
  var precio = document.getElementById('precio').value;
  var pro_descuento = document.getElementById('descuento').value;
  var realizo=document.getElementById('realizo').value;

  /*alert ('Valor:' + sucursal);*/
  location.href = 'class/agregar_carrito.php?esModificacion=SI&pro_id=' + pro_id + '&pro_descripcion=' + descripcion
      + '&pro_cantidad=' + cantidad + '&sucursal=' + sucursal + '&cli_id=' + cli_id + '&veh_id=' + veh_id
      + '&tip_id=' + tip_id + '&pro_id=' + pro_id + '&observaciones=' + observaciones + '&precio=' + precio +'&pro_descuento=' + pro_descuento+'&realizo='+realizo;
  /*var input = document.getElementById(campo);
  input.value = 'S';*/
}

function seleccionar(suc_id){
    //var posicion=document.getElementById('tipo_productos').options.selectedIndex.value; 
var posicion=document.getElementById('tipo_productos').value;
var suc_id=document.getElementById('sucursales').value; 
    var observaciones=document.getElementById('observaciones').value; 
    var realizo=document.getElementById('realizo').value; 
    
    if (posicion==2 || posicion==9){
        window.open('seleccion_producto.php?esModificacion=SI&tip_id='+posicion+'&suc_id='+suc_id+'&observaciones='+observaciones+'&realizo='+realizo,'Selecciona producto','scrollbars=No,status=yes,width=1200,height=400,left=200,top=150 1');    
    } else if(posicion==4){
        window.open('seleccion_producto_neum.php?esModificacion=SI&tip_id='+posicion+'&suc_id='+suc_id+'&observaciones='+observaciones+'&realizo='+realizo,'Selecciona producto','scrollbars=No,status=yes,width=1150,height=400,left=200,top=150 1');
    } else {
        window.open('seleccion_producto_gral.php?esModificacion=SI&tip_id='+posicion+'&suc_id='+suc_id+'&observaciones='+observaciones+'&realizo='+realizo,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
    }
    //window.open('seleccion_producto.php?tip_id='+posicion,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
}
</script>
</body>
</html>
