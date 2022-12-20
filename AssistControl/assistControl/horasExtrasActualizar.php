<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/HoraExtra.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
        $horaExtra = new HoraExtra(null, null);
        $horaExtra->setCedulaPersona($cedula);
        $horaExtra->setFechaInicio($FechaInicio);
        $horaExtra->setFechaFin($FechaFin);
        $horaExtra->setHoraInicio($HoraInicio);
        $horaExtra->setHoraFin($HoraFin);
        $horaExtra->setDescripcion($descripcion);
        $horaExtra->grabar();
        break;
    case 'Modificar':
        $horaExtra = new HoraExtra(null, null);
        $horaExtra->setCodigo($codigo);
        $horaExtra->setCedulaPersona($cedula);
        $horaExtra->setFechaInicio($FechaInicio);
        $horaExtra->setFechaFin($FechaFin);
        $horaExtra->setHoraInicio($HoraInicio);
        $horaExtra->setHoraFin($HoraFin);
        $horaExtra->setDescripcion($descripcion);
        $horaExtra->modificar();
        break;
    case 'Eliminar':
        $horaExtra = new HoraExtra('codigo', $_GET['codigo']);
        $horaExtra->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/horasExtras.php&cedula='.$cedula);
