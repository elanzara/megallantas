<?php
class proveedores {

var $prv_id;
var $prv_descripcion;
var $prv_estado;


function proveedores($prv_id=0) {
if ($prv_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select prv_id , prv_descripcion , prv_estado from proveedores where prv_id = '.$prv_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->prv_id=$row['prv_id'];
$this->prv_descripcion=$row['prv_descripcion'];
$this->prv_estado=$row['prv_estado'];
}
}
}
function insert_prv() {
$link=Conectarse();
$sql="insert into proveedores (
 prv_descripcion
) values ( 
 '$this->prv_descripcion'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_prv() {
$link=Conectarse();
$sql="update proveedores set 
prv_id = '$this->prv_id'
, prv_descripcion = '$this->prv_descripcion'
, prv_estado = '$this->prv_estado'
where prv_id = '$this->prv_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_prv(){
    $link=Conectarse();
    $sql1="select 0 from productos where pro_estado='0' and prv_id = '$this->prv_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    if ($result1>0){
        $sql="update proveedores set prv_estado = '1' where prv_id = '$this->prv_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}
function getproveedores()
{
$link=Conectarse();
$sql="select * from proveedores where prv_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getproveedoresDes()
{
$link=Conectarse();
$sql="select * from proveedores where prv_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getproveedoresSQL()
{
$link=Conectarse();
$sql="select * from proveedores where prv_estado='0' order by prv_descripcion";
return $sql;
}
function getproveedoresCombo($prv_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select prv_descripcion, prv_id
        from proveedores
        where prv_estado = 0
        order by prv_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='proveedores' id='proveedores' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($prv_id==$row["prv_id"]){
            $html = $html . '<option value='.$row["prv_id"].' selected>'.$row["prv_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["prv_id"].'>'.$row["prv_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function get_prv_id()
{ return $this->prv_id;}
function set_prv_id($val)
{ $this->prv_id=$val;}
function get_prv_descripcion()
{ return $this->prv_descripcion;}
function set_prv_descripcion($val)
{ $this->prv_descripcion=$val;}
function get_prv_estado()
{ return $this->prv_estado;}
function set_prv_estado($val)
{ $this->prv_estado=$val;}
}
?>