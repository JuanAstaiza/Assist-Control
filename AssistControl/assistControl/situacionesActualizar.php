<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Situacion.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $situacion=new Situacion(null, null);
        $situacion->setNombre($nombre);
        $situacion->grabar();
        break;
    case 'Modificar':
        $situacion=new Situacion('codigo', $codigo);
        $situacion->setNombre($nombre);
        $situacion->modificar($codigo);
        break;
    case 'Eliminar':
        $situacion=new Situacion('codigo', $codigo);
        $situacion->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/situaciones.php');
