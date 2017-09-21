<?php
$sucursal = $_GET["suc_id"];
$tipo = $_GET["tipo"];
$tip_id = $_GET["tip_id"];

include("lib_carrito_stock.php");
$_SESSION["ocarrito_stock"]->elimina_producto($_GET["linea"]);
header( 'Location: ../alta_movimientos_stock.php?tipo='.$tipo.'&tip_id='.$tip_id.'&suc_id='.$sucursal ) ;
?>
