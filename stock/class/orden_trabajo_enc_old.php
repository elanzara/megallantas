<?php
class orden_trabajo_enc {

var $ote_id;
var $usuarios_usu_id;
var $veh_id;
var $cli_id;
var $fecha;
var $numero;
var $suc_id;
var $observaciones;
var $estado;
var $realizo;

function orden_trabajo_enc($ote_id=0) {
if ($ote_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from orden_trabajo_enc where ote_id = '.$ote_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->ote_id=$row['ote_id'];
$this->usuarios_usu_id=$row['usuarios_usu_id'];
$this->veh_id=$row['veh_id'];
$this->cli_id=$row['cli_id'];
$this->fecha=$row['fecha'];
$this->numero=$row['numero'];
$this->suc_id=$row['suc_id'];
$this->observaciones=$row['observaciones'];
$this->estado=$row['estado'];
$this->realizo=$row['realizo'];

}
}
}
function insert_ote() {
$link=Conectarse();
$sql="insert into orden_trabajo_enc (
ote_id
, usuarios_usu_id
, veh_id
, cli_id
, fecha
, numero
, suc_id
, observaciones
, estado
, realizo
) values ( 
'$this->ote_id'
, '$this->usuarios_usu_id'
, '$this->veh_id'
, '$this->cli_id'
, '$this->fecha'
, '$this->numero'
, '$this->suc_id'
, '$this->observaciones'
, '$this->estado'
, '$this->realizo'
)";
$result=mysql_query($sql,$link);
$ultimo_id = mysql_insert_id($link);
if ($result>0){
    return $ultimo_id;
} else {
    return 0;
}
}
function update_ote() {
$link=Conectarse();
$sql="update orden_trabajo_enc set 
ote_id = '$this->ote_id'
, usuarios_usu_id = '$this->usuarios_usu_id'
, veh_id = '$this->veh_id'
, cli_id = '$this->cli_id'
, fecha = '$this->fecha'
, numero = '$this->numero'
, suc_id = '$this->suc_id'
, observaciones = '$this->observaciones'
, estado = '$this->estado'
, realizo = '$this->realizo'
where ote_id = '$this->ote_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_ote(){
    $link=Conectarse();
    $sql1="select 0 from facturas_enc where ote_id = '$this->ote_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from movimientos_stock where estado='0' and ote_id = '$this->ote_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
//    $sql3="select 0 from orden_trabajo_det where ote_id = '$this->ote_id'";
//    $result3=mysql_query($sql3,$link);
//    if ($row = mysql_fetch_array($result3)){
//      $result3 = 0;
//    } else {$result3 = 3;
//    }
    if ($result1>0 and $result2>0){
        $sql="update orden_trabajo_enc set estado = '1' where ote_id = '$this->ote_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}

function EliminaMovimientosDet($ote_id=1){
    $respuesta ="";
    $link=Conectarse();    
    $sql = "update movimientos_stock set estado = 1 where ote_id = " . $ote_id;
    $result=mysql_query($sql,$link);
    if ($result>0){
        $respuesta = "OK mov. stock";
    } else {
        $respuesta = "ERROR mov. stock";
    }
    $sql = "delete from orden_trabajo_det where ote_id = " . $ote_id;
    $result=mysql_query($sql,$link);
    if ($result>0){
        $respuesta = "OK O.T. Det";
    } else {
        $respuesta = "ERROR O.T. Det";
    }
    return $respuesta;
}

function getorden_trabajo_enc()
{
$link=Conectarse();
$sql="select * from orden_trabajo_enc where estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getorden_trabajo_encDes()
{
$link=Conectarse();
$sql="select * from orden_trabajo_enc where estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getorden_trabajo_encSQL()
{
$link=Conectarse();
$sql="select e.*, c.cli_nombre, s.suc_descripcion, v.veh_neumaticos
    from orden_trabajo_enc e
    ,clientes c
    ,sucursales s
    ,vehiculos v
    where e.estado='0'
    and e.cli_id=c.cli_id
    and e.suc_id=s.suc_id
    and e.veh_id=v.veh_id
    order by e.ote_id desc";
return $sql;
}
function getorden_trabajo_encSQL2()
{
$link=Conectarse();
$sql="select e.*
, concat(IFNULL(c.cli_razon_social,''),' - ', IFNULL(c.cli_nombre,''), ' ' ,IFNULL(c.cli_apellido,'')) as cliente
, s.suc_descripcion
, concat(IFNULL(m.mar_descripcion,''), ' - ' , IFNULL(mo.mod_descripcion,''), ' - ' , IFNULL(v.veh_patente,'')) as vehiculo
from orden_trabajo_enc e
,clientes c
,sucursales s
,vehiculos v
left join marcas m on v.mar_id = m.mar_id
left join modelos mo on v.mod_id = mo.mod_id
where e.estado='0'
and e.cli_id=c.cli_id
and e.suc_id=s.suc_id
and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
and e.veh_id=v.veh_id
order by e.ote_id desc
";
return $sql;
}

function getNumeroOrden($suc_id){
    $ot_numero = 0;
    $link=Conectarse();
    $consulta= mysql_query("select ot_numero from comprobantes where suc_id = " . $suc_id,$link);
    while($row= mysql_fetch_assoc($consulta)) {
        $ot_numero = $row['ot_numero']+1;
    }
    if($ot_numero==0){
        $sql = "insert into comprobantes (suc_id, ot_numero) values (".$suc_id.",1)";
        $ot_numero = 1;
    }else{
        $sql = "update comprobantes set ot_numero = ot_numero + 1 where suc_id = " . $suc_id;
    }
    mysql_query($sql, $link);
    return $ot_numero;
 }

function get_ote_id()
{ return $this->ote_id;}
function set_ote_id($val)
{ $this->ote_id=$val;}
function get_usuarios_usu_id()
{ return $this->usuarios_usu_id;}
function set_usuarios_usu_id($val)
{ $this->usuarios_usu_id=$val;}
function get_veh_id()
{ return $this->veh_id;}
function set_veh_id($val)
{ $this->veh_id=$val;}
function get_cli_id()
{ return $this->cli_id;}
function set_cli_id($val)
{ $this->cli_id=$val;}
function get_fecha()
{ return $this->fecha;}
function set_fecha($val)
{ $this->fecha=$val;}
function get_numero()
{ return $this->numero;}
function set_numero($val)
{ $this->numero=$val;}
function get_suc_id()
{ return $this->suc_id;}
function set_suc_id($val)
{ $this->suc_id=$val;}
function get_observaciones()
{ return $this->observaciones;}
function set_observaciones($val)
{ $this->observaciones=$val;}
function get_estado()
{ return $this->estado;}
function set_estado($val)
{ $this->estado=$val;}
function get_realizo()
{ return $this->realizo;}
function set_realizo($val)
{ $this->realizo=$val;}
}
?>