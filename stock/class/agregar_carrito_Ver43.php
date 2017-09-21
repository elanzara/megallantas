<?php
include("lib_carrito.php");
include_once 'productos.php';
include_once 'conex.php';
$pro_id = $_GET["pro_id"];
$pro_descripcion = $_GET["pro_descripcion"];
$pro_cantidad = $_GET["pro_cantidad"];
$sucursal = $_GET["sucursal"];
$cli_id = $_GET["cli_id"];
$veh_id = $_GET["veh_id"];
$tip_id = $_GET["tip_id"];
$pro_id = $_GET["pro_id"];
$observaciones = $_GET["observaciones"];
$precio = $_GET["precio"]; 
$esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : 'NO';
$realizo = (isset($_GET['realizo'])) ? $_GET['realizo'] : '';
$pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;
/*
PASOS A SEGUIR:
1) OBTENER PRECIO
2) OBTENER DESCUENTO
3) CALCULAR IMPORTE
4) CALCULAR IVA
5) VOLVER A LA PAGINA DE ALTA_ORDEN_TRABAJO
*/
//$pro_precio = 20;
//CALCULABA LA INVERSA DEL IVA
//$precio = round($precio * 0.826446281,2);
$pro_descuento = (isset($_GET['pro_descuento'])) ? (int) $_GET['pro_descuento'] : 0;

if ($esModificacion == 'NO'){
    if ($pro_cantidad<=0 or $pro_cantidad=='') {
        //"La cantidad debe ser mayor a cero.</br>";
        header('Location: ../alta_orden_trabajo.php?error=1&suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id);
    }else{
        $pro = new productos($pro_id);
        $controla = $pro->get_pro_controla_stock();
        if ($controla == 'S'){
            $cant_prod=$pro->getCantidadProducto($pro_id,$sucursal);
            if ($pro_cantidad>$cant_prod) {
                //"La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
                header('Location: ../alta_orden_trabajo.php?error=2&stock='.$cant_prod.'&suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo);
            }else{
                if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
                    $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento );/*$pro_precio*/
                    header( 'Location: ../alta_orden_trabajo.php?suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo) ;
                } else {
                    $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
                    header( 'Location: ../alta_orden_trabajo.php?suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo) ;                    
                }
            }
        } else {
            if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
                $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento );/*$pro_precio*/
                header( 'Location: ../alta_orden_trabajo.php?suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo) ;
            } else {
                $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
                header( 'Location: ../alta_orden_trabajo.php?suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo) ;                
            }
        }
    }
} else {
        if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
            $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento );/*$pro_precio*/
            header( 'Location: ../modifica_orden_trabajo.php?suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pmo_id='.$pmo_id.'&realizo='.$realizo);
        } else {
            $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
            header( 'Location: ../modifica_orden_trabajo.php?suc_id='.$sucursal.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pmo_id='.$pmo_id.'&realizo='.$realizo);
        } 
}    
?>