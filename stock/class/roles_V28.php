<?php
class roles {

var $rol_id;
var $rol_descripcion;
var $rol_estado;


function roles($rol_id=0) {
if ($rol_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select rol_id , rol_descripcion , rol_estado from roles where rol_id = '.$rol_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->rol_id=$row['rol_id'];
$this->rol_descripcion=$row['rol_descripcion'];
$this->rol_estado=$row['rol_estado'];
}
}
}
function insert_rol() {
$link=Conectarse();
$sql="insert into roles (
 rol_descripcion
) values ( 
 '$this->rol_descripcion'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_rol() {
$link=Conectarse();
$sql="update roles set 
rol_id = '$this->rol_id'
, rol_descripcion = '$this->rol_descripcion'
, rol_estado = '$this->rol_estado'
where rol_id = '$this->rol_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_rol(){
    $link=Conectarse();
    $sql1="select 0 from funciones_x_role where fxr_estado='0' and rol_id = '$this->rol_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from roles_x_usuario where rxu_estado='0' and rol_id = '$this->rol_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    if ($result1>0 and $result2>0){
        $sql="update roles set rol_estado = '1' where rol_id = '$this->rol_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}
function getroles()
{
$link=Conectarse();
$sql="select * from roles where rol_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getrolesDes()
{
$link=Conectarse();
$sql="select * from roles where rol_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getrolesSQL()
{
$link=Conectarse();
$sql="select * from roles where rol_estado='0'";
return $sql;
}
function getrolesCombo($rol_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select rol_descripcion, rol_id
        from roles
        where rol_estado = 0
        order by rol_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='roles' id='roles' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($rol_id==$row["rol_id"]){
            $html = $html . '<option value='.$row["rol_id"].' selected>'.$row["rol_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["rol_id"].'>'.$row["rol_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function get_rol_id()
{ return $this->rol_id;}
function set_rol_id($val)
{ $this->rol_id=$val;}
function get_rol_descripcion()
{ return $this->rol_descripcion;}
function set_rol_descripcion($val)
{ $this->rol_descripcion=$val;}
function get_rol_estado()
{ return $this->rol_estado;}
function set_rol_estado($val)
{ $this->rol_estado=$val;}
}
?>