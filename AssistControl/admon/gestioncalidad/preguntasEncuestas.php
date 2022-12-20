<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/TipoPregunta.php';
require_once 'admon/clases/Pregunta.php';
require_once 'admon/clases/Encuesta.php';

$encuesta=new Encuesta('id', $_GET['idEncuesta']);
$lista='';
$preguntasEncuestas= $encuesta->getPreguntasEnId();
$preguntas= Pregunta::getListaEnObjetos(null);
for ($i = 0; $i < count($preguntas); $i++) {
    $objeto=$preguntas[$i];
    $lista.='<tr>';
    if (in_array($objeto->getId(), $preguntasEncuestas)) $auxiliar='checked';
    else $auxiliar='';
    $lista.="<td><input type='checkbox' name='idPregunta_{$objeto->getId()}' $auxiliar> {$objeto->getEnunciado()}</td>";    
    //$lista.="<td>{$objeto->getEnunciado()}</td>";    
    $lista.="<td>{$objeto->getTipo()}</td>";    
    /*$lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/preguntasFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/gestioncalidad/preguntasActualizar.php&id={$objeto->getId()}')>";
    if ($objeto->getTipo()->getCodigo()=='S') $lista.="<a href='principal.php?CONTENIDO=admon/gestioncalidad/alternativasRespuestas.php&idPregunta={$objeto->getId()}' title='Alternativas de respuestas'><img src='presentacion/imagenes/opciones.png'></a>";
    $lista.="</td>";    */
    $lista.='</tr>';
}
$lista.='</table>';

?>

<table border="0">
    <tr><th>Encuesta</th><td><?=$encuesta->getNombre()?></td></tr>
    <tr><th>Objetivo</th><td><?=$encuesta->getObjetivo()?></td></tr>
    <tr><th>Descripci&oacute;n</th><td><?=$encuesta->getDescripcion()?></td></tr>
</table><br>
<h3>PREGUNTAS DE LA ENCUESTA</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/gestioncalidad/encuestasActualizar.php">
<table border="1">
    <tr>
        <th>PREGUNTA</th><th>TIPO</th>
    </tr>
    <?=$lista?>
</table>
<input type="hidden" name="idEncuesta" value="<?=$encuesta->getId()?>">
<input type="submit" name="accion" value="Actualizar preguntas">
</form>