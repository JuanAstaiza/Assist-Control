<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$empresa=new Empresa('id', $_GET['idEmpresa']);
$lista='';
$datos= Contrato::getListaEnObjetos("idEmpresa={$empresa->getId()}");
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getSI()}</td>";    
    $lista.="<td>{$objeto->getFechaInicio()}</td>";    
    $lista.="<td>{$objeto->getFechaFin()}</td>";    
    $lista.="<td>{$objeto->getValor()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/contratosFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/contratosActualizar.php&id={$objeto->getId()}')>";    
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<br/><br/><br/>
<table border="0">
    <tr><th>Raz&oacute;n social</th><td><?=$empresa->getRazonSocial()?></td></tr>
    <tr><th>Base de datos</th><td><?=$empresa->getBd()?></td></tr>
    <tr><th>Prefijo</th><td><?=$empresa->getPrefijo()?></td></tr>
</table><br>
<h3>LISTA DE CONTRATOS</h3>
<br/>
<table border="1">
    <tr>
        <th>Sistema</th><th>Inicio</th><th>Fin</th><th>Valor</th>
        <th><a href="principal.php?CONTENIDO=admon/contratosFormulario.php&idEmpresa=<?=$empresa->getId()?>" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>
    </tr>
    <?=$lista?>
</table>