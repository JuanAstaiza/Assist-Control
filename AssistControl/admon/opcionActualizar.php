<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $opcion=new Opcion(null, null);
        $opcion->setNombre($nombre);
        $opcion->setDescripcion($descripcion);
        $opcion->setRuta($ruta);
        $opcion->setIdSI($idSI);
        $opcion->setIdMenu($idMenu);
        $opcion->grabar();
        break;
    case 'Modificar':
        $opcion=new Opcion(null, null);
        $opcion->setId($id);
        $opcion->setNombre($nombre);
        $opcion->setDescripcion($descripcion);
        $opcion->setRuta($ruta);
        $opcion->setIdSI($idSI);
        $opcion->setIdMenu($idMenu);
        $opcion->modificar();
        break;
    case 'Eliminar':
        $opcion=new Opcion('id', $id);
        $idSI=$opcion->getIdSI();
        $opcion->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/menu.php&idSI=$idSI");
