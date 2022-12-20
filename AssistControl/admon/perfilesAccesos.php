<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$perfil=new Perfil('id', $_GET['idPerfil']);
$accesos=$perfil->getAccesosEnId();
$lista='';
$sistemas=SI::getListaEnObjetos(null);
for ($i = 0; $i < count($sistemas); $i++) {
    $si=$sistemas[$i];
    $lista.='<br/><br/><b>SISTEMA: </b> '. strtoupper($si->getNombre()) .'<br/>';
    $menus=Menu::getListaEnObjetos("idSI={$si->getId()}");
    for ($j = 0; $j < count($menus); $j++) {
        $menu=$menus[$j];
        $lista.="<br>{$menu->getNombre()}";
        $opciones=Opcion::getListaEnObjetos("idMenu={$menu->getId()}");
        $lista.='<table border="0">';
        for ($h = 0; $h < count($opciones); $h++) {
            $opcion=$opciones[$h];            
            if ($h%8==0){
                if ($h!=0) $lista.='</tr>';
                $lista.='<tr>';
            }
            if (in_array($opcion->getId(), $accesos)) $auxiliar='checked';
            else $auxiliar='';
            $lista.="<td><input type='checkbox' name='idOpcion_{$opcion->getId()}' $auxiliar> {$opcion->getNombre()}</td>";
        }
        $lista.='</tr>';
        $lista.='</table>';
    }
    //otras opciones
    $lista.="<br>Otras opciones";
    $opciones=Opcion::getListaEnObjetos("idMenu is null and idSI={$si->getId()}");
    $lista.='<table border="0">';
    for ($h = 0; $h < count($opciones); $h++) {
        $opcion=$opciones[$h];            
        if ($h%8==0){
            if ($h!=0) $lista.='</tr>';
            $lista.='<tr>';
        }
        if (in_array($opcion->getId(), $accesos)) $auxiliar='checked';
        else $auxiliar='';
        $lista.="<td><input type='checkbox' name='idOpcion_{$opcion->getId()}' $auxiliar> {$opcion->getNombre()}</td>";
    }
    $lista.='</tr>';
    $lista.='</table>';
    
}
?>
<h3>ACCESOS DEL PERFIL <?=strtoupper($perfil->getNombre())?></h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/perfilesActualizar.php">
    <?=$lista?>
    <br/>
    <input type="hidden" name="idPerfil" value="<?=$perfil->getId()?>">
    <input type="submit" name="accion" value="Actualizar accesos">
</form>