<?php
class usuarios {

var $usu_id;
var $usu_descripcion;
var $usu_clave;
var $usu_estado;
var $usu_mail;

function usuarios($usu_id=0) {
if ($usu_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select usu_id , usu_descripcion , usu_clave , usu_estado, usu_mail from usuarios where usu_id = '.$usu_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->usu_id=$row['usu_id'];
$this->usu_descripcion=$row['usu_descripcion'];
$this->usu_clave=$row['usu_clave'];
$this->usu_estado=$row['usu_estado'];
$this->usu_mail=$row['usu_mail'];
}
}
}
function insert_usu() {
$link=Conectarse();
$sql="insert into usuarios (
 usu_descripcion
, usu_clave
, usu_mail
) values ( 
 '$this->usu_descripcion'
, '$this->usu_clave'
, '$this->usu_mail'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_usu() {
$link=Conectarse();
$sql="update usuarios set 
usu_id = '$this->usu_id'
, usu_descripcion = '$this->usu_descripcion'
, usu_clave = '$this->usu_clave'
, usu_estado = '$this->usu_estado'
, usu_mail = '$this->usu_mail'
where usu_id = '$this->usu_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_usu(){
    $link=Conectarse();
    $sql2="select 0 from roles_x_usuario where rxu_estado='0' and usu_id = '$this->usu_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    if ($result2>0){
        $sql="update usuarios set usu_estado = '1' where usu_id = '$this->usu_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}
function getusuarios()
{
$link=Conectarse();
$sql="select * from usuarios where usu_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getusuariosDes()
{
$link=Conectarse();
$sql="select * from usuarios where usu_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getusuariosSQL()
{
$link=Conectarse();
$sql="select * from usuarios where usu_estado='0'";
return $sql;
}

function get_mail_admin(){
    $link=Conectarse();
    $mails = "";
    $sql = "select u.usu_mail from usuarios u, roles_x_usuario r where r.rol_id = 1 and r.usu_id = u.usu_id";
    $consulta= mysql_query($sql,$link);
    while($row= mysql_fetch_assoc($consulta)) {
        if ($row['usu_mail'] != ''){
            if ($mails == ""){
                $mails = $row['usu_mail'];
            } else {
                
                    $mails .= ",".$row['usu_mail'];
            }
        }
    }
    return $mails;
}
function getusuariosCombo($usu_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select usu_descripcion, usu_id
        from usuarios
        where usu_estado = 0
        order by usu_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='usuarios' id='usuarios' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($usu_id==$row["usu_id"]){
            $html = $html . '<option value='.$row["usu_id"].' selected>'.$row["usu_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["usu_id"].'>'.$row["usu_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
function get_usu_descripcion()
{ return $this->usu_descripcion;}
function set_usu_descripcion($val)
{ $this->usu_descripcion=$val;}
function get_usu_clave()
{ return $this->usu_clave;}
function set_usu_clave($val)
{ $this->usu_clave=$val;}
function get_usu_estado()
{ return $this->usu_estado;}
function set_usu_estado($val)
{ $this->usu_estado=$val;}
function get_usu_mail()
{ return $this->usu_mail;}
function set_usu_mail($val)
{ $this->usu_mail=$val;}
}
?>