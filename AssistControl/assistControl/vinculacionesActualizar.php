<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Vinculacion.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $vinculacion=new Vinculacion(null, null);
        $vinculacion->setNombre($nombre);
        $vinculacion->grabar();
        break;
    case 'Modificar':
        $vinculacion=new Vinculacion('codigo', $codigo);
        $vinculacion->setNombre($nombre);
        $vinculacion->modificar();
        break;
    case 'Eliminar':
        $vinculacion=new Vinculacion('codigo', $codigo);
        $vinculacion->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/vinculaciones.php');
?>