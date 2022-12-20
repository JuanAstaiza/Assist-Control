<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/TipoPregunta.php';
require_once 'admon/clases/Pregunta.php';
require_once 'admon/clases/AlternativaRespuesta.php';
$pregunta=new Pregunta('id', $_GET['idPregunta']);
$lista='';
$datos= AlternativaRespuesta::getListaEnObjetos("idPregunta={$pregunta->getId()}");
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getTexto()}</td>";    
    $lista.="<td>";
    //$lista.="<a href='principal.php?CONTENIDO=admon/contratosFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/gestioncalidad/alternativasRespuestasActualizar.php&id={$objeto->getId()}')>";    
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<table border="0">
    <tr><th>Enunciado</th><td><?=$pregunta->getEnunciado()?></td></tr>
    <tr><th>Tipo</th><td><?=$pregunta->getTipo()?></td></tr>
</table><br>
<h3>Alternativas de respuesta</h3>
<br/>
<table border="1">
    <tr>
        <th>Alternativa de respuesta</th>
        <!--<th><a href="principal.php?CONTENIDO=admon/gestioncalidad/alternativasRespuestasFormulario.php&idPregunta=<?=$pregunta->getId()?>" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>-->
    </tr>
    <?=$lista?>
</table>
<br><br>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/gestioncalidad/alternativasRespuestasActualizar.php">
    <b>Alternativa de respuesta:</b> <input type="text" name="texto" size="50" maxlength="250" />
    <input type="hidden" name="idPregunta" value="<?=$pregunta->getId();?>"/>
    <input type="submit" name="accion" value="Adicionar"/>
</form>