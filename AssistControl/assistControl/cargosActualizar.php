<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Cargo.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
        $cargo = new Cargo(null, null);
        $cargo->setNombre($nombre);
        $cargo->setCodPerfil($codPerfil);
        $cargo->grabar();
        break;
    case 'Modificar':
        $cargo = new Cargo(null, null);
        $cargo->setCodigo($codigo);
        $cargo->setNombre($nombre);
        $cargo->setCodPerfil($codPerfil);
        $cargo->modificar();
        break;
    case 'Eliminar':
        $cargo = new Cargo('codigo', $_GET['codigo']);
        $cargo->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/cargos.php');
