<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Departamento_A.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
        $departamento = new Departamento_A(null, null);
        $departamento->setNombre($nombre);
        $departamento->setCodPais($codPais);
        $departamento->grabar();
        break;
    case 'Modificar':
        $departamento = new Departamento_A(null, null);
        $departamento->setCodigo($codigo);
        $departamento->setNombre($nombre);
        $departamento->setCodPais($codPais);
        $departamento->modificar();
        break;
    case 'Eliminar':
        $departamento = new Departamento_A('codigo', $_GET['codigo']);
        $departamento->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/departamentos.php');
