<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_GET['id'])){
    $accion='Modificar';
    $contrato=new Contrato('id', $_GET['id']);
    $empresa=new Empresa('id', $contrato->getIdEmpresa());
} else {
    $accion='Adicionar';
    $contrato=new Contrato(null, null);
    $contrato->setFechaInicio(date('Y-m-d'));
    $empresa=new Empresa('id', $_GET['idEmpresa']);
}

?>
<h3><?=strtoupper($accion)?> CONTRATO PARA <?= strtoupper($empresa->getRazonSocial())?></h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/contratosActualizar.php">
<table>
    <tr><th>Sistema de informaci&oacute;n (*):</th><td><select name="idSI"><?=SI::getListaEnOptions($contrato->getIdSI())?></select></td></tr>
    <tr><th>Fecha de inicio (aaaa-mm-dd)(*):</th><td><input type="date" name="fechaInicio" value='<?=$contrato->getFechaInicio()?>' required/></td></tr>
    <tr><th>Fecha de finalizaci&oacute;n (aaaa-mm-dd):</th><td><input type="date" name="fechaFin" value='<?=$contrato->getFechaFin()?>' required/></td></tr>
    <tr><th>Valor: </th><td><input type="number" name="valor" value='<?=$contrato->getValor()?>' /></td></tr>
    
</table>
    <input type="hidden" name="id" value="<?=$contrato->getId()?>"/>
    <input type="hidden" name="idEmpresa" value="<?=$empresa->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    