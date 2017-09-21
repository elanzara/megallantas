<?php
include("lib_carrito.php");
$_SESSION["ocarrito"]->elimina_producto($_GET["linea"]);
header( 'Location: ../alta_orden_trabajo.php') ;
?>