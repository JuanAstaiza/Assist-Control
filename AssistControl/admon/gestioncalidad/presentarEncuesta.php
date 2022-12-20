<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/TipoPregunta.php';
require_once 'admon/clases/Pregunta.php';
require_once 'admon/clases/Encuesta.php';
require_once 'admon/clases/AlternativaRespuesta.php';
require_once 'admon/clases/ProgramacionEncuesta.php';

$programacionEncuestas= $USUARIO->getEncuestasPendientes();
if (count($programacionEncuestas)>0){
    $programacionEncuesta=$programacionEncuestas[0];
    $encuesta=$programacionEncuesta->getEncuesta();
    $lista='';
    $preguntasEncuestas= $encuesta->getPreguntasEnId();
    for ($i = 0; $i < count($preguntasEncuestas); $i++) {
        $objeto=new Pregunta('id', $preguntasEncuestas[$i]);
        $lista.='<br/>' . ($i+1).". {$objeto->getEnunciado()}<br>";
        switch ($objeto->getTipo()->getCodigo()){
            case 'F': 
                $lista.="<input type='radio' name='rta{$objeto->getId()}' value='V' required/> Verdadero<br/>";
                $lista.="<input type='radio' name='rta{$objeto->getId()}' value='F' required/> Falso<br/>"; 
                break;
            case 'S':
                $alternativas= AlternativaRespuesta::getListaEnObjetos("idPregunta={$objeto->getId()}");
                for ($j = 0; $j < count($alternativas); $j++) {
                    $alternativa=$alternativas[$j];
                    $lista.="<input type='radio' name='rta{$objeto->getId()}' value='{$alternativa->getId()}' required/> {$alternativa->getTexto()}<br/>";
                }
                break;
            case 'A':
                $lista.="<textarea name='rta{$objeto->getId()}' cols='70' rows='5'></textarea><br/>";
                break;
        }                
    }
?>
<br><h3>Por favor resuelva la siguiente encuesta</h3>
    
    <table border="0">
        <tr><th>Encuesta</th><td><?=$encuesta->getNombre()?></td></tr>
        <tr><th>Objetivo</th><td><?=$encuesta->getObjetivo()?></td></tr>
        <tr><th>Descripci&oacute;n</th><td><?=$encuesta->getDescripcion()?></td></tr>
    </table><br>

    <form name="formulario" method="post" action="principal.php?CONTENIDO=admon/gestioncalidad/encuestasActualizar.php">
    <?=$lista?>
    <input type="hidden" name="idProgramacionEncuesta" value="<?=$programacionEncuesta->getId()?>">
    <input type="hidden" name="usuario" value="<?=$USUARIO->getUsuario()?>">
    <input type="submit" name="accion" value="Enviar">
    </form>
<?php
}
?>

