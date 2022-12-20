<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Motivo.php';
$lista = '';
$motivos = Motivo::getListaEnObjetos(null);
for ($i = 0; $i < count($motivos); $i++) {
    $motivo = $motivos[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$motivo->getNombre()}</td>";
    $lista.= '<td>';
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/motivosFormulario.php&codigo={$motivo->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
    $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/motivosActualizar.php&codigo={$motivo->getCodigo()}'); />";
    $lista.= '</td>';
    $lista.= '</tr>';
}
?>
<center>
    <h3>LISTA DE MOTIVOS PARA PERMISOS</h3><br/><br/>
    <table border="1">
        <tr><th>Nombre</th><th><a href="principal.php?CONTENIDO=assistControl/motivosFormulario.php" title="Adicionar"><img src="presentacion/imagenes/AssitControl/adicionar.png"/></a></th></tr>
        <?=$lista?>
    </table>
</center>