<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/TipoPregunta.php';
require_once 'admon/clases/Pregunta.php';
$lista='';
$datos= Pregunta::getListaEnObjetos(null);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getEnunciado()}</td>";    
    $lista.="<td>{$objeto->getTipo()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/preguntasFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/gestioncalidad/preguntasActualizar.php&id={$objeto->getId()}')>";
    if ($objeto->getTipo()->getCodigo()=='S') $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/alternativasRespuestas.php&idPregunta={$objeto->getId()}' title='Alternativas de respuestas'><img src='presentacion/imagenes/opciones.png'></a>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<h3>BANCO DE PREGUNTAS PARA ENCUESTAS</h3>
<br/>
<table border="1">
    <tr>
        <th>ENUNCIADO</th><th>TIPO</th>
        <th><a href="principal.php?CONTENIDO=admon/gestioncalidad/preguntasFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>
    </tr>
    <?=$lista?>
</table>
