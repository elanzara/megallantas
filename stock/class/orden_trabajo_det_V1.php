<?php
class orden_trabajo_det {

var $otd_id;
var $pro_id;
var $ote_id;
var $cantidad;
var $precio;


function orden_trabajo_det($otd_id=0) {
if ($otd_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select otd_id , pro_id , ote_id , cantidad , precio from orden_trabajo_det where otd_id = '.$otd_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->otd_id=$row['otd_id'];
$this->pro_id=$row['pro_id'];
$this->ote_id=$row['ote_id'];
$this->cantidad=$row['cantidad'];
$this->precio=$row['precio'];
}
}
}
function insert_otd() {
$link=Conectarse();
$sql="insert into orden_trabajo_det (
otd_id
, pro_id
, ote_id
, cantidad
, precio
) values ( 
'$this->otd_id'
, '$this->pro_id'
, '$this->ote_id'
, '$this->cantidad'
, '$this->precio'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_otd() {
$link=Conectarse();
$sql="update orden_trabajo_det set 
otd_id = '$this->otd_id'
, pro_id = '$this->pro_id'
, ote_id = '$this->ote_id'
, cantidad = '$this->cantidad'
, precio = '$this->precio'
where otd_id = '$this->otd_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_otd(){
$link=Conectarse();
$sql="update orden_trabajo_det set otd_estado = '1' where otd_id = '$this->otd_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function getorden_trabajo_det()
{
$link=Conectarse();
$sql="select * from orden_trabajo_det where otd_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getorden_trabajo_detDes()
{
$link=Conectarse();
$sql="select * from orden_trabajo_det where otd_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}

function getorden_trabajo_det_X_ote_id($ote_id=0) {
    if ($ote_id!=0) {
        $link=Conectarse();
        $sql = "select d.otd_id , d.pro_id , d.ote_id , d.cantidad , d.precio, p.pro_descripcion from orden_trabajo_det d, productos p where d.pro_id = p.pro_id and ote_id = ".$ote_id;
        $consulta= mysql_query($sql, $link);
        return $consulta;
    }
}
function get_otd_id()
{ return $this->otd_id;}
function set_otd_id($val)
{ $this->otd_id=$val;}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_ote_id()
{ return $this->ote_id;}
function set_ote_id($val)
{ $this->ote_id=$val;}
function get_cantidad()
{ return $this->cantidad;}
function set_cantidad($val)
{ $this->cantidad=$val;}
function get_precio()
{ return $this->precio;}
function set_precio($val)
{ $this->precio=$val;}
}
?>