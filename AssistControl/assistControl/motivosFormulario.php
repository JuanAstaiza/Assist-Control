<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Motivo.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $motivo = new Motivo('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $motivo = new Motivo(null, null);
}
?>
<center>
    <h3><?=strtoupper($accion)?> MOTIVO</h3>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/motivosActualizar.php">
        <table>
            <tr><th>Nombre (*)</th><td><input type="text" name="nombre" maxlength="50" size="50" value='<?=$motivo->getNombre()?>' required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$motivo->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>