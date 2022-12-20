<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/TipoPregunta.php';
require_once 'admon/clases/Pregunta.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $pregunta=new Pregunta(null, null);
        $pregunta->setEnunciado($enunciado);
        $pregunta->setTipo($tipo);
        $pregunta->grabar();
        break;
    case 'Modificar':
        $pregunta=new Pregunta(null, null);
        $pregunta->setId($id);
        $pregunta->setEnunciado($enunciado);
        $pregunta->setTipo($tipo);
        $pregunta->modificar();
        break;
    case 'Eliminar':
        $pregunta=new Pregunta('id', $id);
        $pregunta->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/gestioncalidad/bancoPreguntas.php");