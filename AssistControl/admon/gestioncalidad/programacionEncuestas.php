<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Encuesta.php';
require_once 'admon/clases/Perfil.php';
require_once 'admon/clases/ProgramacionEncuesta.php';
$encuesta=new Encuesta('id', $_GET['idEncuesta']);
$lista='';
$datos= ProgramacionEncuesta::getListaEnObjetos("idEncuesta={$encuesta->getId()}");
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getFechaInicio()}</td>";    
    $lista.="<td>{$objeto->getFechaFin()}</td>";    
    $lista.="<td>{$objeto->getPerfil()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/programacionEncuestasFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/gestioncalidad/programacionEncuestasActualizar.php&id={$objeto->getId()}')>";    
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/programacionEncuestasResultados.php&id={$objeto->getId()}' title='Ver Resultados'><img src='presentacion/imagenes/resultados.png' width='30' height='30'></a>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<table border="0">
    <tr><th>Encuesta</th><td><?=$encuesta->getNombre()?></td></tr>
    <tr><th>Objetivo</th><td><?=$encuesta->getObjetivo()?></td></tr>
    <tr><th>Descripc&oacute;n</th><td><?=$encuesta->getDescripcion()?></td></tr>
</table><br>
<h3>ENCUESTAS PROGRAMADAS</h3>
<br/>
<table border="1">
    <tr>
        <th>Inicio</th><th>Fin</th><th>Perfil</th>
        <th><a href="principal.php?CONTENIDO=admon/gestioncalidad/programacionEncuestasFormulario.php&idEncuesta=<?=$encuesta->getId()?>" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>
    </tr>
    <?=$lista?>
</table>
