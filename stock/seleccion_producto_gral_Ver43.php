<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/marcas.php';
include_once 'class/modelos.php';
include_once 'class/productos.php';

$mensaje="";
$mar_id = 0;
$mod_id = 0;
$tip_id = 0;
$pro_med_diametro = "";
$pro_med_ancho = "";
$pro_distribucion = "";
$pro_nueva = 1;
$suc_id = 0;
$suc_des = 0;
$esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : 'NO';
$remito = (isset($_GET["remito"])) ? $_GET["remito"] : '';
$tipo =  (isset($_GET['tipo'])) ? $_GET['tipo'] : '';
$observaciones = (isset($_GET["observaciones"])) ? $_GET["observaciones"] : '';
$realizo = (isset($_GET["realizo"])) ? $_GET["realizo"] : '';

if ($tipo == "") {
    $tipo =  (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
}
if ($esModificacion == "NO") {
    $esModificacion = (isset($_POST['esModificacion'])) ? $_POST['esModificacion'] : 'NO';
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
    $suc_id = (isset($_GET['suc_id'])) ? (int) $_GET['suc_id'] : 0;
    $suc_des = (isset($_GET['suc_des_id'])) ? (int) $_GET['suc_des_id'] : 0;
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $tip_id = (isset($_POST['tip_id'])) ? (int) $_POST['tip_id'] : 0;
    $mar_id = (isset($_POST['marcas'])) ? (int) $_POST['marcas'] : 0;
    $mod_id = (isset($_POST['modelos'])) ? (int) $_POST['modelos'] : 0;
    /*Rodado*/$pro_med_diametro = (isset($_POST['rodados'])) ? (int) $_POST['rodados'] : 0;
    $pro_med_ancho = (isset($_POST['anchos'])) ? (int) $_POST['anchos'] : 0;
    $pro_distribucion = (isset($_POST['distribucion'])) ? (int) $_POST['distribucion'] : 0;
    $suc_id = (isset($_POST['suc_id'])) ? (int) $_POST['suc_id'] : 0;
    $suc_des = (isset($_POST['suc_des_id'])) ? (int) $_POST['suc_des_id'] : 0;
	$pro_nueva = (isset($_POST['pro_nueva'])) ? (int) $_POST['pro_nueva'] : 1;
    $tipo =  (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
    $remito = (isset($_POST["remito"])) ? $_POST["remito"] : '';
    $observaciones = (isset($_POST["observaciones"])) ? $_POST["observaciones"] : '';
    $realizo = (isset($_POST["realizo"])) ? $_POST["realizo"] : '';

}

?>
<html>
<head>
<style>
    #oculto{visibility:hidden};
</style>
</head>
<title>.:Buscar Productos en general:.</title>
<body>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<form action="seleccion_producto_gral.php" method="post">
 <table>
    <tr>
        <td id="oculto">
            <input type="text" id="tip_id" name="tip_id" value="<?php print $tip_id;?>" />
            <input type="text" id="suc_id" name="suc_id" value="<?php print $suc_id;?>" />
            <input type="text" id="suc_des_id" name="suc_des_id" value="<?php print $suc_des;?>" />
            <input type="text" id="esModificacion" name="esModificacion" value="<?php print $esModificacion;?>" />
            <input type="text" id="tipo" name="tipo" value="<?php print $tipo;?>" />
            <input type="text" id="remito" name="remito" value="<?php print $remito;?>" />
            <input type="text" id="observaciones" name="observaciones" value="<?php print $observaciones;?>" />
            <input type="text" id="realizo" name="realizo" value="<?php print $realizo;?>" />

        </td>
    </tr>
    <tr>
        <td class="formTitle">MARCA</td>
        <td class="formFields">
            <?php
                $mar = new marcas();
                //$res = $mar->getmarcasxTipIdCombo($tip_id, $mar_id);
                $res = $mar->getmarcasxTipIdComboNuloyMarId($tip_id, $mar_id);
                //$res = $mar->getmarcasxTipIdComboNuloyMarId($tip_id, $mar_id);
                print $res;
            ?>
        </td>
        <td class="formTitle">MODELO</td>
        <td class="formFields">
              <?php
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
		<td class="formTitle">ESTADO</td>
        <td class="formFields">
			<select id="pro_nueva" name="pro_nueva" disabled="true">
				<option value="2">Todos</option>
				<option value="1" selected>Nuevo</option>
				<option value="0">Usado</option>
			</select>
        </td>
        <td>
            <input type="submit" id="busca_producto" name="busca_producto" class="boton" value="Buscar"  />
        </td>
    </tr>
</table>
</form>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td style="width: 70px;" class="rowGris">Código</td>
            <td class="rowGris">Descripción</td>
            <td style="width: 120px;" class="rowGris">Marca</td>
            <td style="width: 120px;" class="rowGris">Modelo</td>
			<td style="width: 120px;" class="rowGris">Estado</td>
            <td style="width: 70px;" class="rowGris">Elegir</td>
          </tr>
            <?php
            //$mostrar = $_SESSION["ocarrito"]->imprime_carrito2();
            //echo $mostrar;
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                $sql = "select p.pro_id 
                        , p.pro_descripcion 
                        , m.mar_descripcion 
                        , mo.mod_descripcion 
                        , p.pro_med_diametro 
                        , p.pro_med_ancho 
                        , p.pro_distribucion 
						, CASE p.pro_nueva
							WHEN 0 THEN 'Usado'
							WHEN 1 THEN 'Nuevo' 
							ELSE 'Nuevo'
							END as nueva
                        from productos p 
                        left join marcas m on m.mar_id = p.mar_id 
                        left join modelos mo on mo.mod_id = p.mod_id 
                        where p.tip_id = ". $tip_id ." 
                        and p.pro_estado = 0
                        ";                        
				if ($mar_id != 0){
						$sql .= " and p.mar_id = " . $mar_id;
					}											
				if ($mod_id != 0){
						$sql .= " and p.mod_id = " . $mod_id;
					}
				if ($pro_nueva != 2){
						$sql .= " and p.pro_nueva = " . $pro_nueva;
					}
			     $sql .=" order by p.pro_descripcion";
            
            /*$sql .= " and m.mar_id = p.mar_id
						and mo.mod_id = p.mod_id
                        and p.pro_estado = 0
						";*/											 
        $link=Conectarse();
        $consulta= mysql_query($sql,$link);
	    while($row= mysql_fetch_assoc($consulta)) {

            if ($tip_id == 6){
                $cantidad = 1;
            } else {
                $pro_cant = new productos();
                $cantidad = $pro_cant->getCantidadProducto($row["pro_id"], $suc_id);
            }
            if ($tipo == "E" or $tipo == "T"){
                if ($cantidad>0){
                    echo '<tr>';
                    echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_id"] . "</td>";
                    echo "<td class=rowBlanco>" . $row["pro_descripcion"] . "</td>";
                    echo "<td style='width: 120px;' class=rowBlanco>" . $row["mar_descripcion"] . "</td>";
                    echo "<td style='width: 120px;' class=rowBlanco>" . $row["mod_descripcion"] . "</td>";
    				echo "<td style='width: 120px;' class=rowBlanco>" . $row["nueva"] . "</td>";
                    echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des .  ",\"" . $remito . "\");'>Elegir</td>";//". "," . $suc_id. "," . $suc_des_id."
                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_id"] . "</td>";
                echo "<td class=rowBlanco>" . $row["pro_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["mar_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["mod_descripcion"] . "</td>";
				echo "<td style='width: 120px;' class=rowBlanco>" . $row["nueva"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des .  ",\"" . $remito . "\");'>Elegir</td>";//". "," . $suc_id. "," . $suc_des_id."
                echo '</tr>';
            }
	    }
                
    }
    ?>
       </table>


<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript">
function cerrarPU(pro_id, tip_id, tipo, suc_id, suc_des_id, remito)//, suc_id=0, suc_des_id=0)
{
    var observaciones=document.getElementById('observaciones').value; 
    var realizo=document.getElementById('realizo').value;
<?php if ($esModificacion=="SI"){ ?>
	opener.location='modifica_orden_trabajo.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id + '&remito=' + remito+'&observaciones='+observaciones+'&realizo='+realizo;
<?php } else if ((trim($tipo) == "I" || trim($tipo) == "E" || trim($tipo) == "T")){ ?>
    opener.location='alta_movimientos_stock.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id + '&tipo=' + tipo + '&suc_des_id=' + suc_des_id + '&suc_id=' + suc_id + '&remito=' + remito;
<?php } else { ?>    
	opener.location='alta_orden_trabajo.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id + '&remito=' + remito+'&observaciones='+observaciones+'&realizo='+realizo;
<?php } ?>
	window.close();
}
</script>
</body>
</html>
