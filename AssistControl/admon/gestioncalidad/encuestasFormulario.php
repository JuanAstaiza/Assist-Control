<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Encuesta.php';

if (isset($_GET['id'])){
    $accion='Modificar';
    $encuesta=new Encuesta('id', $_GET['id']);
} else {
    $accion='Adicionar';
    $encuesta=new Encuesta(null, null);
}

?>
<h3><?=strtoupper($accion)?> ENCUESTA</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/gestioncalidad/encuestasActualizar.php">
<table>
    <tr><th>Nombre (*)</th><td><input type="text" name="nombre" maxlength="100" size="50" value='<?=$encuesta->getNombre()?>' required/></td></tr>
    <tr><th>Objetivo</th><td><input type="text" name="objetivo" maxlength="250" size="50" value='<?=$encuesta->getObjetivo()?>'/></td></tr>
    <tr><th>Descripci&oacute;n</th><td><textarea name="descripcion" cols="50" rows="5"><?=$encuesta->getDescripcion()?></textarea></td></tr> 
</table>
    <input type="hidden" name="id" value="<?=$encuesta->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    