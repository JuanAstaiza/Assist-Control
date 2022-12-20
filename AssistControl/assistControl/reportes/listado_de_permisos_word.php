<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Listado_de_Permisos.doc");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../clases/Conector.php';
date_default_timezone_set('America/Bogota');

$OPCION=$_GET['opcion'];
if ($OPCION==4 || $OPCION==5) {
        if ($OPCION==4) {
            $fecha=$_GET['fecha'];
            if ($fecha!=null) {
                $filtro= "fechasolicitud='$fecha'";
            }else{
                $filtro=null;
            }
        }else{
            if ($OPCION==5) {
                $filtro=null;
            } 
        }
}else{
    $TEXTO=$_GET['texto'];
    if ($TEXTO!=null) { 
        if ($OPCION==1){
                $filtro= "cast(cedulapersona as varchar(999999)) like '$TEXTO%'";
            }else{
               if ($OPCION==2) {
                   $prefijo="lemo_persona.";
                    $palabras=str_word_count($TEXTO);
                   if ($palabras==1) {
                        $filtro= "{$prefijo}primerNombre like '$TEXTO%'";
                   }else{
                       if ($palabras==2) {  
                            list($p_nombre, $s_nombre) = explode(" ", $TEXTO);
                            $filtro= "{$prefijo}primerNombre like '$p_nombre%' and {$prefijo}segundoNombre like '$s_nombre%'";
                       }else{
                           $filtro=null;
                       }
                   }
                   
                }else{
                    if ($OPCION==3) {
                       $palabras=str_word_count($TEXTO);
                       $prefijo="lemo_persona.";
                        if ($palabras==1) {
                             $filtro= "{$prefijo}primerApellido like '$TEXTO%'";
                        }else{
                            if ($palabras==2) {  
                                list($p_apellido,$s_apellido) = explode(" ", $TEXTO);
                                $filtro= "{$prefijo}primerApellido like '$p_apellido%' and {$prefijo}segundoApellido like '$s_apellido%'";
                            }else{
                                if ($palabras>2) {
                                    $filtro=null;
                                }
                            }
                        }
                    }
            }
        }
    }else{
        $filtro=null;

    }
}   
    function getListaPersona($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
            . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
            . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona $filtro";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
        
    }

    function getListaPermisos($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "and $filtro";
        //$cadenaSQL = "select codigo, cedulaPersona, fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion, anexo from {$P}permiso $filtro;";
        $cadenaSQL = "select codigo, cedulapersona, {$P}persona.primernombre,{$P}persona.segundonombre,{$P}persona.primerapellido,{$P}persona.segundoapellido,fechasolicitud, fechainicio, fechafin, codmotivo, descripcion, anexo from {$P}permiso,{$P}persona where {$P}permiso.cedulapersona={$P}persona.cedula $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaMotivos($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}motivo $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
$lista = '';
$personas = getListaPermisos($filtro);
for ($i = 0; $i < count($personas); $i++) {
    $persona = $personas[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$persona['cedulapersona']}</td>";
    $lista.= "<td>{$persona['primernombre']} {$persona['segundonombre']}</td>";
    $lista.= "<td>{$persona['primerapellido']} {$persona['segundoapellido']}</td>";
    $fechasolicitud=date("d-m-Y",strtotime($persona['fechasolicitud'])); 
    $lista.= "<td>{$fechasolicitud}</td>";
    $fechainicio=date("d-m-Y",strtotime($persona['fechainicio'])); 
    $lista.= "<td>{$fechainicio}</td>";
    $fechafin=date("d-m-Y",strtotime($persona['fechafin'])); 
    $lista.= "<td>{$fechafin}</td>";
    $filtromotivo='codigo='.$persona['codmotivo'];
    $motivos = getListaMotivos($filtromotivo);
    for ($k = 0; $k < count($motivos); $k++) {
        $motivo = $motivos[$k];
         $lista.= "<td>{$motivo['nombre']}</td>";
    }   
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
    font-size: 90%;
    color: white;
    border-color: #121140;
}

td {
    border: 2.5px solid;
    padding-left: 10px;
    padding-right: 10px;
    font-family: Arial;
    font-size: 80%;
}
</style> 
</head>
<body>
<center>
<h3>LISTADO DE PERMISOS</h3><br><br>
<br>
    <table border="1">
    <tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Fecha Solicitud</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Motivo</th></tr>
    <?=$lista?>
</table>
</center>
</body>


