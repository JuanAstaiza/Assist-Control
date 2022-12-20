<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Perfil_A.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $perfil = new Perfil_A('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $perfil = new Perfil_A(null, null);
}
?>
<center>
    <h3><?=strtoupper($accion)?> PERFIL</h3>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/perfilesActualizar.php">
        <table>
            <tr><th>Nombre (*):</th><td><input type="text" name="nombre" maxlength="50" size="50" value="<?=$perfil->getNombre()?>" required/></td></tr>
            <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" cols="50" rows="5"><?=$perfil->getDescripcion()?></textarea></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$perfil->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>