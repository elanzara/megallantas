<?php
class stock_mensual {

var $stm_id;
var $suc_id;
var $pro_id;
var $fecha;
var $cantidad;


function stock_mensual($stm_id=0) {
if ($stm_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select stm_id , suc_id , pro_id , fecha , cantidad from stock_mensual where stm_id = '.$stm_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->stm_id=$row['stm_id'];
$this->suc_id=$row['suc_id'];
$this->pro_id=$row['pro_id'];
$this->fecha=$row['fecha'];
$this->cantidad=$row['cantidad'];
}
}
}
function insert_stm() {
$link=Conectarse();
$sql="insert into stock_mensual (
stm_id
, suc_id
, pro_id
, fecha
, cantidad
) values ( 
'$this->stm_id'
, '$this->suc_id'
, '$this->pro_id'
, '$this->fecha'
, '$this->cantidad'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_stm() {
$link=Conectarse();
$sql="update stock_mensual set 
stm_id = '$this->stm_id'
, suc_id = '$this->suc_id'
, pro_id = '$this->pro_id'
, fecha = '$this->fecha'
, cantidad = '$this->cantidad'
where stm_id = '$this->stm_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_stm(){
$link=Conectarse();
$sql="update stock_mensual set stm_estado = '1' where stm_id = '$this->stm_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function getstock_mensual()
{
$link=Conectarse();
$sql="select * from stock_mensual where stm_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getstock_mensualDes()
{
$link=Conectarse();
$sql="select * from stock_mensual where stm_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function get_stm_id()
{ return $this->stm_id;}
function set_stm_id($val)
{ $this->stm_id=$val;}
function get_suc_id()
{ return $this->suc_id;}
function set_suc_id($val)
{ $this->suc_id=$val;}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_fecha()
{ return $this->fecha;}
function set_fecha($val)
{ $this->fecha=$val;}
function get_cantidad()
{ return $this->cantidad;}
function set_cantidad($val)
{ $this->cantidad=$val;}
}
?>