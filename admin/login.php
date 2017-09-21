<?php
session_start();
include_once 'class/conex.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    $usuario = "";
    $clave = "";
    /*validaciones*/
    if (isset($_POST["usuario"])){
    } else {
        $mensajeError = $mensajeError . "1";
    }
    if (isset($_POST["clave"])){
    } else {
        $mensajeError = $mensajeError . "1";
    }
    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = "El usuario y/o clave ingresador son incorrectos.";
        session_destroy();
    } else {
        $link=Conectarse();
        $consulta= mysql_query(' select * from seguridad_web where SEG_ESTADO = 0 AND SEG_USER = "'.$_POST["usuario"].'"',$link);
        while($row= mysql_fetch_assoc($consulta)) {
            $usuario = $row["SEG_USER"];
            $clave = $row["SEG_PASS"];
        }
        if ($usuario!="" && $clave != ""){
            if ($usuario==$_POST["usuario"] && $clave == md5($_POST["clave"])){
                $_SESSION["usuario"] = $usuario;
                header("Location:abm_categorias.php");        
            } else {
                $mensaje = "El usuario y/o clave ingresador son incorrectos.";
                session_destroy();
            }
        } else {
            $mensaje = "El usuario y/o clave ingresador son incorrectos.";
            session_destroy();
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>.:MEGALLANTAS:.</title>
 <LINK REL="SHORTCUT ICON" HREF="images/mega.png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/megallantas.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/funciones.js" language="javascript"></script>
</head>

<body>
<div id="page"> 
 <!--Start HEADER -->
 <? require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Login </h1>
   
   <!--Start FORM -->
   <form ACTION="login.php" METHOD="POST" enctype="multipart/form-data">
      
    <table class="form" border="0"  align="center">
          <tr>
            <td class="formTitle">
            Usuario</td>
            <td>
            
                <input name="usuario" id="usuario" type="text" class="campos" size="18" /></td>
          </tr>
          <tr>
            <td class="formTitle">Password</td>
            <td>
                <input name="clave" id="clave" type="password" class="campos" size="18" />            </td>
          </tr>


          <tr>
          	<td colspan="2" align="center">
          		<input type="submit" class="boton" value="Enviar" />
<!--                    <a href='index.php'><input type='button' value='Volver' /></a>-->          	</td>
          </tr>
          <tr>
              <td colspan="2" class="mensaje">
          		<?php 
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
          		?>          	</td>
          </tr>
          </table>
		
      <?php
	        if (isset($_POST["mensaje"])) {
        	if ($_POST["mensaje"]!=""){
        		$mensaje=$_POST["mensaje"];
				echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
			}}
          ?>
    </form>
    <!--End FORM -->
 </div> 
<!--End CENTRAL -->
  <br clear="all" />
</div>
</body>
</html>