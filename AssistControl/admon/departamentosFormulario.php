<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Pais.php';
require_once 'admon/clases/Departamento.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $departamento = new Departamento('codigo', $_GET['codigo']);
    $pais=$departamento->getCodPais();
} else {
    $accion = 'Adicionar';
    $departamento = new Departamento(null, null);
    $pais="";
}
?>
<center>
    <h3><?= strtoupper($accion)?> DEPARTAMENTO</h3><br/><br/>
    <form name="formulario" method="POST" action="principal.php?CONTENIDO=admon/departamentosActualizar.php">
        <table border="0">
            <tr><th>Codigo (*):</th><td><input type="number"  name="codigo" value="<?=$departamento->getCodigo()?>" required></td></tr>
            <tr><th>Pais (*):</th><td><select name="codPais" required><option value="0">Escoja una opci&oacute;n</option><?= Pais::getListaEnOptions($pais)?></select></td></tr>
            <tr><th>Departamento (*):</th><td><input type="text" name="nombre" value="<?=$departamento->getNombre()?>" maxlength="100" size="50" required/></td></tr>
        </table>
        <input type="hidden" name="codigoAnterior" value="<?=$departamento->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>