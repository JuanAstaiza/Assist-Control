<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_GET['id'])){
    $accion='Modificar';
    $si=new SI('id', $_GET['id']);
    $imagen_bd="<img src='presentacion/imagenes/bd.png' width='60' height='75' title='{$si->getScriptBD()}'/>";
    $nombre_bd=$si->getScriptBD();
    $cambiarBD= "<b>Cambiar BD:</b>";
    $required="";
} else {
    $accion='Adicionar';
    $si=new SI(null, null);
    $imagen_bd="";
    $nombre_bd="";
    $cambiarBD="";
    $required="required";
}
?>
<script type="text/javascript">
function validar(){
    var OK = true;
    var frm = document.forms["formulario"];
    var f = frm.elements["scriptBD"];
    if (f.value==="") {
         OK = true; 
    }else{
        if( !f.value.match(/\.(sql)$/) ){
            document.getElementById("msg").innerHTML = "Extension debe ser sql.";
            OK = false;
        }
    }
    return OK;
}
</script>
<h3><?=strtoupper($accion)?> SISTEMAS DE INFORMACI&Oacute;N</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/siActualizar.php" enctype="multipart/form-data" onsubmit="return validar(this)">

   <table>
    <tr><th>Nombre (*):</th><td><input type="text" name="nombre" maxlength="50" size="50" value="<?=$si->getNombre()?>" required/></td></tr>
    <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" cols="50" rows="5" maxlength="2500"><?=$si->getDescripcion()?></textarea></td></tr>
    <tr><th>Versi&oacute;n:</th><td><input type="text" name="version" value="<?=$si->getVersion()?>" required/></td></tr>
    <tr><th>Autor:</th><td><input type="text" name="autor" maxlength="100" size="50" value="<?=$si->getAutor()?>" required/></td></tr>
    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$imagen_bd?></td></tr>
    <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$nombre_bd?></td></tr>
    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$cambiarBD?></td></tr>
    <tr><td><div id="msg" style="color:red; font-weight:bold;font-size:14px;"></div> </tr></td>
    <tr><th>Script de la base de datos (*):</th><td><input type="file" name="scriptBD" maxlength="50" size="50" value="<?=$si->getScriptBD()?>" <?=$required?>/></td></tr>
</table>
    <input type="hidden" name="id" value="<?=$si->getId()?>"/>
    <input type="hidden" name="bdanterior" value="<?=$si->getScriptBD()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    