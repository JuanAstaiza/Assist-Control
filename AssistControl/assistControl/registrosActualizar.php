<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Registro.php';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;

switch ($accion) {
    case 'Adicionar':
        $registro = new Registro(null, null);
        $registro->setCedulaPersona($cedulaPersona);
        $registro->setFecha($fecha);
        $registro->setTipo($tipo);
        $registro->grabar();
        break;
    case 'Modificar':
        $registro = new Registro(null, null);
        $registro->setCodigo($codigo);
        $registro->setCedulaPersona($cedulaPersona);
        $registro->setFecha($fecha);
        $registro->setTipo($tipo);
        $registro->modificar();
        break;
    case 'Eliminar':
        $registro = new Registro('codigo', $codigo);
        $registro->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=assistControl/registros.php');