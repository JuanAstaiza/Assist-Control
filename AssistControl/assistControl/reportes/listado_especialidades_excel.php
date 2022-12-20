<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Especialidades_del_Empleado_{$_GET['cedula']}.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../clases/Conector.php';
date_default_timezone_set('America/Bogota');



    function getListaPersona($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
            . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
            . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona $filtro";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    function getListaTitulo($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, nombre, codnivelEducativo from {$P}titulo $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaCargo($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codPerfil from {$P}cargo $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    } 
    
    function getListaPerfil($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, descripcion from {$P}perfil $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    function Titulo($titulo) {
        switch ($titulo) {
            case '1': return 'Bachiller'; break;
            case '2': return 'Tecnico'; break;
            case '3': return 'Tecnologo'; break;
            case '4': return 'Profesional'; break;
            case '5': return 'Postgrado'; break;
            case '6': return 'Licenciado'; break;
            case '7': return 'Especialista'; break;
            case '8': return 'Magister'; break;
            case '9': return 'Decano'; break;
            default: return 'Desconocido'; break;
        }
    }
    
        function Estado($estado){
        switch ($estado) {
            case '1': return 'Activo'; break;
            case '0': return 'Inactivo'; break;
            default: return 'Desconocido'; break;
        }
    }
$listaempleado = '';
$filtro_persona=  'cedula ='.$_GET['cedula'];
$empleado = getListaPersona($filtro_persona);
for ($i = 0; $i < count($empleado); $i++) {
    $persona = $empleado[$i];
    $listaempleado.= '<tr>';
    $listaempleado.= "<td>{$persona['cedula']}</td>";
    $listaempleado.= "<td>{$persona['primernombre']} {$persona['segundonombre']}</td>";
    $listaempleado.= "<td>{$persona['primerapellido']} {$persona['segundoapellido']}</td>";
    $filtrocargo=  'codigo='.$persona['codcargo'];
    $detallescargo = getListaCargo($filtrocargo);
    for ($u = 0; $u < count($detallescargo); $u++) {
        $cargo = $detallescargo[$u];
        $filtroperfil='codigo='.$cargo['codperfil'];
        $detallesperfil = getListaPerfil($filtroperfil);
        for ($j = 0; $j < count($detallesperfil); $j++) {
            $perfil = $detallesperfil[$j];
            $listaempleado.= "<td>{$perfil['nombre']}</td>";
            $listaempleado.= "<td>{$cargo['nombre']}</td>";
             
    }
        $estado=Estado($persona['estado']);
        $listaempleado.= "<td>{$estado}</td>";
        $listaempleado.= '</tr>';
}
}
$lista = '';
$filtro_turno='cedulaPersona ='.$_GET['cedula'];
$titulos = getListaTitulo($filtro_turno);
for ($i = 0; $i < count($titulos); $i++) {
    $titulo = $titulos[$i];
    $lista.= '<tr>';
    $niveleducativo=Titulo($titulo['codniveleducativo']);
    $lista.= "<td>{$niveleducativo}</td>";
    $lista.= "<td>{$titulo['nombre']}</td>";
    $lista.= '</tr>';
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css"> 
body{
    justify-content: center;
    font-family: Arial;
}
    
#border{
    padding-left: 1px;
}
table {
    border-collapse: collapse;
    border-color: black;
}
th {
    background: #151445;
    border: 4px solid;
    padding-left: 10px;
    padding-right: 10px;
    font-family: Arial;
    font-size: 80%;
    color: white;
    border-color: #121140;
}

td {
    border: 2.5px solid;
    padding-left: 10px;
    padding-right: 10px;
    font-family: Arial;
    font-size: 90%;
}
</style> 
</head>
<body>
<center>
        <h3>LISTA DE ESPECIALIDADES</h3>
     <br/><br/>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table>
    <br><br><br>
    <table border="0">
        <tr><th>Tipo del T&iacute;tulo</th><th>Nombre del T&iacute;tulo</th>
        <?=$lista?>
    </table>
</center>
</center>
</body>