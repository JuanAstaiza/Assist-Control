<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$lista='';
$datos=SI::getListaEnObjetos(null);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getNombre()}</td>";    
    $lista.="<td>{$objeto->getDescripcion()}</td>";    
    $lista.="<td>{$objeto->getVersion()}</td>";    
    $lista.="<td>{$objeto->getAutor()}</td>";    
    $lista.="<td>{$objeto->getScriptBD()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/siFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/siActualizar.php&id={$objeto->getId()}')>";
    $lista.="<a href='principal.php?CONTENIDO=admon/menu.php&idSI={$objeto->getId()}' title='Men&uacute;'><img src='presentacion/imagenes/opciones.png'></a>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<h3>LISTA DE SISTEMAS DE INFORMACI&Oacute;N</h3>
<br/>
<table border="1">
    <tr>
        <th>NOMBRE</th><th>DESCRIPCI&Oacute;N</th><th>VERSI&Oacute;N</th><th>AUTOR</th><th>SCRIPT BD</th>
        <th><a href="principal.php?CONTENIDO=admon/siFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>        
    </tr>
    <?=$lista?>
</table>