<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=HoraExtras_del_Empleado_{$_GET['cedula']}.xls");
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

    function getListaHorasExtras($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fechaInicio, fechaFin, horaInicio, horaFin,descripcion from {$P}horaextra $filtro;";
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
     function Turnos($turno){
        switch ($turno) {
            case '1': return 'Lunes'; break;
            case '2': return 'Martes'; break;
            case '3': return 'Miercoles'; break;
            case '4': return 'Jueves'; break;
            case '5': return 'Viernes'; break;
            case '6': return 'Sabado'; break;
            case '7': return 'Domingo'; break;
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

$lista = '';
$contador=0;
$total="";
$filtro_turno=  'cedulaPersona ='.$_GET['cedula'];
$horaextras = getListaHorasExtras($filtro_turno);
for ($i = 0; $i < count($horaextras); $i++) {
    $horaextra = $horaextras[$i];
        
    $HoraInicio=$horaextra['horainicio'];
    $HoraFin=$horaextra['horafin'];
    
    
    //SACAR EL SUBTOTAL  ENTRE HORA INICIO Y HORA FIN    
        $horai=substr($HoraInicio,0,2);
	$mini=substr($HoraInicio,3,2);
	$segi=substr($HoraInicio,6,2);
 
	$horaf=substr($HoraFin,0,2);
	$minf=substr($HoraFin,3,2);
	$segf=substr($HoraFin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini;
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
        
	$subtotal= date("H:i:s",mktime($difh,$difm,$difs));  
     //_______________________________________________________________________________________   
    $lista.= '<tr>';
    $fechainicio=date("d-m-Y",strtotime($horaextra['fechainicio'])); 
    $lista.= "<td>{$fechainicio}</td>";
    $fechafin=date("d-m-Y",strtotime($horaextra['fechafin'])); 
    $lista.= "<td>{$fechafin}</td>";
    $lista.= "<td>{$horaextra['horainicio']}</td>";
    $lista.= "<td>{$horaextra['horafin']}</td>";
    $lista.= "<td>{$horaextra['descripcion']}</td>";
    $lista.= "<td>{$subtotal}</td>";
    $lista.= '</tr>';
    //_________________________________________________________________________________
        //TOTAL SUMA DE TODOS LOS SUBTOTALES
        $horai=substr($subtotal,0,2);
	$mini=substr($subtotal,3,2);
	$segi=substr($subtotal,6,2);
        
	$ini=((($horai*60)*60)+($mini*60)+$segi);
 
	$contador=$contador+$ini;
	$difh=floor($contador/3600);
	$difm=floor(($contador-($difh*3600))/60);
	$difs=$contador-($difm*60)-($difh*3600);
	$total= date("H:i:s",mktime($difh,$difm,$difs));    

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
        <h3>LISTADO DE HORAS EXTRAS</h3>
      <br><br><br>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table>
    <br><br><br>
    <table border="1">
        <tr><th>Fecha Inicio</th><th>Fecha Fin</th><th>Hora Inicio</th><th>Hora Fin</th><th>Descripci&oacute;n</th><th>Subtotal</th>
        <?=$lista?>
        <tr><th colspan="5">Total:</th><td><?=$total?></td></tr>
    </table>
    <br><br>
</center>
</center>
</body>