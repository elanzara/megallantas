<?php
class funciones {

var $fun_id;
var $fun_descripcion;
var $fun_estado;


function funciones($fun_id=0) {
if ($fun_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select fun_id , fun_descripcion , fun_estado from funciones where fun_id = '.$fun_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->fun_id=$row['fun_id'];
$this->fun_descripcion=$row['fun_descripcion'];
$this->fun_estado=$row['fun_estado'];
}
}
}
function insert_fun() {
$link=Conectarse();
$sql="insert into funciones (
 fun_descripcion
) values ( 
 '$this->fun_descripcion'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_fun() {
$link=Conectarse();
$sql="update funciones set 
fun_id = '$this->fun_id'
, fun_descripcion = '$this->fun_descripcion'
, fun_estado = '$this->fun_estado'
where fun_id = '$this->fun_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_fun(){
    $link=Conectarse();
    $sql1="select 0 from funciones_x_role where fxr_estado='0' and fun_id = '$this->fun_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    if ($result1>0){
        $sql="update funciones set fun_estado = '1' where fun_id = '$this->fun_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}
function getfunciones()
{
$link=Conectarse();
$sql="select * from funciones where fun_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getfuncionesDes()
{
$link=Conectarse();
$sql="select * from funciones where fun_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getfuncionesSQL()
{
$link=Conectarse();
$sql="select * from funciones where fun_estado='0'";
return $sql;
}
function getfuncionesCombo($fun_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select fun_descripcion, fun_id
        from funciones
        where fun_estado = 0
        order by fun_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='funciones' id='funciones' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($fun_id==$row["fun_id"]){
            $html = $html . '<option value='.$row["fun_id"].' selected>'.$row["fun_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["fun_id"].'>'.$row["fun_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function get_fun_id()
{ return $this->fun_id;}
function set_fun_id($val)
{ $this->fun_id=$val;}
function get_fun_descripcion()
{ return $this->fun_descripcion;}
function set_fun_descripcion($val)
{ $this->fun_descripcion=$val;}
function get_fun_estado()
{ return $this->fun_estado;}
function set_fun_estado($val)
{ $this->fun_estado=$val;}
}
?>