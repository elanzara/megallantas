<?php
function Conectarse()
{
   if (!($link=mysql_connect("127.0.0.1:3307","209583-mega","i810vgt")))
   {
//      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db("209583_mega",$link))
   {
//      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}
?>