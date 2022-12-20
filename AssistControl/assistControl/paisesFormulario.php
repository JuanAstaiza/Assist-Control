<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Pais_A.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $pais = new Pais_A('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $pais = new Pais_A(null, null);
}
?>
<center>
    <h3><?=strtoupper($accion)?> PAIS</h3>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/paisesActualizar.php">
        <table>
            <tr><th>C&oacute;digo (*):</th><td><input type="text" name="codigo" maxlength="3" value='<?=$pais->getCodigo()?>' required/></td></tr>
            <tr><th>Nombre (*):</th><td><input type="text" name="nombre" maxlength="50" size="50" value='<?=$pais->getNombre()?>' required/></td></tr>
        </table>
        <input type="hidden" name="codigoAnterior" value="<?=$pais->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>