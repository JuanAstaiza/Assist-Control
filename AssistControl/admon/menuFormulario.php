<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
if (isset($id)){
    $accion='Modificar';
    $menu=new MENU('id', $id);
} else {
    $accion='Adicionar';
    $menu=new MENU(null, null);
    $menu->setIdSI($idSI);
}
?>
<h3><?=strtoupper($accion)?> MEN&Uacute; PARA EL SISTEMA <?= strtoupper($menu->getSI()->getNombre())?></h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/menuActualizar.php">
<table>
    <tr><th>Nombre (*);</th><td><input type="text" name="nombre" maxlength="50" size="50" value="<?=$menu->getNombre()?>" required/></td></tr>
    <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" cols="50" rows="5"><?=$menu->getDescripcion()?></textarea></td></tr>
</table>
    <input type="hidden" name="idSI" value="<?=$menu->getIdSI()?>"/>
    <input type="hidden" name="id" value="<?=$menu->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    
