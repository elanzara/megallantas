<?php
include_once 'class/lib_carrito.php';
include_once 'class/session.php';
include_once 'class/fechas.php';
?>
<!DOCTYPE html>
<?php
include_once 'class/orden_trabajo_enc.php'; // incluye las clases
include_once 'class/orden_trabajo_det.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/clientes.php';
include_once 'class/vehiculos.php';

$mensaje="";

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (($_GET["cli_id"]=='') and ($_GET["veh_id"]=='') and (isset($_POST["agregar"]))){
            echo'1111';
        $_SESSION["cli_id"] = "";
        $_SESSION["cli_tipo_documento"] = "";
        $_SESSION["cli_numero_documento"] = "";
        $_SESSION["cli_cuit"] = "";
        $_SESSION["cli_nombre"] = "";
        $_SESSION["cli_apellido"] = "";
        $_SESSION["cli_razon_social"] = "";

        $_SESSION["veh_id"] = "";
        $_SESSION["mar_descripcion"] = "";
        $_SESSION["mod_descripcion"] = "";
        $_SESSION["veh_patente"] = "";
        $_SESSION["veh_km"] = "";

        if ($_SESSION["ot_numero"]!=0 and $_SESSION["cli_id"]!='' and $_SESSION["veh_id"]!=''){
            $_SESSION["ot_numero"] = 0;
        }
    }
    if ($_GET["limpiar_form"]=='S'){
        $_SESSION["ocarrito"] = new carrito();
        $_SESSION["ot_numero"] = 0;
    }

}
$tip_id = "";
$pro_id = "";

