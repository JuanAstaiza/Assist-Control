<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/AreaEnsenanza.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $AreaEnsenanza=new AreaEnsenanza(null, null);
        $AreaEnsenanza->setNombre($nombre);
        $AreaEnsenanza->grabar();
        break;
    case 'Modificar':
        $AreaEnsenanza=new AreaEnsenanza('codigo', $codigo);
        $AreaEnsenanza->setNombre($nombre);
        $AreaEnsenanza->modificar();
        break;
    case 'Eliminar':
        $AreaEnsenanza=new AreaEnsenanza('codigo', $codigo);
        $AreaEnsenanza->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/areasEnsenanza.php');
?>