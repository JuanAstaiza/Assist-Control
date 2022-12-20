<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Informacion_del_Empleado_{$_GET['cedula']}.doc");
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
    
    function getListaCiudad($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codDepartamento from {$P}ciudad $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    
    function getListaDepartamento($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codPais from {$P}departamento $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaPais($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}pais $filtro;";
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
    
    function getListaAreaEnseñanza($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}areaEnsenanza $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaTipoVinculacion($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}tipoVinculacion $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
     function getListaSituacion($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}situacion $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function GrupoSanguineo($genero) {
        switch ($genero) {
            case '1': return 'A+'; break;
            case '2': return 'A-'; break;
            case '3': return 'B+'; break;
            case '4': return 'B-'; break;
            case '5': return 'AB+'; break;
            case '6': return 'AB-'; break;
            case '7': return 'O+'; break;
            case '8': return 'O-'; break;
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
    
    function Genero($genero){
        switch ($genero) {
            case '0': return 'Masculino'; break;
            case '1': return 'Femenino'; break;
            default: return 'Desconocido'; break;
        }
    }
 $lista='';   
    $filtropersona=  'cedula='.$_GET['cedula'];
    $detalles_persona = getListaPersona($filtropersona);
for ($i = 0; $i < count($detalles_persona); $i++) {
    $persona = $detalles_persona[$i];
        $lista.="<tr><th>Nombre Completo:</th><td>{$persona['primernombre']}"." "."{$persona['segundonombre']}"." ". "{$persona['primerapellido']}". " "."{$persona['segundoapellido']}</td></tr>";
        $lista.="<tr><th>C&eacute;dula Ciudania:</th><td>{$persona['cedula']}</td></tr>";
        $fechaexpedicion=date("d-m-Y",strtotime($persona['fechaexpedicion'])); 
        $lista.="<tr><th>Fecha de Expedici&oacute;n:</th><td>{$fechaexpedicion}</td></tr>";
        $lista.="<tr><th>Lugar de Expedici&oacute;n:</th><td>{$persona['lugarexpedicion']}</td></tr>";
        $fechanacimiento=date("d-m-Y",strtotime($persona['fechanacimiento'])); 
        $lista.="<tr><th>Fecha de Nacimiento:</th><td>{$fechanacimiento}</td></tr>";
        $gruposanguineo= GrupoSanguineo($persona['gruposanguineo']);
        $lista.="<tr><th>Grupo Sangu&iacute;neo: </th><td>{$gruposanguineo}</td></tr>";
        $genero=Genero($persona['genero']);
        $lista.="<tr><th>G&eacute;nero:</th><td>{$genero}</td></tr>";
        $filtrociudad=  'codigo='.$persona['codciudad'];
        $detallesciudad = getListaCiudad($filtrociudad);
        for ($i = 0; $i < count($detallesciudad); $i++) {
            $ciudad = $detallesciudad[$i];
            $filtrodepartamento='codigo='.$ciudad['coddepartamento'];
                $detallesDepartamento = getListaDepartamento($filtrodepartamento);
            for ($j = 0; $j < count($detallesDepartamento); $j++) {
                $departamento = $detallesDepartamento[$j];
                $filtropais='codigo='.$departamento['codpais'];
                $detallespais = getListaPais($filtropais);
                for ($k = 0; $k < count($detallespais); $k++) {
                    $pais = $detallespais[$k];
                    $lista.="<tr><th>Pa&iacute;s Nacimiento:</th><td>{$pais['nombre']}</td></tr>";
                    $lista.="<tr><th>Departamento Nacimiento: </th><td>{$departamento['nombre']}</td></tr>";
                    $lista.="<tr><th>Ciudad Nacimiento:</th><td>{$ciudad['nombre']}</td></tr>";
                }
            }        
        }   
        $lista.="<tr><th>Direcci&oacute;n de Residencia:</th><td>{$persona['direccionresidencia']}</td></tr>";
        $lista.="<tr><th>Tel&eacute;fono o Celular:</th><td>{$persona['telefono']}</td></tr>";
        $lista.="<tr><th>Email:</th><td>{$persona['email']}</td></tr>";
        $filtrocargo=  'codigo='.$persona['codcargo'];
    $detallescargo = getListaCargo($filtrocargo);
    for ($i = 0; $i < count($detallescargo); $i++) {
        $cargo = $detallescargo[$i];
        $filtroperfil='codigo='.$cargo['codperfil'];
        $detallesperfil = getListaPerfil($filtroperfil);
        for ($l = 0; $l < count($detallesperfil); $l++) {
                $perfil = $detallesperfil[$l];
                $lista.="<tr><th>Perfil:</th><td>{$perfil['nombre']}</td></tr>";
                $lista.="<tr><th>Cargo:</th><td>{$cargo['nombre']}</td></tr>";
       }
    }
 
    $filtrovinculacion=  'codigo='.$persona['codtipovinculacion'];
    $detallesvinculacion = getListaTipoVinculacion($filtrovinculacion);
    for ($i = 0; $i < count($detallesvinculacion); $i++) {
        $vinculacion = $detallesvinculacion[$i];
        $lista.="<tr><th>Tipo Vinculaci&oacute;n:</th><td>{$vinculacion['nombre']}</td></tr>";
    }
    $filtroenseñanza=  'codigo='.$persona['codareaensenanza'];
    $detallesenseñanaza = getListaAreaEnseñanza($filtroenseñanza);
    for ($i = 0; $i < count($detallesenseñanaza); $i++) {
        $enseñanza = $detallesenseñanaza[$i];
        $lista.="<tr><th>Area de Ense&ntilde;anza:</th><td>{$enseñanza['nombre']}</td></tr>";
    }
        $lista.="<tr><th>Profesi&oacute;n:</th><td>{$persona['profesion']}</td></tr>";
        $filtrosituacion=  'codigo='.$persona['codareaensenanza'];
    $detallessitacion = getListaSituacion($filtrosituacion);
    for ($i = 0; $i < count($detallessitacion); $i++) {
        $situacion = $detallessitacion[$i];
        $lista.="<tr><th>Situaci&oacute;n:</th><td>{$situacion['nombre']}</td></tr>";
    }
    $estado=Estado($persona['estado']);
    $lista.="<tr><th>Estado:</th><td>{$estado}</td></tr>";
    $fechaingreso=date("d-m-Y",strtotime($persona['fechaingreso'])); 
    $lista.="<tr><th>Fecha de Ingreso:</th><td>{$fechaingreso}</td></tr>";
    $fechasalida=date("d-m-Y",strtotime($persona['fechasalida'])); 
    $lista.="<tr><th>Fecha de Salida:</th><td>{$fechasalida}</td></tr>";
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
    <h3>DETALLES DEL EMPLEADO</h3>
    <br><br>
<table border="1">
     <?=$lista?>
</table>
</center>
</body>


