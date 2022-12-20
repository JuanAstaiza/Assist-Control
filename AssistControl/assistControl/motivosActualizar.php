<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Motivo.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $motivo=new Motivo(null, null);
        $motivo->setNombre($nombre);
        $motivo->grabar();
        break;
    case 'Modificar':
        $motivo=new Motivo(null, null);
        $motivo->setCodigo($codigo);
        $motivo->setNombre($nombre);
        $motivo->modificar();
        break;
    case 'Eliminar':
        $motivo=new Motivo('codigo', $codigo);
        $motivo->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/motivos.php');
?>