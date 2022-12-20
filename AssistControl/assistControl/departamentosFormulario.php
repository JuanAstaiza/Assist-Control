<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Pais_A.php';
require_once 'assistControl/clases/Departamento_A.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $departamento = new Departamento_A('codigo', $_GET['codigo']);
    $pais=$departamento->getCodPais();
} else {
    $accion = 'Adicionar';
    $departamento = new Departamento_A(null, null);
    $pais="";
}
?>
<center>
    <h3><?= strtoupper($accion)?> DEPARTAMENTO</h3><br/><br/>
    <form name="formulario" method="POST" action="principal.php?CONTENIDO=assistControl/departamentosActualizar.php">
        <table border="0">
            <tr><th>Pais (*):</th><td><select name="codPais" required><option value="0">Escoja una opci&oacute;n</option><?= Pais_A::getListaEnOptions($pais)?></select></td></tr>
            <tr><th>Departamento (*):</th><td><input type="text" name="nombre" value="<?=$departamento->getNombre()?>" maxlength="100" size="50" required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$departamento->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>