<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Permiso_del_Empleado_{$_GET['cedula']}.doc");
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

    function getListaPermiso($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion, anexo from {$P}permiso $filtro";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaMotivo($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}motivo $filtro;";
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

    
        function Estado($estado){
        switch ($estado) {
            case '1': return 'Activo'; break;
            case '0': return 'Inactivo'; break;
            default: return 'Desconocido'; break;
        }
    }
   

$lista = '';
$filtro_permiso=  'codigo ='.$_GET['codigo'];
$pemisos = getListaPermiso($filtro_permiso);
for ($i = 0; $i < count($pemisos); $i++) {
    $permiso = $pemisos[$i];
    $lista.= '<tr>';
    $fechasolicitud=date("d-m-Y",strtotime($permiso['fechasolicitud'])); 
    $lista.= "<td>{$fechasolicitud}</td>";
    $fechainicio=date("d-m-Y",strtotime($permiso['fechainicio'])); 
    $lista.= "<td>{$fechainicio}</td>";
    $fechafin=date("d-m-Y",strtotime($permiso['fechafin'])); 
    $lista.= "<td>{$fechafin}</td>";
        $filtromotivo='codigo='.$permiso['codmotivo'];
     $motivos = getListaMotivo($filtromotivo);
    for ($u = 0; $u < count($motivos); $u++) {
        $motivo = $motivos[$u];
        $lista.= "<td>{$motivo['nombre']}</td>";
    }    
    $lista.= '</tr>';
    $listadescripcion="<td>{$permiso['descripcion']}</td>";

}
$listaempleado = '';
$listaturno = '';
$filtro_persona=  'cedula ='.$_GET['cedula'];
$empleado = getListaPersona($filtro_persona);
for ($i = 0; $i < count($empleado); $i++) {
    $persona = $empleado[$i];
    $listaempleado.= "<td>{$persona['cedula']}</td>";
    $listaempleado.= "<td>{$persona['primernombre']}" . " " ."{$persona['segundonombre']}</td>";
    $listaempleado.= "<td>{$persona['primerapellido']}" . " " ."{$persona['segundoapellido']}</td>";
    $filtrocargo=  'codigo='.$persona['codcargo'];
    $detallescargo = getListaCargo($filtrocargo);
    for ($j = 0; $j < count($detallescargo); $j++) {
        $cargo = $detallescargo[$j];
        $filtroperfil='codigo='.$cargo['codperfil'];
        $detallesperfil = getListaPerfil($filtroperfil);
        for ($k = 0; $k < count($detallesperfil); $k++) {
                $perfil = $detallesperfil[$k];
                $listaempleado.= "<td>{$perfil['nombre']}</td>";
                $listaempleado.= "<td>{$cargo['nombre']}</td>";
    }
        $estado=Estado($persona['estado']);
        $listaempleado.= "<td>{$estado}</td>";
        $listaempleado.= '</tr>';
    }
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
    <br/><br/>
        <h3>PERMISO DEL EMPLEADO</h3>
    <br><br><br>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table>
    <br><br><br>
    <table border="1">
        <tr><th>Fecha Solicitud</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Motivo</th></tr>
        <?=$lista?>
    </table>
    <br><br><br>
    <table border="0">
        <tr><th>Descripcion</th>
        <?=$listadescripcion?>
    </table>
</center>
</body>
