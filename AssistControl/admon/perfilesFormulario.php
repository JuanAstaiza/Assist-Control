<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_GET['id'])){
    $accion='Modificar';
    $perfil=new Perfil('id', $_GET['id']);
} else {
    $accion='Adicionar';
    $perfil=new PERFIL(null, null);
}

?>
<h3><?=strtoupper($accion)?> PERFILES DE USUARIO</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/perfilesActualizar.php">
<table>
    <tr><th>Nombre (*):</th><td><input type="text" name="nombre" maxlength="50" size="50" value='<?=$perfil->getNombre()?>' required/></td></tr>
    <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" cols="50" rows="5"><?=$perfil->getDescripcion()?></textarea></td></tr>
</table>
    <input type="hidden" name="id" value="<?=$perfil->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    