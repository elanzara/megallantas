<?php
class facturas_enc {

var $fae_id;
var $veh_id;
var $cli_id;
var $ote_id;
var $fae_fecha;


function facturas_enc($fae_id=0) {
if ($fae_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from facturas_enc where fae_id = '.$fae_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->fae_id=$row['fae_id'];
$this->veh_id=$row['veh_id'];
$this->cli_id=$row['cli_id'];
$this->ote_id=$row['ote_id'];
$this->fae_fecha=$row['fae_fecha'];
}
}
}
function insert_fae() {
$link=Conectarse();
$sql="insert into facturas_enc (
fae_id
, veh_id
, cli_id
, ote_id
, fae_fecha
) values ( 
'$this->fae_id'
, '$this->veh_id'
, '$this->cli_id'
, '$this->ote_id'
, '$this->fae_fecha'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_fae() {
$link=Conectarse();
$sql="update facturas_enc set 
fae_id = '$this->fae_id'
, veh_id = '$this->veh_id'
, cli_id = '$this->cli_id'
, ote_id = '$this->ote_id'
, fae_fecha = '$this->fae_fecha'
where fae_id = '$this->fae_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_fae(){
$link=Conectarse();
$sql="update facturas_enc set fae_estado = '1' where fae_id = '$this->fae_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function getfacturas_enc()
{
$link=Conectarse();
$sql="select * from facturas_enc where fae_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getfacturas_encDes()
{
$link=Conectarse();
$sql="select * from facturas_enc where fae_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function get_fae_id()
{ return $this->fae_id;}
function set_fae_id($val)
{ $this->fae_id=$val;}
function get_veh_id()
{ return $this->veh_id;}
function set_veh_id($val)
{ $this->veh_id=$val;}
function get_cli_id()
{ return $this->cli_id;}
function set_cli_id($val)
{ $this->cli_id=$val;}
function get_ote_id()
{ return $this->ote_id;}
function set_ote_id($val)
{ $this->ote_id=$val;}
function get_fae_fecha()
{ return $this->fae_fecha;}
function set_fae_fecha($val)
{ $this->fae_fecha=$val;}
}
?>