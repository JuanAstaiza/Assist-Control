<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Vinculacion.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $vinculacion = new Vinculacion('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $vinculacion = new Vinculacion(null, null);
}
?>
<center>
    <h3><?=strtoupper($accion)?> VINCULACION</h3>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/vinculacionesActualizar.php">
        <table>
            <tr><th>Nombre (*)</th><td><input type="text" name="nombre" maxlength="50" size="50" value='<?=$vinculacion->getNombre()?>' required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$vinculacion->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>