<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Turno.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;
switch ($accion) {
    case 'Adicionar':
        $turno = new Turno(null, null);
        $turno->setCedulaPersona($cedula);
        $turno->setHoraInicio($HoraInicio);
        $turno->setHoraFin($HoraFin);
        $turno->setDia($dia);
        $turno->setDescripcion($descripcion);
        $turno->grabar();
        break;
    case 'Modificar':
        $turno = new Turno(null, null);
        $turno->setCedulaPersona($cedula);
        $turno->setCodigo($codigo);
        $turno->setHoraInicio($HoraInicio);
        $turno->setHoraFin($HoraFin);
        $turno->setDia($dia);
        $turno->setDescripcion($descripcion);
        $turno->modificar();
        break;
    case 'Eliminar':
        $turno = new Turno('codigo', $_GET['codigo']);
        $turno->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/turnos.php&cedula='.$cedula);