if ($_SESSION["ot_numero"]==0){
    $ot = new orden_trabajo_enc();
    $ot_numero = $ot->getNumeroOrden(1);
    $_SESSION["ot_numero"]= $ot_numero;
    $_SESSION["fecha"]=date("Y")."/".date("m")."/".date("d");
} else {
    $ot_numero = $_SESSION["ot_numero"];
    $_SESSION["fecha"]=date("Y")."/".date("m")."/".date("d");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";

    /*validaciones*/
    if (isset($_SESSION["veh_id"])) {
        if ($_SESSION["veh_id"]=="") {
            $mensajeError .= "Falta completar el campo Vehiculo.</br>";
        }
    }else{
            $mensajeError .= "Falta completar el campo Vehiculo.</br>";
    }
    if (isset($_SESSION["cli_id"])) {
        if ($_SESSION["cli_id"]=="") {
            $mensajeError .= "Falta completar el campo Cliente.</br>";
        }
    }else{
            $mensajeError .= "Falta completar el campo Cliente.</br>";
    }
    if (isset($_SESSION["ot_numero"])) {
        if ($_SESSION["ot_numero"]=="") {
            $mensajeError .= "Falta completar el campo Número.</br>";
        }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {

    	//Instancio el objeto
        $ote = new orden_trabajo_enc();
	//Seteo las variables
        ///$ote->set_usuarios_usu_id($usuarios_usu_id);
        $ote->set_veh_id($_SESSION["veh_id"]);
        $ote->set_cli_id($_SESSION["cli_id"]);
        $ote->set_fecha($_SESSION["fecha"]);
        $ote->set_numero($_SESSION["ot_numero"]);
        ///$ote->set_suc_id($suc_id);
    	//Inserto el registro
    	$resultado=$ote->insert_ote();

        $cantidad = $_SESSION["ocarrito"]->get_num_productos();
        for ($i=0;$i<$cantidad;$i++){
            $rec= $_SESSION["ocarrito"]->recupera_linea($i);
            $pde = new orden_trabajo_det();
            $pde->set_pro_id($rec[1]);
            $pde->set_cantidad($rec[3]);
            $pde->set_precio($rec[4]);
            $pde->set_ote_id($resultado);
            $resultado2=$pde->insert_otd();
        }
    	if ($resultado>0 and $resultado2>0){
    		$mensaje="La orden se dio de alta correctamente";
    	} else {
    		$mensaje="No se pudo dar de alta la orden";
    	}
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["cli_id"])){
        $cli_id = $_GET["cli_id"];
        $_SESSION["cli_id"] = $cli_id;
        $cli = new clientes($cli_id);
        $_SESSION["cli_tipo_documento"] = $cli->get_cli_tipo_documento();
        $_SESSION["cli_numero_documento"] = $cli->get_cli_numero_documento();
        $_SESSION["cli_cuit"] = $cli->get_cli_cuit();
        $_SESSION["cli_nombre"] = $cli->get_cli_nombre();
        $_SESSION["cli_apellido"] = $cli->get_cli_apellido();
        $_SESSION["cli_razon_social"] = $cli->get_cli_razon_social();  
    }
    if (isset($_GET["veh_id"])){
        $veh_id = $_GET["veh_id"];
        $_SESSION["veh_id"] = $veh_id;
        $veh = new vehiculos($veh_id);
//        $_SESSION["cli_tipo_documento"] = $cli->get_cli_tipo_documento();
//        $_SESSION["cli_numero_documento"] = $cli->get_cli_numero_documento();
        $_SESSION["veh_patente"] = $veh->get_veh_patente();
        $_SESSION["veh_km"] = $veh->get_veh_km();
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php //include_once("inc/inc_ot.php"); ?>

<script language="JavaScript">
function f(campo){
var posicion=document.getElementById('productos').options.selectedIndex; //posicion
var descripcion=(document.getElementById('productos').options[posicion].text); //valor
var pro_id=(document.getElementById('productos').options[posicion].value); //valor
var cantidad = document.getElementById('cantidad').value;
/*alert ('Valor:' + cantidad);*/
location.href = 'class/agregar_carrito.php?pro_id=' + pro_id + '&pro_descripcion=' + descripcion + '&pro_cantidad=' + cantidad;
var input = document.getElementById(campo);
input.value = 'S';
}
</script>


</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de Orden de trabajo </h1>
   <!--Start FORM -->
   <div class="containmsg">
     <!--<form action="alta_orden_trabajo.php" method="POST" enctype="multipart/form-data">-->
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">NUMERO</td>
            <td class="formFields">
                <input name="NUMERO" id="NUMERO" type="text" class="campos" size="10" value="<?php print $ot_numero;?>" />
            </td>
            <td class="formTitle">FECHA</td>
            <td class="formFields">
                <input name="FECHA" id="FECHA" type="text" class="campos" size="10" value="<?php print date('d-m-y');?>" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <form action="busca_cliente.php" method="get">
               <table align="center" cellpadding="0" cellspacing="1" class="formMedIz">
                  <tr>
                    <td colspan="6" class="formTitle">CLIENTE</td>
                  </tr>
                  <tr>
                    <td class="formTitle">CÓDIGO</td>
                    <td class="formFields">
                        <input name="cli_id" id="cli_id" type="text" class="campos" size="10" value="<?php print $_SESSION["cli_id"];?>" />
                    </td>
                    <td class="formTitle">T.DOC</td>
                    <td class="formFields">
                        <input name="cli_tipo_documento" id="cli_tipo_documento" type="text" class="campos" size="10" value="<?php print $_SESSION["cli_tipo_documento"];?>"/>
                    </td>
                    <td class="formTitle">NUMERO</td>
                    <td class="formFields">
                        <input name="cli_numero_documento" id="cli_numero_documento" type="text" class="campos" size="10" value="<?php print $_SESSION["cli_numero_documento"];?>"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="formTitle">R. SOCIAL</td>
                    <td class="formFields">
                        <input name="cli_razon_social" id="cli_razon_social" type="text" class="campos" size="10" value="<?php print $_SESSION["cli_razon_social"];?>"/>
                    </td>
                    <td class="formTitle">APELLIDO</td>
                    <td class="formFields">
                        <input name="cli_apellido" id="cli_apellido" type="text" class="campos" size="10" value="<?php print $_SESSION["cli_apellido"];?>"/>
                    </td>
                    <td class="formTitle">NOMBRE</td>
                    <td class="formFields">
                        <input name="cli_nombre" id="cli_nombre" type="text" class="campos" size="10" value="<?php print $_SESSION["cli_nombre"];?>"/>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="formFields">
                      <input type="submit" class="boton" value="Buscar Cliente" /><!--class="compose"<a href="busca_cliente.php"></a>-->
                      <a href="alta_orden_trabajo.php"><input class="boton" type="button" value="Limpiar" /></a>
                    </td>
                  </tr>
               </table>
            </form>
            <form action="busca_vehiculo.php" method="get">
               <table align="center" cellpadding="0" cellspacing="1" class="formMedDer">
                  <tr>
                    <td colspan="4" class="formTitle">VEHICULO</td>
                  </tr>
                  <tr>
                    <input name="cli_id" id="cli_id" type="hidden" class="campos" size="10" value="<?php print $_SESSION["cli_id"];?>" />
                    <input name="veh_id" id="veh_id" type="hidden" class="campos" size="10" value="<?php print $_SESSION["veh_id"];?>" />
                    <td class="formTitle">MARCA</td>
                    <td class="formFields">
                        <input name="mar_descripcion" id="mar_descripcion" type="text" class="campos" size="20" value="<?php print $_SESSION["mar_descripcion"];?>" />
                    </td>
                    <td class="formTitle">MODELO</td>
                    <td class="formFields">
                        <input name="mod_descripcion" id="mod_descripcion" type="text" class="campos" size="20" value="<?php print $_SESSION["mod_descripcion"];?>" />
                    </td>
                </tr>
                <tr>
                    <td class="formTitle">PATENTE</td>
                    <td class="formFields">
                        <input name="veh_patente" id="veh_patente" type="text" class="campos" size="10" value="<?php print $_SESSION["veh_patente"];?>" />
                    </td>
                    <td class="formTitle">KM.</td>
                    <td class="formFields">
                        <input name="veh_km" id="veh_km" type="text" class="campos" size="20" value="<?php print $_SESSION["veh_km"];?>" />
                    </td>
                  </tr>
                  <tr>
                  	<td colspan="2" align="center" class="formFields">
               		  <input type="submit" class="boton" value="Buscar Vehiculo" />
                  	</td>
                  </tr>
               </table>
            </form>
          </tr>
       </table>
       <form action="alta_orden_trabajo.php" method="POST" enctype="multipart/form-data">
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DETALLE</td>
          </tr>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td class="formFields">
                <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    $res = $tip->getTipCombo($tip_id);
                    print $res;
                    //echo'tip_id;'.$tip_id;
                ?>
            </td>
            <td class="formTitle">CODIGO PRODUCTO</td>
            <td class="formFields">
                <?php
                if (isset($tip_id)) {
                 if ($tip_id!="") {
                    include_once 'class/productos.php';
                    $pro = new productos();
                    $res = $pro->getproductosCombo($pro_id);
                    print $res;
                 } else {
                    print '<select class="formFields" disabled="disabled" name="productos" id="productos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
                }
                 ?>
            </td>
            <td class="formTitle">CANTIDAD</td>
            <td class="formFields">
                <input type="text" id="cantidad" name="cantidad" value="0" />
            </td>
            <td align="center" class="formFields">
              <input type="text" name="" id="agregar" />
              <input type="button" class="boton" value="Agregar" onclick="f('agregar');" />
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
            <td class="rowGris">I.V.A.</td>
          </tr>
            <?php
            $mostrar = $_SESSION["ocarrito"]->imprime_carrito2();
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
                <input name="BRUTO" id="BRUTO" type="text" class="campos" size="40" value="<?php echo $_SESSION["ocarrito"]->get_total_bruto();?>" />
            </td>
            <td class="formTitle">I.V.A.</td>
            <td class="formFields">
                <input name="IVA" id="IVA" type="text" class="campos" size="40" value="<?php echo $_SESSION["ocarrito"]->get_total_iva();?>" />
            </td>
            <td class="formTitle">NETO</td>
            <td class="formFields">
                <input name="NETO" id="NETO" type="text" class="campos" size="40" value="<?php echo $_SESSION["ocarrito"]->get_total();?>" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields" align="left">
                <textarea name="OBSERVACIONES" id="OBSERVACIONES" cols="100" rows="3" style="text-align: left;" ></textarea>
            </td>
          </tr>
       </table>

       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Guardar" />
              <a href="alta_orden_trabajo.php?limpiar_form=S"><input class="boton" type="button" value="Limpiar" /></a>
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
<script type="text/javascript" src="select_dependientes_tip.js"></script>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}
</script>

</body>
</html>