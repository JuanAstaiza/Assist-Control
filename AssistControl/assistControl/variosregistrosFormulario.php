<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Registro.php';
require_once 'assistControl/clases/Persona_A.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $registro = new Registro('codigo', $_GET['codigo']);
    if ($registro->getTipo()=='1') {$entrada='checked'; $salida='';}
    else {$entrada=''; $salida='checked';}
    $foto="assistControl/fotos/{$registro->getPersona()->getFoto()}";
    $nombres="{$registro->getPersona()->getPrimerNombre()}" . " " ."{$registro->getPersona()->getSegundoNombre()}";
    $apellidos="{$registro->getPersona()->getPrimerApellido()}" . " " ."{$registro->getPersona()->getSegundoApellido()}";
    $cedulavisible="{$registro->getCedulaPersona()}";
    $cedula_a_buscar="";
       $mensaje="";
    if (isset($_POST['buscar'])) {
        $cedula_a_buscar=$_POST['cedula'];
        $filtro="cast(cedula as varchar(999999)) like '$cedula_a_buscar'";
        $personas = Persona_A::getListaEnObjetos($filtro, null);
         $numeroregistros=count($personas);
            if ($numeroregistros>0) {
                $mensaje="C&eacute;dula de Ciudadania encontrada.";
            }else{
               $mensaje="No esta registrada la C&eacute;dula de Ciudadania.<br>Por favor intente de nuevo.";
               $cedula_a_buscar=null;
            }
        for ($i = 0; $i < count($personas); $i++) {
            $persona = $personas[$i];
                $cedula_a_buscar=$persona->getCedula();
                $foto="assistControl/fotos/{$persona->getFoto()}";
                $nombres="{$persona->getPrimerNombre()}" . " " ."{$persona->getSegundoNombre()}";
                $apellidos="{$persona->getPrimerApellido()}" . " " ."{$persona->getSegundoApellido()}";
        }
    }
} else {
    $accion = 'Adicionar';
    $registro = new Registro(null, null);
    $entrada='';
    $salida='';
    $foto="presentacion/imagenes/AssitControl/foto_SinFondo.png";
    $cedulavisible="";
    $nombres="";
    $apellidos="";
    $cedula_a_buscar=null;
    $mensaje="";
    if (isset($_POST['buscar'])) {
        $cedula_a_buscar=$_POST['cedula'];
        $filtro="cast(cedula as varchar(999999)) like '$cedula_a_buscar'";
        $personas = Persona_A::getListaEnObjetos($filtro, null);
         $numeroregistros=count($personas);
            if ($numeroregistros>0) {
                $mensaje="C&eacute;dula de Ciudadania encontrada.";
            }else{
               $mensaje="No esta registrada la C&eacute;dula de Ciudadania.<br>Por favor intente de nuevo.";
               $cedula_a_buscar=null;
            }
        for ($i = 0; $i < count($personas); $i++) {
            $persona = $personas[$i];
                $cedula_a_buscar=$persona->getCedula();
                $foto="assistControl/fotos/{$persona->getFoto()}";
                $nombres="{$persona->getPrimerNombre()}" . " " ."{$persona->getSegundoNombre()}";
                $apellidos="{$persona->getPrimerApellido()}" . " " ."{$persona->getSegundoApellido()}";
        }
    }
}
?>
<center>
    <h3><?=strtoupper($accion)?> REGISTRO</h3><br/><br/>
     <form  method="POST">
            <table>
            <tr><th>Cedula (*):</th><td><input type="number" name="cedula" value="<?=$registro->getCedulaPersona()?>" required/>&nbsp;&nbsp;&nbsp;<input type="submit" value="Buscar" name="buscar"></td></tr>
            <center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje?></div></center>
            <tr><th>Foto:</th><td><img src="<?=$foto?>" width="60" height="75"/></td><tr>
            <tr><th>Nombres:</th><td><?=$nombres?></td></tr>
            <tr><th>Apellidos:</th><td><?=$apellidos?></td></tr>
        </table>
    </form>
    <br><br>  
    <form name="formulario"  method="POST" action="principal.php?CONTENIDO=assistControl/variosregistrosActualizar.php">
        <table border="0">
            <tr><th>Cedula:</th><td><input type="number" name="cedulaPersona" value="<?=$cedula_a_buscar?><?=$cedulavisible?>" readonly/></td></tr>
            <tr><th>Fecha</th><td><input type="datetime" name="fecha" value="<?=$registro->getFecha()?>"/></td></tr>
            <tr><th>Tipo</th><td><input type="radio" name="tipo" value="true" selected <?=$entrada?>/>Entrada<input type="radio" name="tipo" value="false" <?=$salida?>/>Salida</td></tr>
        </table><br><br>
        <input type="hidden" name="codigo" value="<?=$registro->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>