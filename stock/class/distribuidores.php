<?php
class distribuidores {

var $dis_id;
var $dis_descripcion;
var $dis_estado;
var $usu_id;


function distribuidores($dis_id=0) {
if ($dis_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from distribuidores where dis_id = '.$dis_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
    $this->dis_id=$row['dis_id'];
    $this->dis_descripcion=$row['dis_descripcion'];
    $this->dis_estado=$row['dis_estado'];
    $this->usu_id=$row['usu_id'];
}
}
}
function insert_dis() {
    $link=Conectarse();
    $sql="insert into distribuidores (
             dis_descripcion
            , usu_id
        ) values (
             '$this->dis_descripcion'
            , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO hdistribuidores
            (tipo, dis_id, dis_descripcion, dis_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->dis_descripcion', 0, '".$_SESSION["usu_id"]."')";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return $ultimo_id;
        }else {
            return 0;
        }
    } else {
        return 0;
    }
}
function update_dis() {
    $link=Conectarse();
    $sql="INSERT INTO hdistribuidores
         (tipo, dis_id, dis_descripcion, dis_estado, usu_id)
         SELECT
            'U', dis_id, dis_descripcion, dis_estado, '".$_SESSION["usu_id"]."'
         FROM distribuidores
         WHERE dis_id= '$this->dis_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update distribuidores set
                dis_id = '$this->dis_id'
                , dis_descripcion = '$this->dis_descripcion'
                , dis_estado = '$this->dis_estado'
                , usu_id = '".$_SESSION["usu_id"]."'
            where dis_id = '$this->dis_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
    return 0;
    }
}
function baja_dis(){
    $link=Conectarse();
        $sql="INSERT INTO hdistribuidores
             (tipo, dis_id, dis_descripcion, dis_estado, usu_id)
             SELECT
                'B', dis_id, dis_descripcion, dis_estado, '".$_SESSION["usu_id"]."'
             FROM distribuidores
             WHERE dis_id= '$this->dis_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update distribuidores set dis_estado = '1', usu_id = '".$_SESSION["usu_id"].
                "' where dis_id = '$this->dis_id'";
            $result1=mysql_query($sql1,$link);
            if ($result1>0){
                return 1;
            }else {
                return 0;}
        } else {
            return 0;
        }
}
function getdistribuidores()
{
$link=Conectarse();
$sql="select * from distribuidores where dis_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getdistribuidoresDes()
{
$link=Conectarse();
$sql="select * from distribuidores where dis_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getdistribuidoresSQL()
{
$link=Conectarse();
$sql="select * from distribuidores where dis_estado='0'";
return $sql;
}
function getdistribuidoresCombo($dis_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select dis_descripcion, dis_id
        from distribuidores
        where dis_estado = 0
        order by dis_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='distribuidores' id='distribuidores' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($dis_id==$row["dis_id"]){
            $html = $html . '<option value='.$row["dis_id"].' selected>'.$row["dis_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["dis_id"].'>'.$row["dis_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function get_dis_id()
{ return $this->dis_id;}
function set_dis_id($val)
{ $this->dis_id=$val;}
function get_dis_descripcion()
{ return $this->dis_descripcion;}
function set_dis_descripcion($val)
{ $this->dis_descripcion=$val;}
function get_dis_estado()
{ return $this->dis_estado;}
function set_dis_estado($val)
{ $this->dis_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>