<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Permiso.php';
require_once 'assistControl/clases/Motivo.php';
require_once 'assistControl/clases/Persona_A.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $permiso = new Permiso('codigo', $_GET['codigo']);
    $motivo=$permiso->getCodMotivo();
    $fechasolicitud=$permiso->getFechaSolicitud();
    $fechaincio=$permiso->getFechaInicio();
    $fechafinal=$permiso->getFechaFin();
    $foto="assistControl/fotos/{$permiso->getPersona()->getFoto()}";
    $anexo="<a target='_blank' href='assistControl/archivos/{$permiso->getAnexo()}'><img src='presentacion/imagenes/AssitControl/anexo.png' width='40' height='40' title='Archivo'/></a><br>";
    $cambiaranexo= "<b>Cambiar Anexo:</b>";
    $required="";
    $nombres="{$permiso->getPersona()->getPrimerNombre()}" . " " ."{$permiso->getPersona()->getSegundoNombre()}";
    $apellidos="{$permiso->getPersona()->getPrimerApellido()}" . " " ."{$permiso->getPersona()->getSegundoApellido()}";
    $cedulavisible="{$permiso->getCedulaPersona()}";
    $cedula_a_buscar="";
       $mensaje="";
    if (isset($_POST['buscar'])) {
        $cedula_a_buscar=$_POST['cedula'];
        $filtro="cast(cedula as varchar(999999)) like '$cedula_a_buscar'";
        $personas = Persona_A::getListaEnObjetos($filtro, null);
         $numeroregistros=count($personas);
            if ($numeroregistros>0) {
                $mensaje="Cédula de Ciudadania encontrada.";
            }else{
               $mensaje="No esta registrada la Cédula de Ciudadania.<br>Por favor intente de nuevo.";
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
    $permiso = new Permiso(null, null);
    $motivo="";
    $fechasolicitud=date('Y-m-d');
    $fechaincio= "";
    $fechafinal= "";
    $required="required";
    $anexo="";
    $cambiaranexo="";
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
<script type="text/javascript">

function validar(){
    if(confirm('Desea enviar esta Solicitud de Permiso?')){
        var OK = true;
        var frm = document.forms["formulario"];
        var f = frm.elements["anexo"];
        if (f.value==="") {
             OK = true; 
        }else{
            if( !f.value.match(/.(jpg)|(pdf)$/) ){
                document.getElementById("msg").innerHTML = "Archivo debe ser:<br> imagen (.jpg) o pdf.";
                OK = false;
            }
        }
        return OK;
    }
    return false;
}    


function aviso(){
    var opcion_a_buscar = document.getElementById("cedula").value;
    if (opcion_a_buscar===null) {
        document.getElementById('cedula').required = true;
    }else{
        document.getElementById('cedula').required = false;
     }
}
    
</script>
<center>
    <h3><?= strtoupper($accion)?> PERMISO</h3><br/><br/>
    <form  method="POST">
            <table>
            <tr><th>Cedula (*):</th><td><input type="number" name="cedula" value="<?=$permiso->getCedulaPersona()?>" required/>&nbsp;&nbsp;&nbsp;<input type="submit" value="Buscar" name="buscar"></td></tr>
            <center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje?></div></center>
            <tr><th>Foto:</th><td><img src="<?=$foto?>" width="60" height="75"/></td><tr>
            <tr><th>Nombres:</th><td><?=$nombres?></td></tr>
            <tr><th>Apellidos:</th><td><?=$apellidos?></td></tr>
        </table>
    </form>
    <br><br>
    <form name="formulario"   method="POST" action="principal.php?CONTENIDO=assistControl/permisosActualizar.php" enctype="multipart/form-data" onsubmit="return validar(this)">
        <table border="0">
            <tr><th>Cedula:</th><td><input type="number" name="cedulapersona" value="<?=$cedula_a_buscar?><?=$cedulavisible?>" readonly/></td></tr>
            <tr><th>Fecha De Solicitud(*):</th><td><input type="date" name="fechaSolicitud" value="<?=$fechasolicitud?>" readonly/></td></tr>
            <tr><th>Fecha Inicio(*):</th><td><input type="date" name="fechaInicio" value="<?=$fechaincio?>" required/></td></tr>
            <tr><th>Fecha Fin(*):</th><td><input type="date" name="fechaFin" value="<?=$fechafinal?>" required/></td></tr>
            <tr><th>Motivo(*):</th><td><select name="codMotivo" required><option value="0">Escoja una opci&oacute;n</option><?= Motivo::getListaEnOptions($motivo)?></select></td></tr>
            <tr><th>Descripcion:</th><td><textarea name="descripcion"  rows="10" cols="40"  maxlength="2500"><?=$permiso->getDescripcion()?></textarea></td></tr>
            <br>
                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$anexo?></td></tr>
                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$cambiaranexo?></td><tr>
                <tr><td colspan="2"><center><div id="msg" style="color:red; font-weight:bold;font-size:14px;"></div></center></td></tr>
                <tr><th>Anexo:</th><td><input type="file" name="anexo" value='<?=$permiso->getAnexo()?>' <?=$required?>/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$permiso->getCodigo()?>"/>
        <input type="hidden" name="cedulaanterior" value="<?=$permiso->getCedulaPersona()?>"/>
        <input type="hidden" name="anexoanterior" value="<?=$permiso->getAnexo()?>"/>
        <br><br><input type="submit" name="accion" value="<?=$accion?>" onchange="aviso();"/>
        </form>
</center>
