<?php
class productos {

var $pro_id;
var $mod_id;
var $mar_id;
var $dis_id;
var $prv_id;
var $tip_id;
var $pro_med_diametro;
var $pro_med_ancho;
var $pro_med_alto;
var $pro_nueva;
var $pro_distribucion;
var $pro_stock_min;
var $pro_precio_costo;
var $pro_descripcion;

var $pro_tipo_llanta;
var $pro_material;
var $pro_terminaciones;
var $pro_controla_stock;
var $pro_anio;
var $tr_id;
var $pro_foto;

function productos($pro_id=0) {
if ($pro_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select pro_id , mod_id , mar_id , dis_id , prv_id , tip_id , pro_med_diametro , pro_med_ancho
    , pro_med_alto , pro_nueva , pro_distribucion , pro_stock_min , pro_precio_costo, pro_descripcion 
    , pro_tipo_llanta, pro_material, pro_terminaciones, pro_controla_stock, pro_anio, tr_id, pro_foto    
    from productos where pro_id = '.$pro_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->pro_id=$row['pro_id'];
$this->mod_id=$row['mod_id'];
$this->mar_id=$row['mar_id'];
$this->dis_id=$row['dis_id'];
$this->prv_id=$row['prv_id'];
$this->tip_id=$row['tip_id'];
$this->pro_med_diametro=$row['pro_med_diametro'];
$this->pro_med_ancho=$row['pro_med_ancho'];
$this->pro_med_alto=$row['pro_med_alto'];
$this->pro_nueva=$row['pro_nueva'];
$this->pro_distribucion=$row['pro_distribucion'];
$this->pro_stock_min=$row['pro_stock_min'];
$this->pro_precio_costo=$row['pro_precio_costo'];
$this->pro_descripcion=$row['pro_descripcion'];

$this->pro_tipo_llanta=$row['pro_tipo_llanta'];
$this->pro_material=$row['pro_material'];
$this->pro_terminaciones=$row['pro_terminaciones'];
$this->pro_controla_stock=$row['pro_controla_stock'];
$this->pro_anio=$row['pro_anio'];
$this->tr_id=$row['tr_id'];
$this->pro_foto=$row['pro_foto'];
}
}
}
function insert_pro() {
$link=Conectarse();
if ($this->pro_med_diametro=='') {$v_med_diametro = 'null';} else {$v_med_diametro = $this->pro_med_diametro;}
if ($this->pro_med_ancho=='') {$v_med_ancho = 'null';} else {$v_med_ancho = $this->pro_med_ancho;}
if ($this->pro_med_alto=='') {$v_med_alto = 'null';} else {$v_med_alto = $this->pro_med_alto;}
if ($this->pro_nueva=='') {$v_nueva = 'null';} else {$v_nueva = $this->pro_nueva;}
if ($this->pro_stock_min=='') {$v_stock_min = 'null';} else {$v_stock_min = $this->pro_stock_min;}
if ($this->pro_precio_costo=='') {$v_precio_costo = 'null';} else {$v_precio_costo = $this->pro_precio_costo;}
$sql="insert into productos (
 mod_id
, mar_id
, dis_id
, prv_id
, tip_id
, pro_med_diametro
, pro_med_ancho
, pro_med_alto
, pro_nueva
, pro_distribucion
, pro_stock_min
, pro_precio_costo
, pro_descripcion
, pro_tipo_llanta
, pro_material
, pro_terminaciones
, pro_controla_stock
, pro_anio
, tr_id
, pro_foto
) values ( 
 '$this->mod_id'
, '$this->mar_id'
, '$this->dis_id'
, '$this->prv_id'
, '$this->tip_id'
, $v_med_diametro
, $v_med_ancho
, $v_med_alto
, $v_nueva
, '$this->pro_distribucion'
, $v_stock_min
, $v_precio_costo
, '$this->pro_descripcion'
, '$this->pro_tipo_llanta'
, '$this->pro_material'
, '$this->pro_terminaciones'
, '$this->pro_controla_stock'
, '$this->pro_anio'
, '$this->tr_id'
, '$this->pro_foto'
)";
$result=mysql_query($sql,$link);
/*return $sql;*/
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_pro() {
$link=Conectarse();
if ($this->pro_med_diametro=='') {$v_med_diametro = 'null';} else {$v_med_diametro = $this->pro_med_diametro;}
if ($this->pro_med_ancho=='') {$v_med_ancho = 'null';} else {$v_med_ancho = $this->pro_med_ancho;}
if ($this->pro_med_alto=='') {$v_med_alto = 'null';} else {$v_med_alto = $this->pro_med_alto;}
if ($this->pro_nueva=='') {$v_nueva = 'null';} else {$v_nueva = $this->pro_nueva;}
if ($this->pro_stock_min=='') {$v_stock_min = 'null';} else {$v_stock_min = $this->pro_stock_min;}
if ($this->pro_precio_costo=='') {$v_precio_costo = 'null';} else {$v_precio_costo = $this->pro_precio_costo;}
$sql="update productos set 
pro_id = '$this->pro_id'
, mod_id = '$this->mod_id'
, mar_id = '$this->mar_id'
, dis_id = '$this->dis_id'
, prv_id = '$this->prv_id'
, tip_id = '$this->tip_id'
, pro_med_diametro = $v_med_diametro
, pro_med_ancho = $v_med_ancho
, pro_med_alto = $v_med_alto
, pro_nueva = $v_nueva
, pro_distribucion = '$this->pro_distribucion'
, pro_stock_min = $v_stock_min
, pro_precio_costo = $v_precio_costo
, pro_descripcion = '$this->pro_descripcion'
, pro_tipo_llanta = '$this->pro_tipo_llanta'
, pro_material = '$this->pro_material'
, pro_terminaciones = '$this->pro_terminaciones'
, pro_controla_stock = '$this->pro_controla_stock'
, pro_anio = '$this->pro_anio'
, tr_id = '$this->tr_id'
, pro_foto = '$this->pro_foto'
where pro_id = '$this->pro_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_pro(){
    $link=Conectarse();
    $sql1="select 0 from facturas_det where pro_id = '$this->pro_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from movimientos_stock where estado='0' and pro_id = '$this->pro_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from orden_trabajo_det where pro_id = '$this->pro_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    $sql4="select 0 from stock_mensual where pro_id = '$this->pro_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
    if ($result1>0 and $result2>0 and $result3>0 and $result4>0){
        $sql="update productos set pro_estado = '1' where pro_id = '$this->pro_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            return 1;
        } else {
            return 0;
        }
    }
}
function getproductos()
{
$link=Conectarse();
$sql="select * from productos where pro_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getproductosDes()
{
$link=Conectarse();
$sql="select * from productos where pro_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getproductosSQL($mod_id=0)
{
$link=Conectarse();
if ($mod_id==0) {
    $sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
          where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0'";
} else {
    $sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
          where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0' and p.mod_id = '$mod_id'";
}
return $sql;
}

function getproductosSQL2($tip_id=0)
{
$link=Conectarse();
if ($tip_id==0) {
    //$sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
    //      where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0'";
    $sql = "SELECT p.*, a.*, o.*, t.*, r.*
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'";
            //AND p.tip_id =6
} else {
    //$sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
    //      where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0' and p.tip_id = ".$tip_id;
    $sql = "SELECT p.*, a.*, o.*, t.*, r.*
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id;
}
return $sql;
}

function getproductosSQLxTipMod($tip_id=0,$mar_id=0)
{
$link=Conectarse();
if ($tip_id!=0 and $mar_id!=0) {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id." AND p.mar_id =".$mar_id."
            ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
} elseif ($tip_id!=0 and $mar_id==0)  {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id."
            ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
} else {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
}
return $sql;
}

//En base al código de producto y sucursal la funcion devuelve el stock al momento.
//Dicha función debe validar el ultimo stock de dicho producto / sucursal dentro de la tabla stock_mensual y
//luego sumar y restar los movimientos de la tabla movimientos_stock.
function getCantidadProducto($pro_id=0,$suc_id=0) {
    $link=Conectarse();
    $cant_inicial = 0;
    $cantidad_stock = 0;
    $cantidad = 0;
    //Recupero cantidad inicial del mes actual
    $sql="select ifnull(sum(s.cantidad),0) cantidad
        from stock_mensual s
        where s.pro_id = ".$pro_id.
        " and s.suc_id = ".$suc_id.
        " and year(s.fecha)=year(curdate())
        and month(s.fecha)=month(curdate())";
//    (select max(s1.fecha)
//                    from stock_mensual s1
//                    where s1.pro_id = ".$pro_id.
//                    " and s1.suc_id =".$suc_id.")"
    $consulta= mysql_query($sql, $link);
    if ($consulta){
        while ($row = mysql_fetch_assoc($consulta)) {
            if ($row['cantidad'] == ""){
                $cant_inicial = 0;}
            else {
                $cant_inicial = $row['cantidad'];
            }
        }
    }
    if($cant_inicial!=""){
        //Recupero movimientos stock
        $sql1="select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = ".$pro_id.
            " and m.suc_id = ".$suc_id;
//            " and year(m.fecha)=year(curdate())
//            and month(m.fecha)=month(curdate())";
        $consulta1= mysql_query($sql1, $link);
        if ($consulta1){
            while ($row1 = mysql_fetch_assoc($consulta1)) {
                if ($row1['cantidad'] == ""){
                    $cantidad_stock = 0;}
                else {
                    $cantidad_stock = $row1['cantidad'];
                }
            }
        }
    }
    $cantidad=$cant_inicial+$cantidad_stock;
    return $cantidad;

}

function getproductosCombo($pro_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select pro_descripcion, pro_id
        from productos
        where pro_estado = 0
        order by pro_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='productos' id='productos' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_id==$row["pro_id"]){
            $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getproductosCombo_MS($tip_id=0,$mar_id=0,$mod_id=0,$pro_med_ancho='',$pro_med_diametro=''
        ,$pro_distribucion='',$tr_id=0,$pro_nueva='',$pro_med_alto='',$pro_descripcion='',$tipo='I',$suc_id='') {
    $link=Conectarse();
    $html = "";
    $sql="select p.pro_descripcion, pro_id
        from productos p
        where p.pro_estado = 0";
    if ($tip_id!=0) {
        $sql.=" and p.tip_id = ".$tip_id;
    }
    if ($mar_id!=0) {
        $sql.=" and p.mar_id = ".$mar_id;
    }
    if ($mod_id!=0) {
        $sql.=" and p.mod_id = ".$mod_id;
    }
    if ($pro_med_ancho!='') {
        $sql.=" and upper(p.pro_med_ancho) like %".strtoupper($pro_med_ancho)."%";
    }
    if ($pro_med_diametro!=0) {
        $sql.=" and upper(p.pro_med_diametro) = ".strtoupper($pro_med_diametro);
    }
    if ($pro_distribucion!=0) {
        $sql.=" and upper(p.pro_distribucion) = ".strtoupper($pro_distribucion);
    }
    if ($tr_id!=0) {
        $sql.=" and p.tr_id = ".$tr_id;
    }
    if ($pro_nueva!='') {
        $sql.=" and p.pro_nueva = ".$pro_nueva;
    }
    if ($pro_med_alto!='') {
        $sql.=" and upper(p.pro_med_alto) like %".strtoupper($pro_med_alto)."%";
    }
    if ($pro_descripcion!='') {
        $sql.=" and upper(p.pro_descripcion) like %".strtoupper($pro_descripcion)."%";
    }
    $sql.=" order by p.pro_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='productos_ms' id='productos_ms' class='formFields' >";
    if ($consulta){
      while($row= mysql_fetch_assoc($consulta)) {
        if ($tipo=='E' or $tipo=='T') {
          $cant_prod=$this->getCantidadProducto($row["pro_id"],$suc_id);
          if (is_null($cant_prod)){$cant_prod=0;}
          if ($cant_prod>0){
            if ($pro_id==$row["pro_id"]){
                $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
            } else {
                $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
            }
          }
        }else{
            if ($pro_id==$row["pro_id"]){
                $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
            } else {
                $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
            }
        }
      }
    }else{
       $html = $html . '<option value=""></option>';
    }
    $html = $html . '</select>';
    return $html;
}

function getstock_productosSQL($search_sucursal = "",$search_tipo_producto = "",$search_nombre = "")
{
$link=Conectarse();
if (($search_sucursal=="" or $search_categoria=="0") and ($search_tipo_producto=="" or $search_tipo_producto=="0")
     and ($search_nombre == "")){
    $sql="select m.mar_descripcion, mo.mod_descripcion, p.*, tp.tip_descripcion, s.suc_id, s.suc_descripcion
        ,(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) estado
          from productos p
            ,marcas m
            ,modelos mo
            ,tipo_productos tp
            ,movimientos_stock ms
            ,sucursales s
        where p.pro_estado='0'
        and p.mar_id=m.mar_id
        and p.mod_id=mo.mod_id
        and tp.tip_id=p.tip_id
        and ms.pro_id=p.pro_id
        and s.suc_id=ms.suc_id
        group by p.pro_id,ms.suc_id
        order by s.suc_descripcion,tp.tip_descripcion,p.pro_descripcion";
       } else {
       $sql="select m.mar_descripcion, mo.mod_descripcion, p.*, tp.tip_descripcion, s.suc_id, s.suc_descripcion
           ,(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) estado
              from productos p
                ,marcas m
                ,modelos mo
                ,tipo_productos tp
                ,movimientos_stock ms
                ,sucursales s
            where p.pro_estado='0'
            and p.mar_id=m.mar_id
            and p.mod_id=mo.mod_id
            and tp.tip_id=p.tip_id
            and ms.pro_id=p.pro_id
            and s.suc_id=ms.suc_id
            and ('".$search_sucursal."' = ''
                  or '".$search_sucursal."' = '0'
                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
                  )
             and ('".$search_tipo_producto."' = ''
                  or '".$search_tipo_producto."' = '0'
                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
                  )
             and ('".$search_producto."' = ''
                  or '".$search_producto."' = '0'
                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
                  )
            group by p.pro_id,ms.suc_id
            order by s.suc_descripcion,tp.tip_descripcion,p.pro_descripcion";
       }
return $sql;
}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_mod_id()
{ return $this->mod_id;}
function set_mod_id($val)
{ $this->mod_id=$val;}
function get_mar_id()
{ return $this->mar_id;}
function set_mar_id($val)
{ $this->mar_id=$val;}
function get_dis_id()
{ return $this->dis_id;}
function set_dis_id($val)
{ $this->dis_id=$val;}
function get_prv_id()
{ return $this->prv_id;}
function set_prv_id($val)
{ $this->prv_id=$val;}
function get_tip_id()
{ return $this->tip_id;}
function set_tip_id($val)
{ $this->tip_id=$val;}
function get_pro_med_diametro()
{ return $this->pro_med_diametro;}
function set_pro_med_diametro($val)
{ $this->pro_med_diametro=$val;}
function get_pro_med_ancho()
{ return $this->pro_med_ancho;}
function set_pro_med_ancho($val)
{ $this->pro_med_ancho=$val;}
function get_pro_med_alto()
{ return $this->pro_med_alto;}
function set_pro_med_alto($val)
{ $this->pro_med_alto=$val;}
function get_pro_nueva()
{ return $this->pro_nueva;}
function set_pro_nueva($val)
{ $this->pro_nueva=$val;}
function get_pro_distribucion()
{ return $this->pro_distribucion;}
function set_pro_distribucion($val)
{ $this->pro_distribucion=$val;}
function get_pro_stock_min()
{ return $this->pro_stock_min;}
function set_pro_stock_min($val)
{ $this->pro_stock_min=$val;}
function get_pro_precio_costo()
{ return $this->pro_precio_costo;}
function set_pro_precio_costo($val)
{ $this->pro_precio_costo=$val;}
function get_pro_estado()
{ return $this->pro_estado;}
function set_pro_estado($val)
{ $this->pro_estado=$val;}
function get_pro_descripcion()
{ return $this->pro_descripcion;}
function set_pro_descripcion($val)
{ $this->pro_descripcion=$val;}
function get_pro_tipo_llanta()
{ return $this->pro_tipo_llanta;}
function set_pro_tipo_llanta($val)
{ $this->pro_tipo_llanta=$val;}
function get_pro_material()
{ return $this->pro_material;}
function set_pro_material($val)
{ $this->pro_material=$val;}
function get_pro_terminaciones()
{ return $this->pro_terminaciones;}
function set_pro_terminaciones($val)
{ $this->pro_terminaciones=$val;}
function get_pro_controla_stock()
{ return $this->pro_controla_stock;}
function set_pro_controla_stock($val)
{ $this->pro_controla_stock=$val;}
function get_pro_anio()
{ return $this->pro_anio;}
function set_pro_anio($val)
{ $this->pro_anio=$val;}
function get_tr_id()
{ return $this->tr_id;}
function set_tr_id($val)
{ $this->tr_id=$val;}
function get_pro_foto()
{ return $this->pro_foto;}
function set_pro_foto($val)
{ $this->pro_foto=$val;}
}
?>