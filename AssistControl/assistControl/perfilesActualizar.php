<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Perfil_A.php';
require_once 'admon/clases/Perfil.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $perfil_AC=new Perfil_A(null, null);
        $perfil_AC->setNombre($nombre);
        $perfil_AC->setDescripcion($descripcion);
        $perfil_AC->grabar();
        $perfil_AC->procesarEnAdminsys('Adicionar');
        break;
    case 'Modificar':
        $perfil_AC=new Perfil_A(null, null);
        $perfil_AC->setCodigo($codigo);
        $perfil_AC->setNombre($nombre);
        $perfil_AC->setDescripcion($descripcion);
        $perfil_AC->modificar();
        $perfil_AC->procesarEnAdminsys('Modificar');
        break;
    case 'Eliminar':
        $perfil_AC=new Perfil_A('codigo', $codigo);
        $perfil_AC->eliminar();
        $perfil_AC->procesarEnAdminsys('Eliminar');
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/perfiles.php');
?>
