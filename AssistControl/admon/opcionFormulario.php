<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
if (isset($id)){
    $accion='Modificar';
    $opcion=new Opcion('id', $id);
    $si=new SI('id',$idSI);
    if ($opcion->getIdMenu()==null) $nombreMenu="";else $nombreMenu="{$opcion->getMenu()->getNombre()}";
    if ($opcion->getIdMenu()==null) $idMenu="null";else $idMenu=$idMenu;
} else {
    $accion='Adicionar';
    $opcion=new Opcion(null, null);
    if ($opcion->getIdMenu()==null) $nombreMenu="";else $nombreMenu="{$opcion->getMenu()->getNombre()}";
    $opcion->setIdMenu($idMenu);
    if ($idMenu!='null') $si=new SI('id',$idSI);
    else $si=new SI('id',$idSI);
}
?>
<h3><?=strtoupper($accion)?> OPCION PARA EL MENU <?=$nombreMenu?> DEL SISTEMA <?= strtoupper($si->getNombre())?></h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/opcionActualizar.php">
<table>
    <tr><th>Nombre (*):</th><td><input type="text" name="nombre" maxlength="50" size="50" value="<?=$opcion->getNombre()?>" required/></td></tr>
    <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" cols="50" rows="5"><?=$opcion->getDescripcion()?></textarea></td></tr>
    <tr><th>Ruta (*):</th><td><input type="text" name="ruta" maxlength="100" size="50" value="<?=$opcion->getRuta()?>" required/></td></tr>
</table>
    <input type="hidden" name="idMenu" value="<?=$idMenu?>"/>
    <input type="hidden" name="idSI" value="<?=$si->getId()?>"/>
    <input type="hidden" name="id" value="<?=$opcion->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    
