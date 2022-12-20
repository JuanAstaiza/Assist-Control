<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '/../clases/Conector.php';
require_once '/clases/PersonaRegistroDiario.php';
require_once '/clases/Registro_RegistroDiario.php';
require_once '/clases/Cargo.php';

if (isset($_GET['codigo'])) {
    $BD='assistcontrol';
    $P='lemo_';
    if ($_GET['codigo']==null) {
        $mensaje = '';
        $advertencia = '';
        $cedula = '';
        $nombres = '';
        $cargo = '';
        $fecha = '';
        $foto='../presentacion/imagenes/AssitControl/foto.jpg';
        $advertencia = $_GET['advertencia'];
    }else{
    $registro = new Registro_RegistroDiario('codigo', $_GET['codigo']);
    $mensaje = $_GET['mensaje'];
    $advertencia = $_GET['advertencia'];
    $cedula = $registro->getCedulaPersona();
    $nombres = $registro->getPersona()->getPrimerNombre().' '.$registro->getPersona()->getSegundoNombre().' '.$registro->getPersona()->getPrimerApellido();
    $cargo = $registro->getPersona()->getCargo()->getNombre();
    $fecha = $registro->getFecha();
    if ($registro->getPersona()->getFoto()!=null) $foto="fotos/{$registro->getPersona()->getFoto()}";
    else $foto='../presentacion/imagenes/AssitControl/foto.jpg';
    }  
}else {
    $registro = new Registro_RegistroDiario(null, null);
    $mensaje = '';
    $advertencia = '';
    $cedula = '';
    $nombres = '';
    $cargo = '';
    $fecha = '';
    $foto='../presentacion/imagenes/AssitControl/foto.jpg';
}
?>
<script type="text/javascript">

function resetarcedula(){
<?=$cedula=''?>
}
function validar(){
   var cedula= document.formulario.cedulaPersona.value;
   if(cedula!==""){
    setInterval(resetarcedula(),3000);
   }	
}

	

    
</script>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="../presentacion/imagenes/AssitControl/Icono_Assist Control.ico">
        <meta charset="UTF-8">
        <title>Registro de Asistencia</title>
        <style type="text/css">
            body {background-image: url(../presentacion/imagenes/fondo2.png);}
            
            h3 {
            width: 400px;
            height: 40px;
            background: #2874a6;
            top: 100px;
            position: relative;
            padding: 35px 20px 15px 20px;
            color: white;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-family: Arial;
            clear: both;
            margin-bottom: 0;
            box-shadow: 0px 0px 10px rgba(51, 51, 0, 0.7);
          }
          
          #contenedor {
            background: white;
            top: 100px;
            width: 440px;
            height: 380px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0px 0px 10px rgba(0, 51, 51, 0.7);
            font-family: Arial;
            position: relative;
          }
          
          input {font-family: Arial; font-size: medium;}
          p {font-family: Arial; font-size: large; color: red;}
        </style>
    </head>
    <body>
    <center>
        <h3>REGISTRO DIARIO</h3>
        <div id="contenedor">
            <br/><img src="<?=$foto?>" width="100" height="150"/><br/><br/>
            <form name="formulario" id="Myform"  method="POST" action="validarRegistro.php" onsubmit="return validar(this)">
                <input type="text" name="cedulaPersona" id="cedulaPersona" value="<?=$cedula?>" onchange="this.form.submit()"/>
            </form>
            <table border="0">
                <tr><th>Nombres:</th><td><?=$nombres?></td></tr>
                <tr><th>Cargo:</th><td><?=$cargo?></td></tr>
                <tr><th>Fecha:</th><td><?=$fecha?></td></tr>
            </table>
            <div  style="color:blue; font-weight:bold;font-size:20px;"><?=$mensaje?></div>
            <div  style="color:red; font-weight:bold;font-size:20px;"><?=$advertencia?></div>
        </div>
    </center>
    </body>
</html>