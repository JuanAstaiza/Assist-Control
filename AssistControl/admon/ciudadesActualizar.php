<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Ciudad.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
        $ciudad = new Ciudad(null, null);
        $ciudad->setCodigo($codigo);
        $ciudad->setNombre($nombre);
        $ciudad->setCodDepartamento($codDepartamento);
        $ciudad->grabar();
        break;
    case 'Modificar':
        $ciudad = new Ciudad('codigo', $codigoAnterior);
        $ciudad->setCodigo($codigo);
        $ciudad->setNombre($nombre);
        $ciudad->setCodDepartamento($codDepartamento);
        $ciudad->modificar($codigoAnterior);
        break;
    case 'Eliminar':
        $ciudad = new Ciudad('codigo', $_GET['codigo']);
        $ciudad->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=admon/ciudades.php');
