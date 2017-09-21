<?php
class tipo_movimientos {

var $tim_id;
var $tim_descripcion;
var $tim_suma;


function tipo_movimientos($tim_id=0) {
if ($tim_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select tim_id , tim_descripcion , tim_suma from tipo_movimientos where tim_id = '.$tim_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->tim_id=$row['tim_id'];
$this->tim_descripcion=$row['tim_descripcion'];
$this->tim_suma=$row['tim_suma'];
}
}
}
function insert_tim() {
$link=Conectarse();
$sql="insert into tipo_movimientos (
tim_id
, tim_descripcion
, tim_suma
) values ( 
'$this->tim_id'
, '$this->tim_descripcion'
, '$this->tim_suma'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_tim() {
$link=Conectarse();
$sql="update tipo_movimientos set 
tim_id = '$this->tim_id'
, tim_descripcion = '$this->tim_descripcion'
, tim_suma = '$this->tim_suma'
where tim_id = '$this->tim_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_tim(){
    $link=Conectarse();
    $sql2="select 0 from movimientos_stock where estado='0' and tim_id = '$this->tim_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    if ($result2>0){
        $sql="update tipo_movimientos set tim_estado = '1' where tim_id = '$this->tim_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}
function gettipo_movimientos()
{
$link=Conectarse();
$sql="select * from tipo_movimientos where tim_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function gettipo_movimientosDes()
{
$link=Conectarse();
$sql="select * from tipo_movimientos where tim_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function gettipo_movimientosSQL()
{
$link=Conectarse();
$sql="select * from tipo_movimientos where tim_estado='0'";
return $sql;
}
function get_tim_id()
{ return $this->tim_id;}
function set_tim_id($val)
{ $this->tim_id=$val;}
function get_tim_descripcion()
{ return $this->tim_descripcion;}
function set_tim_descripcion($val)
{ $this->tim_descripcion=$val;}
function get_tim_suma()
{ return $this->tim_suma;}
function set_tim_suma($val)
{ $this->tim_suma=$val;}
function get_tim_estado()
{ return $this->tim_estado;}
function set_tim_estado($val)
{ $this->tim_estado=$val;}
}
?>