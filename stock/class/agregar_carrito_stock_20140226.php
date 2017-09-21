<?php
include("lib_carrito_stock.php");
include_once 'productos.php';
include_once 'conex.php';
$pro_id = $_GET["pro_id"];
$pro_descripcion = $_GET["pro_descripcion"];
$pro_cantidad = $_GET["pro_cantidad"];
$sucursal = $_GET["sucursal"];
$observaciones = $_GET["observaciones"];
$tipo = $_GET["tipo"];
$tip_id = $_GET["tip_id"];
$suc_des_id = $_GET["suc_des_id"];
$remito = $_GET["remito"];

if ($pro_cantidad<=0 or $pro_cantidad=='') {
    //"La cantidad debe ser mayor a cero.</br>";
    header('Location: ../alta_movimientos_stock.php?tipo='.$tipo.'&tip_id='.$tip_id.'&error=1&suc_id='.$sucursal.'&suc_des_id='.$suc_des_id . '&remito=' . $remito);
}else{
  if ($tipo!='I') {
    $pro = new productos();
    $cant_prod=$pro->getCantidadProducto($pro_id,$sucursal);
    if ($pro_cantidad>$cant_prod) {
        //"La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
        header('Location: ../alta_movimientos_stock.php?tipo='.$tipo.'&tip_id='.$tip_id.'&error=2&stock='.$cant_prod.'&suc_id='.$sucursal.'&suc_des_id='.$suc_des_id . '&remito=' . $remito);
    }else{
        $_SESSION["ocarrito_stock"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$observaciones);
        header( 'Location: ../alta_movimientos_stock.php?tipo='.$tipo.'&tip_id='.$tip_id.'&suc_id='.$sucursal.'&suc_des_id='.$suc_des_id . '&remito=' . $remito ) ;//&tip_id='.$tip_id.'
    }
  }else{
        $_SESSION["ocarrito_stock"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$observaciones);
        header( 'Location: ../alta_movimientos_stock.php?tipo='.$tipo.'&tip_id='.$tip_id.'&suc_id='.$sucursal.'&suc_des_id='.$suc_des_id . '&remito=' . $remito ) ;//&tip_id='.$tip_id.'
  }
}
?>