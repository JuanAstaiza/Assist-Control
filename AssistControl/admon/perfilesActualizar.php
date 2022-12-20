<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Perfil.php';
require_once 'assistControl/clases/Perfil_A.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
$ruta='admon/perfiles.php';
switch ($accion) {
    case 'Adicionar':
        $perfil=new Perfil(null, null);
        $perfil->setNombre($nombre);
        $perfil->setDescripcion($descripcion);
        $perfil->grabar();
        break;
    case 'Modificar':
        $perfil=new Perfil(null, null);
        $perfil->setId($id);
        $perfil->setNombre($nombre);
        $perfil->setDescripcion($descripcion);
        $perfil->modificar();
        break;
    case 'Eliminar':
        $perfil=new Perfil('id', $id);
        $perfil->eliminar();
        break;
    case 'Actualizar accesos':
        $ruta="admon/perfilesAccesos.php&idPerfil=$idPerfil";
        $perfil=new Perfil('id', $idPerfil);
        $opciones=array();
        foreach ($_POST as $Variable => $Valor){
            if (substr($Variable,0,8)=='idOpcion') $opciones[]= substr ($Variable, 9);
        }
        $perfil->actualizarAccesos($opciones);
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=$ruta");