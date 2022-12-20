<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/AreaEnsenanza.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $areaEnsenanza = new AreaEnsenanza('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $areaEnsenanza = new AreaEnsenanza(null, null);
}
?>
<center>
    <h3><?=strtoupper($accion)?> AREA DE ENSE&Ntilde;ANZA</h3>
    <form name="formulario" method="post" action="principal.php?CONTENIDO=assistControl/areasEnsenanzaActualizar.php">
        <table>
            <tr><th>Nombre (*)</th><td><input type="text" name="nombre" maxlength="50" size="50" value='<?=$areaEnsenanza->getNombre()?>' required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$areaEnsenanza->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>