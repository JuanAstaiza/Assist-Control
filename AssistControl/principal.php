<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require_once 'clases/Conector.php';
require_once 'admon/clases/SI.php';
require_once 'admon/clases/Menu.php';
require_once 'admon/clases/Opcion.php';
require_once 'admon/clases/Empresa.php';
require_once 'admon/clases/Contrato.php';
require_once 'admon/clases/Perfil.php';
require_once 'admon/clases/Persona.php';
require_once 'admon/clases/Usuario.php';
require_once 'admon/clases/SucesoAuditoria.php';
require_once 'admon/clases/BitacoraAuditoria.php';
if (!isset($_SESSION['usuario'])) header('Location: index.php?mensaje=Debe iniciar sesion');
date_default_timezone_set('America/Bogota');
$USUARIO= unserialize($_SESSION['usuario']);
$PERFIL=$USUARIO->getPerfil();
$EMPRESA=$USUARIO->getEmpresa();
$IDEMPRESA=$USUARIO->getIdEmpresa();
$NIVELAUDITORIA=$EMPRESA->getNivelAuditoria();
$BD=$EMPRESA->getBd();
if ($EMPRESA->getPrefijo()!='')$P=$EMPRESA->getPrefijo().'_';
else $P='';
const registrosXPagina=10;
const registrosXPagina2=7;
const registrosXPagina3=20;
const registrosXPaginaEncuestas=1;

?>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="presentacion/imagenes/AssitControl/Icono_Assist Control.ico">
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>Administrador de sistemas de informaci&oacute;n</title>
        <link rel="stylesheet" type="text/css" href="presentacion/css/estilo.css"/>
        <script type="text/javascript" src="lib/funciones.js"></script>        
        <script type="text/javascript" src="lib/jquery-3.2.1.min.js"></script>  
        <script src="lib/amcharts_3.21.1.free/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="lib/amcharts_3.21.1.free/amcharts/serial.js" type="text/javascript"></script> 
        
    </head>
    <body>
    <center>
		<div id="banner"><img src="presentacion/imagenes/banner.jpg" width="1280" height="225"/></div>
        <nav>
            <ul>
                <?=$PERFIL->getMenu()?>
                <li><a href="principal.php?CONTENIDO=admon/cambiarClave.php">Cambiar clave</a></li>
                <li><a href="index.php">Salir</a></li>
            </ul>
        </nav>
        <div id="contenido"><?php include $_GET['CONTENIDO'];?></div>
	</center>
    </body>
</html>
