<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Pais.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $pais=new Pais(null, null);
        $pais->setCodigo($codigo);
        $pais->setNombre($nombre);
        $pais->grabar();
        break;
    case 'Modificar':
        $pais=new Pais('codigo', $codigoAnterior);
        $pais->setCodigo($codigo);
        $pais->setNombre($nombre);
        $pais->modificar($codigoAnterior);
        break;
    case 'Eliminar':
        $pais=new Pais('codigo', $codigo);
        $pais->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=admon/paises.php');