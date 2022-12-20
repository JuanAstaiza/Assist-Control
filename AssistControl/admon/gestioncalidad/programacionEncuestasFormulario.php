<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Encuesta.php';
require_once 'admon/clases/Perfil.php';
require_once 'admon/clases/ProgramacionEncuesta.php';

if (isset($_GET['id'])){
    $accion='Modificar';
    $programacionEncuesta=new ProgramacionEncuesta('id', $_GET['id']);    
    $encuesta=$programacionEncuesta->getEncuesta();
    $perfil=$programacionEncuesta->getIdPerfil();
} else {
    $accion='Adicionar';
    $programacionEncuesta=new ProgramacionEncuesta(null, null);
    $encuesta=new Encuesta('id', $_GET['idEncuesta']);
    $perfil="";
}

?>
<h3><?=strtoupper($accion)?> PROGRAMACI&Oacute;N PARA ENCUESTA <?= strtoupper($encuesta->getNombre())?></h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/gestioncalidad/programacionEncuestasActualizar.php">
<table>
    <tr><th>Fecha de inicio (aaaa-mm-dd HH:mm:ss)(*)</th><td><input type="datetime" name="fechaInicio" value='<?=$programacionEncuesta->getFechaInicio()?>' required/></td></tr>
    <tr><th>Fecha de finalizaci&oacute;n (aaaa-mm-dd HH:mm:ss) (*)</th><td><input type="datetime" name="fechaFin" value='<?=$programacionEncuesta->getFechaFin()?>' required /></td></tr>
    <tr><th>Perfil </th><td><select name="idPerfil"><option value="null">Todos</option><?= Perfil::getListaEnOptions($perfil)?></select></td></tr>    
</table>
    <input type="hidden" name="id" value="<?=$programacionEncuesta->getId()?>"/>
    <input type="hidden" name="idEncuesta" value="<?=$encuesta->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    