<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Ciudad_A.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
         $ciudad = new Ciudad_A(null, null);
        $ciudad->setNombre($nombre);
        $ciudad->setCodDepartamento($codDepartamento);
        $ciudad->grabar();
        break;
    case 'Modificar':
        $ciudad = new Ciudad_A('codigo', $codigo);
        $ciudad->setNombre($nombre);
        $ciudad->setCodDepartamento($codDepartamento);
        $ciudad->modificar($codigo);
        break;
    case 'Eliminar':
        $ciudad = new Ciudad_A('codigo', $codigo);
        $ciudad->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/ciudades.php');
