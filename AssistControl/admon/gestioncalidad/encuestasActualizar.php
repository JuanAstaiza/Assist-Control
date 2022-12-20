<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Encuesta.php';

foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
$ruta="admon/gestioncalidad/encuestas.php";
switch ($accion) {
    case 'Adicionar':
        $encuesta=new Encuesta(null, null);
        $encuesta->setNombre($nombre);
        $encuesta->setObjetivo($objetivo);
        $encuesta->setDescripcion($descripcion);
        $encuesta->grabar();
        break;
    case 'Modificar':
        $encuesta=new Encuesta(null, null);
        $encuesta->setId($id);
        $encuesta->setNombre($nombre);
        $encuesta->setObjetivo($objetivo);
        $encuesta->setDescripcion($descripcion);
        $encuesta->modificar();
        break;
    case 'Eliminar':
        $encuesta=new Encuesta('id', $id);
        $encuesta->eliminar();
        break;
    case 'Actualizar preguntas':
        $ruta="admon/gestioncalidad/preguntasEncuestas.php&idEncuesta=$idEncuesta";
        $encuesta=new Encuesta('id', $idEncuesta);
        $preguntas=array();
        foreach ($_POST as $Variable => $Valor){
            if (substr($Variable,0,10)=='idPregunta') $preguntas[]= substr ($Variable, 11);
        }
        $encuesta->actualizarPreguntas($preguntas);
        break;
    case 'Enviar': //almacenar resultados de encuestas        
        require_once 'admon/clases/ProgramacionEncuesta.php';
        $programacionEncuesta=new ProgramacionEncuesta('id', $idProgramacionEncuesta);
        $respuestas=array();
        foreach ($_POST as $Variable => $Valor){
            if (substr($Variable,0,3)=='rta') $respuestas[substr ($Variable, 3)]= $Valor;
        }
        $programacionEncuesta->responder($usuario,$respuestas);
        echo '<h3>GRACIAS POR CONTESTAR NUESTRA ENCUESTA</h3>';
        die;
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=$ruta");