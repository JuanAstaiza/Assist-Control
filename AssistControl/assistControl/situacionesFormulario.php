<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Situacion.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $situacion = new Situacion('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $situacion = new Situacion(null, null);
}
?>
<center>
    <h3><?=strtoupper($accion)?> SITUACION</h3>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/situacionesActualizar.php">
        <table>
            <tr><th>Nombre (*)</th><td><input type="text" name="nombre" maxlength="50" size="50" value='<?=$situacion->getNombre()?>' required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$situacion->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>