<?php
class roles_x_usuario {

var $rxu_id;
var $rol_id;
var $usu_id;
var $rxu_estado;


function roles_x_usuario($rxu_id=0) {
if ($rxu_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select rxu_id , rol_id , usu_id,rxu_estado from roles_x_usuario where rxu_id = '.$rxu_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->rxu_id=$row['rxu_id'];
$this->rol_id=$row['rol_id'];
$this->usu_id=$row['usu_id'];
$this->rxu_estado=$row['rxu_estado'];
}
}
}
function insert_rxu() {
$link=Conectarse();
$sql="insert into roles_x_usuario (
 rol_id
, usu_id
) values ( 
 '$this->rol_id'
, '$this->usu_id'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_rxu() {
$link=Conectarse();
$sql="update roles_x_usuario set 
rol_id = '$this->rol_id'
, usu_id = '$this->usu_id'
where rxu_id = '$this->rxu_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_rxu(){
$link=Conectarse();
$sql="update roles_x_usuario set rxu_estado = '1' where rxu_id = '$this->rxu_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function getroles_x_usuario()
{
$link=Conectarse();
$sql="select * from roles_x_usuario where rxu_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getroles_x_usuarioDes()
{
$link=Conectarse();
$sql="select * from roles_x_usuario where rxu_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getroles_x_usuarioSQL()
{
$link=Conectarse();
$sql="select x.*,f.usu_descripcion,r.rol_descripcion from roles_x_usuario x,usuarios f,roles r
      where f.usu_id=x.usu_id and r.rol_id=x.rol_id and x.rxu_estado='0'";
return $sql;
}
function get_rxu_id()
{ return $this->rxu_id;}
function set_rxu_id($val)
{ $this->rxu_id=$val;}
function get_rol_id()
{ return $this->rol_id;}
function set_rol_id($val)
{ $this->rol_id=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
function get_rxu_estado()
{ return $this->rxu_estado;}
function set_rxu_estado($val)
{ $this->rxu_estado=$val;}
}
?>