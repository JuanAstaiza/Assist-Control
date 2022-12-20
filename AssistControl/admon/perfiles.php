<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$lista='';
$datos= Perfil::getListaEnObjetos(null);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getNombre()}</td>";    
    $lista.="<td>{$objeto->getDescripcion()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/perfilesFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/perfilesActualizar.php&id={$objeto->getId()}')>";
    $lista.="<a href='principal.php?CONTENIDO=admon/perfilesAccesos.php&idPerfil={$objeto->getId()}' title='Accesos'><img src='presentacion/imagenes/accesos.png'></a>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<h3>LISTA DE PERFILES DE USUARIO</h3>
<br/>
<table border="1">
    <tr>
        <th>NOMBRE</th><th>DESCRIPCI&Oacute;N</th>
        <th><a href="principal.php?CONTENIDO=admon/perfilesFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>
    </tr>
    <?=$lista?>
</table>