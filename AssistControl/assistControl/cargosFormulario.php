<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $cargo = new Cargo('codigo', $_GET['codigo']);
    $perfil=$cargo->getCodPerfil();
} else {
    $accion = 'Adicionar';
    $cargo = new Cargo(null, null);
    $perfil="";
}
?>
<center>
    <h3><?= strtoupper($accion)?> CARGO</h3><br/><br/>
    <form name="formulario"  method="POST" action="principal.php?CONTENIDO=assistControl/cargosActualizar.php">
        <table border="0">
            <tr><th>Perfil (*):</th><td><select name="codPerfil" required><option value="0">Escoja una opci&oacute;n</option><?= Perfil_A::getListaEnOptions($perfil)?></select></td></tr>
            <tr><th>Cargo (*):</th><td><input type="text" name="nombre" value="<?=$cargo->getNombre()?>" maxlength="100" size="50" required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$cargo->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>