<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Perfil_A.php';
$lista = '';
$perfiles = Perfil_A::getListaEnObjetos(null);
for ($i = 0; $i < count($perfiles); $i++) {
    $perfil = $perfiles[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$perfil->getNombre()}</td>";
    $lista.= "<td>{$perfil->getDescripcion()}</td>";
    $lista.= '<td>';
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/perfilesFormulario.php&codigo={$perfil->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
    $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/perfilesActualizar.php&codigo={$perfil->getCodigo()}'); />";
    $lista.= '</td>';
    $lista.= '</tr>';
}
?>
<center>
    <h3>LISTA DE PERFILES</h3><br/><br/>
    <table border="1">
        <tr><th>Nombre</th><th>Descripci&oacute;n</th><th><a href="principal.php?CONTENIDO=assistControl/perfilesFormulario.php" title="Adicionar"><img src="presentacion/imagenes/AssitControl/adicionar.png"/></a></th></tr>
        <?=$lista?>
    </table>
</center>