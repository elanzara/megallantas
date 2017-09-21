<?php
class reportes {

function get_rep_neumaticos_ingresados($desde='',$hasta='') {
  //echo'd:'.$desde.'  h:'.$hasta;
     $link=Conectarse();
     $sql = "select
 substr(s.suc_descripcion,1,10) suc_descripcion
, substr(a.mar_descripcion,1,20) mar_descripcion
, substr(o.mod_descripcion,1,40) mod_descripcion
, m.mov_id
, m.fecha
, p.pro_id
, substr(p.pro_descripcion,1,20) pro_descripcion
, p.pro_med_diametro
, p.pro_med_ancho
, p.pro_med_alto
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
, sum(m.cantidad) cantidad
, p.pro_precio_costo
, p.pro_controla_stock
from movimientos_stock m, productos p
, sucursales s, marcas a, modelos o
where
m.pro_id=p.pro_id and p.mar_id=a.mar_id and p.mod_id=o.mod_id
and m.suc_id=s.suc_id and m.tim_id=1
and p.tip_id in (4) and m.estado = 0";
    if($desde!='' and $hasta!=''){
     $sql .= " and m.fecha between '$desde' and '$hasta'";
//     $sql .= " and (m.fecha >= '.$desde.' and m.fecha <= '.$hasta.')";
    }
     $sql .= " group by p.pro_id, p.pro_descripcion, p.pro_precio_costo, p.pro_controla_stock
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)
order by s.suc_descripcion
, a.mar_descripcion
, o.mod_descripcion
, p.pro_id";//echo'sql:'.$sql;
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_resumen_diario($desde='',$hasta='') {
     $link=Conectarse();
     $sql = "select
 substr(s.suc_descripcion,1,10) suc_descripcion
, p.tip_id
, substr(r.tip_descripcion,1,13) tip_descripcion
, substr(a.mar_descripcion,1,20) mar_descripcion
, substr(o.mod_descripcion,1,13) mod_descripcion
, d.ote_id
, t.fecha
, p.pro_id
, substr(p.pro_descripcion,1,20) pro_descripcion
, p.pro_med_diametro
, p.pro_med_ancho
, p.pro_med_alto
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
, sum(d.cantidad) cantidad
, p.pro_precio_costo
, p.pro_controla_stock
from orden_trabajo_det d, orden_trabajo_enc t, productos p
, tipo_productos r, sucursales s, marcas a, modelos o
where
d.pro_id=p.pro_id and p.mar_id=a.mar_id and p.mod_id=o.mod_id and t.ote_id=d.ote_id
and t.suc_id=s.suc_id and p.tip_id=r.tip_id and t.estado != 1";
    if($desde!='' and $hasta!=''){
     $sql .= " and t.fecha between '$desde' and '$hasta'";
    }
     $sql .= " group by p.pro_id, p.pro_descripcion, p.pro_precio_costo, p.pro_controla_stock, p.tip_id
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)
order by s.suc_descripcion
, r.tip_descripcion
, a.mar_descripcion
, o.mod_descripcion
, p.pro_id";
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_neumaticos_vendidos($desde='',$hasta='') {
     $link=Conectarse();
     $sql = "select
 substr(s.suc_descripcion,1,10) suc_descripcion
, substr(a.mar_descripcion,1,20) mar_descripcion
, substr(o.mod_descripcion,1,40) mod_descripcion
, d.ote_id
, t.fecha
, p.pro_id
, substr(p.pro_descripcion,1,20) pro_descripcion
, p.pro_med_diametro
, p.pro_med_ancho
, p.pro_med_alto
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
 , sum(d.cantidad) cantidad
, p.pro_precio_costo
, p.pro_controla_stock
from orden_trabajo_det d, orden_trabajo_enc t, productos p
, sucursales s, marcas a, modelos o
where
d.pro_id=p.pro_id and p.mar_id=a.mar_id and p.mod_id=o.mod_id and t.ote_id=d.ote_id
and t.suc_id=s.suc_id and p.tip_id in (4) and t.estado != 1";
    if($desde!='' and $hasta!=''){
     $sql .= " and t.fecha between '$desde' and '$hasta'";
    }
     $sql .= " group by p.pro_id, p.pro_descripcion, p.pro_precio_costo, p.pro_controla_stock
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)
order by s.suc_descripcion
, a.mar_descripcion
, o.mod_descripcion
, p.pro_id";
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }
}
?>