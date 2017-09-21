<?php

 $con = mysql_connect("127.0.0.1:3307","209583-megados","i810vgt");

 //para comprobar que no haya errores

 if (! $con){die ("ERROR AL CONECTAR CON MYSQL: ".mysql_error());}

 $bd = mysql_select_db("209583_megados",$con);

 //para comprobar que no haya errores

 if(! $bd ){die ("ERROR AL CONECTAR CON LA BD: ".mysql_error());}

 //////////////////////////////////////////////////////////////////

 if ($_POST['seleccion'] == 'insertar'){ //comprobamos si se le dio click a insertar

 //en la variable fecha se guarda un arreglo donde

 //$fecha[0] tiene el dia $fecha[1] el mes y $fecha[0] el año 

 $fecha = explode("-",$_POST['fecha']);

 $sql = "INSERT INTO fechas VALUES (".$_POST['nombre']."','".$fecha[2]."-".$fecha[1]."-".$fecha[0].");";

 $result = mysql_query ($sql);

      if (!$result ) { echo "error al insertar datos ".mysql_error();

      else { echo "datos insertados correctamente<br/><a href='index.php'>Volver</a>";}
            }
		 
 else
    {
                 $result = mysql_query("SELECT * FROM fechas",$con);

                 while ($campo = mysql_fetch_row($result)){

                                $fecha = explode("-",$campo[2]);//usamos explode para dividir fecha en un array con 3 elementos

                                echo "<br />".$campo[1]."–>".$fecha[2]."/".$fecha[1]."/".$fecha[0];

                                                          }

                 echo "<a href='index.php'>Volver</a>"
				 }
 }

 ?>
