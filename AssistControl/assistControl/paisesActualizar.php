<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Pais_A.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $pais=new Pais_A(null, null);
        $pais->setCodigo($codigo);
        $pais->setNombre($nombre);
        $pais->grabar();
        break;
    case 'Modificar':
        $pais=new Pais_A('codigo', $codigoAnterior);
        $pais->setCodigo($codigo);
        $pais->setNombre($nombre);
        $pais->modificar($codigoAnterior);
        break;
    case 'Eliminar':
        $pais=new Pais_A('codigo', $codigo);
        $pais->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/paises.php');
?>