<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Encuesta.php';
require_once 'admon/clases/Perfil.php';
require_once 'admon/clases/ProgramacionEncuesta.php';

foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $programacionEncuesta=new ProgramacionEncuesta(null, null);
        $programacionEncuesta->setIdPerfil($idPerfil);
        $programacionEncuesta->setIdEncuesta($idEncuesta);
        $programacionEncuesta->setFechaInicio($fechaInicio);
        $programacionEncuesta->setFechaFin($fechaFin);
        $programacionEncuesta->grabar();
        break;
    case 'Modificar':
        $programacionEncuesta=new ProgramacionEncuesta(null, null);
        $programacionEncuesta->setId($id);
        $programacionEncuesta->setIdPerfil($idPerfil);
        $programacionEncuesta->setIdEncuesta($idEncuesta);
        $programacionEncuesta->setFechaInicio($fechaInicio);
        $programacionEncuesta->setFechaFin($fechaFin);
        $programacionEncuesta->modificar();
        break;
    case 'Eliminar':
        $programacionEncuesta=new ProgramacionEncuesta('id', $id);
        $programacionEncuesta->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/gestioncalidad/programacionEncuestas.php&idEncuesta={$programacionEncuesta->getIdEncuesta()}");