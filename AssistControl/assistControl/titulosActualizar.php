<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Titulo.php';

foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
        $titulo = new Titulo(null, null);
        $titulo->setCedulaPersona($cedula);
        $titulo->setNombre($nombre);
        $titulo->setCodnivelEducativo($codNivelEducativo);
        $titulo->grabar();
        break;
    case 'Modificar':
        $titulo = new Titulo(null, null);
        $titulo->setCodigo($codigo);
        $titulo->setNombre($nombre);
        $titulo->setCodnivelEducativo($codNivelEducativo);
        $titulo->modificar();
        break;
    case 'Eliminar':
        $titulo = new Titulo('codigo', $_GET['codigo']);
        $titulo->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/titulos.php&cedula='.$cedula);

