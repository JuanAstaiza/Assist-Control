<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Permiso.php';
require_once 'admon/clases/Usuario.php';
require_once 'assistControl/clases/Motivo.php';
require_once 'assistControl/clases/Persona_A.php';
    $accion = 'Solicitar';
    $permiso = new Permiso(null, null);
    $fechasolicitud=date('Y-m-d');
    $required="required";
    $usuario= unserialize($_SESSION['usuario']);
    $cedula=$usuario->getUsuario();
    $motivo="";
    $mensaje="";
    if (isset($_GET['mensaje'])) {
        $mensaje=$_GET['mensaje'];
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


</script>
<center>
    <h3><?= strtoupper($accion)?> PERMISO</h3><br/><br/>
    <form name="formulario"  method="POST" action="principal.php?CONTENIDO=assistControl/permisosActualizarSolicitud.php" enctype="multipart/form-data" onsubmit="return validar(this)">
         <center><div  style="color:blue; font-weight:bold;font-size:14px;"><?=$mensaje?></div></center>
        <table border="0">
            <tr><th>Cedula:</th><td><input type="number" name="cedulapersona" value="<?=$cedula?>" readonly/></td></tr>
            <tr><th>Fecha De Solicitud(*):</th><td><input type="date" name="fechaSolicitud" value="<?=$fechasolicitud?>" readonly/></td></tr>
            <tr><th>Fecha Inicio(*):</th><td><input type="date" name="fechaInicio" value="<?=$permiso->getFechaInicio()?>" required/></td></tr>
            <tr><th>Fecha Fin(*):</th><td><input type="date" name="fechaFin" value="<?=$permiso->getFechaFin()?>" required/></td></tr>
            <tr><th>Motivo(*):</th><td><select name="codMotivo" required><option value="0">Escoja una opci&oacute;n</option><?= Motivo::getListaEnOptions($motivo)?></select></td></tr>
            <tr><th>Descripcion:</th><td><textarea name="descripcion"  rows="10" cols="40" maxlength="2500"/><?=$permiso->getDescripcion()?></textarea></td></tr>
            <tr><td colspan="2"><center><div id="msg" style="color:red; font-weight:bold;font-size:14px;"></div></center></td></tr>
           <tr><th>Anexo:</th><td><input type="file" name="anexo" value='<?=$permiso->getAnexo()?>' <?=$required?>/></td></tr>
        </table>
        <br><br><input type="submit" name="accion" value="<?=$accion?>"/>
        </form>
</center>
