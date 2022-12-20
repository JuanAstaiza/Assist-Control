<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Encuesta.php';
$lista='';
$datos= Encuesta::getListaEnObjetos(null);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getNombre()}</td>";    
    $lista.="<td>{$objeto->getObjetivo()}</td>";    
    $lista.="<td>{$objeto->getDescripcion()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/encuestasFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/gestioncalidad/encuestasActualizar.php&id={$objeto->getId()}')>";
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/preguntasEncuestas.php&idEncuesta={$objeto->getId()}' title='Preguntas de la encuesta'><img src='presentacion/imagenes/opciones.png'></a>";
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/programacionEncuestas.php&idEncuesta={$objeto->getId()}' title='Programaciones de encuestas'><img src='presentacion/imagenes/programacion_encuesta.png' width='30' height='30'></a>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<h3>LISTA DE ENCUESTAS</h3>
<br/>
<table border="1">
    <tr>
        <th>NOMBRE</th><th>OBJETIVO</th><th>DESCRIPCI&Oacute;N</th>
        <th><a href="principal.php?CONTENIDO=admon/gestioncalidad/encuestasFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>
    </tr>
    <?=$lista?>
</table>
