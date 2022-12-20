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
        $contrato=new Contrato(null, null);
        $contrato->setIdSI($idSI);
        $contrato->setIdEmpresa($idEmpresa);
        $contrato->setFechaInicio($fechaInicio);
        $contrato->setFechaFin($fechaFin);
        $contrato->setValor($valor);
        $contrato->grabar();
        break;
    case 'Modificar':
        $contrato=new Contrato(null, null);
        $contrato->setId($id);
        $contrato->setIdSI($idSI);
        $contrato->setIdEmpresa($idEmpresa);
        $contrato->setFechaInicio($fechaInicio);
        $contrato->setFechaFin($fechaFin);
        $contrato->setValor($valor);
        $contrato->modificar();
        break;
    case 'Eliminar':
        $contrato=new Contrato('id', $id);
        $contrato->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/contratos.php&idEmpresa={$contrato->getIdEmpresa()}");