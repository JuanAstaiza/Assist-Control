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
        $menu=new Menu(null, null);
        $menu->setNombre($nombre);
        $menu->setDescripcion($descripcion);
        $menu->setIdSI($idSI);
        $menu->grabar();
        break;
    case 'Modificar':
        $menu=new Menu(null, null);
        $menu->setId($id);
        $menu->setNombre($nombre);
        $menu->setDescripcion($descripcion);
        $menu->setIdSI($idSI);
        $menu->modificar();
        break;
    case 'Eliminar':
        $menu=new Menu('id', $id);
        $idSI=$menu->getIdSI();
        $menu->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/menu.php&idSI=$idSI");
