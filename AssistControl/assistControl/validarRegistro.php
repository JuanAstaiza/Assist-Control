<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'clases/PersonaRegistroDiario.php';
require_once 'clases/Registro_RegistroDiario.php';
date_default_timezone_set('America/Bogota');
$BD='assistcontrol';
$P='lemo_';
foreach ($_POST as $Variable => $Valor) ${$Variable} = $Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable} = $Valor;

//PARA SABER LA FECHA DE AYER
$date = date( "Y-m-d" );
$ayer = date( "Y-m-d", strtotime( "-1 day", strtotime( $date ) ) );
//FIN

$persona = new PersonaRegistroDiario('cedula', $cedulaPersona);
$selectCount_hoy = "select count(codigo) as contador from {$P}registro where cedulaPersona = $cedulaPersona and fecha between '".date('Y-m-d')." 00:00:00' and '".date('Y-m-d')." 23:59:59'";
$contador_hoy = Conector::ejecutarQuery($selectCount_hoy, $BD)[0]['contador'];
$cadenaSQL = "select max(codigo) as codigo from {$P}registro where cedulaPersona = $cedulaPersona;";
$codigoAnterior = Conector::ejecutarQuery($cadenaSQL, $BD)[0]['codigo'];


if ($persona->getCedula()!=null) {
    $filtro = new Registro_RegistroDiario('codigo', $codigoAnterior);
    $registro = new Registro_RegistroDiario(null, null);
    $registro->setCedulaPersona($cedulaPersona);
    $registro->setFecha(date('Y-m-d H:i:s'));
        if ($contador_hoy==0) {
            $registro->setTipo('true');
            $mensaje = 'Entrada. Registrada con Exito.';
        }else{
            if ($contador_hoy==1) {
                $registro->setTipo('false');
                $mensaje = 'Salida. Registrada con Exito.';
            }else{
                    if ($contador_hoy==2) {
                        $registro->setTipo('');
                        $advertencia = 'Registro no Permitido.<br>Ya ha registrado Entrada y Salida.';
                    }
                }
            }
    $registro->grabar();
    }   

    $cadenaSQL_personaregistrada = "select max(codigo) as codigo from {$P}registro where cedulaPersona = $cedulaPersona;";
    $codigo = Conector::ejecutarQuery($cadenaSQL_personaregistrada, $BD)[0]['codigo'];
     


if ($codigo==null) {
    $advertencia="CEDULA no registrada.";
}

header("Location: registroDiario.php?codigo={$codigo}&mensaje={$mensaje}&advertencia={$advertencia}");
