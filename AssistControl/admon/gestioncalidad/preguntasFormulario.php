<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/TipoPregunta.php';
require_once 'admon/clases/Pregunta.php';

if (isset($_GET['id'])){
    $accion='Modificar';
    $pregunta=new Pregunta('id', $_GET['id']);
    $tipopreguntas=$pregunta->getTipo()->getCodigo();
} else {
    $accion='Adicionar';
    $pregunta=new Pregunta(null, null);
    $tipopreguntas="";
}

?>
<h3><?=strtoupper($accion)?> PREGUNTA</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/gestioncalidad/preguntasActualizar.php">
<table>
    <tr><th>Enunciado (*)</th><td><input type="text" name="enunciado" maxlength="250" size="50" value='<?=$pregunta->getEnunciado()?>' required/></td></tr>
    <tr><th>Tipo (*)</th><td><select name="tipo"><?= TipoPregunta::getListaEnOptions($tipopreguntas)?></select></td></tr>    
</table>
    <input type="hidden" name="id" value="<?=$pregunta->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    