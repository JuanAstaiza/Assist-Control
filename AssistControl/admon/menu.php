<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$si=new SI('id', $_GET['idSI']);
$lista='';
$menus=Menu::getListaEnObjetos("idSI={$si->getId()}");
for ($i = 0; $i < count($menus); $i++) {
    $menu=$menus[$i];
    $lista.="<br/><b>Men&uacute;: </b><label title='{$menu->getDescripcion()}'>{$menu->getNombre()}</label><a href='principal.php?CONTENIDO=admon/menuFormulario.php&id={$menu->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'/></a> <img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/menuActualizar.php&id={$menu->getId()}'); /><br/>";
    $lista.='<table border="1">';
    $lista.="<tr><th>Opci&oacute;n</th><th>Descripci&oacute;n</th><th>Ruta</th><th><a href='principal.php?CONTENIDO=admon/opcionFormulario.php&idMenu={$menu->getId()}&idSI={$si->getId()}'><img src='presentacion/imagenes/adicionar.png'></a></th></tr>";
    $opciones=Opcion::getListaEnObjetos("idMenu={$menu->getId()}");
    for ($j = 0; $j < count($opciones); $j++) {
        $opcion=$opciones[$j];
        $lista.="<tr>";
        $lista.="<td>{$opcion->getNombre()}</td><td>{$opcion->getDescripcion()}</td><td>{$opcion->getRuta()}</td>";
        $lista.="<td>";
        $lista.="<a href='principal.php?CONTENIDO=admon/opcionFormulario.php&id={$opcion->getId()}&idSI={$si->getId()}&idMenu={$opcion->getIdMenu()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'/></a>";
        $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/opcionActualizar.php&id={$opcion->getId()}'); />";
        $lista.="</td>";
        $lista.="</tr>";
    }    
    $lista.='</table>';
}
$lista.="<br/><b>Otras opciones</b><br/>";
$lista.='<table border="1">';
$lista.="<tr><th>Opci&oacute;n</th><th>Descripci&oacute;n</th><th>Ruta</th><th><a href='principal.php?CONTENIDO=admon/opcionFormulario.php&idMenu=null&idSI={$si->getId()}'><img src='presentacion/imagenes/adicionar.png'></a></th></tr>";
$opciones=Opcion::getListaEnObjetos("idMenu is null and ruta is not null and idSI={$si->getId()}");
for ($j = 0; $j < count($opciones); $j++) {
    $opcion=$opciones[$j];
    $lista.="<tr>";
    $lista.="<td>{$opcion->getNombre()}</td><td>{$opcion->getDescripcion()}</td><td>{$opcion->getRuta()}</td>";
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/opcionFormulario.php&id={$opcion->getId()}&idMenu=null&idSI={$si->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'/></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/opcionActualizar.php&id={$opcion->getId()}'); />";
    $lista.="</td>";
    $lista.="</tr>";
}    
$lista.='</table>';

?>

<b>Sistema de informaci&oacute;n: </b> <?=$si->getNombre()?> <b>Versi&oacute;n: </b> <?=$si->getVersion()?><br/>
<b>Autor: </b><?=$si->getAutor()?>
<br/><br/><h3>MEN&Uacute; DEL SISTEMA <a href="principal.php?CONTENIDO=admon/menuFormulario.php&idSI=<?=$si->getId()?>" title="Adicionar menú"><img src="presentacion/imagenes/adicionar.png"/></a></h3>
<?=$lista?>
