<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (isset($_SESSION['usuario'])) {
    date_default_timezone_set('America/Bogota');
    require_once 'clases/Conector.php';
    require_once 'admon/clases/Empresa.php';
    require_once 'admon/clases/Perfil.php';
    require_once 'admon/clases/Persona.php';
    @require_once 'admon/clases/Usuario.php';
    require_once 'admon/clases/BitacoraAuditoria.php';  
    require_once 'admon/clases/SucesoAuditoria.php';
    $usuario= unserialize($_SESSION['usuario']);
if($usuario->getEmpresa()->getNivelAuditoria()>0)  BitacoraAuditoria::registrar($usuario->getUsuario(),'S',null,null);
}
session_unset();//borra las variables de la sesion
session_destroy();//elimina la sesión
if (isset($_GET['mensaje'])) $mensaje='Usuario y/o contrase&ntilde;a incorrecta';
else $mensaje='';
?>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="presentacion/imagenes/AssitControl/Icono_Assist Control.ico">
        <meta charset="ISO-8859-1">
        <title>Administrador de sistemas de informaci&oacute;n - Inicio de sesi&oacute;n</title>
        <link rel="stylesheet" type="text/css" href="presentacion/css/login.css" />
    </head>
    <body>
    <center>
        <div id="contenedor">
            <div id="escudo"><img src="presentacion/imagenes/login/escudo.png" width="150"/></div>
            <div id="logo"><img src="presentacion/imagenes/login/logo.png" width="350"/></div>
            <h3>INICIAR SESI&Oacute;N</h3>            
            <form name="formulario" method="POST" action="admon/validar.php">
                <div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje?></font>
                <table border="0">
                    <tr><th><img src="presentacion/imagenes/login/user.png"/></th><td><input type="text" name="usuario" placeholder="Usuario"/></td></tr>
                    <tr><th><img src="presentacion/imagenes/login/key.png"/></th><td><input type="password" name="clave" placeholder="Contrase&ntilde;a"/></td></tr>
                </table>
                <br/><input type="submit" value="Entrar" id="boton"/>
               </div>
            </form>
    </center>
    </body>
</html>
