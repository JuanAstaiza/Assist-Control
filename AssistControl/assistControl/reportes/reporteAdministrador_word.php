<?php

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=ReporteAdministrador.doc");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../clases/Conector.php';
date_default_timezone_set('America/Bogota');

function restaHoras($horaIni, $horaFin){ 
return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
 
}

function getListaPersona($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
            . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
            . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona $filtro";
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
    
    function getListaTurno($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, horaInicio, horaFin, dia, descripcion from {$P}turno $filtro order by dia;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function Estado($estado){
        switch ($estado) {
            case '1': return 'Activo'; break;
            case '0': return 'Inactivo'; break;
            default: return 'Desconocido'; break;
        }
    }
    
    function getListaPermiso($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion, anexo from {$P}permiso $filtro";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaReporte($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fecha, tipo from {$P}registro,{$P}persona $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
   
    function getTipoEnLetras($tipo) {
        if ($tipo==true) return 'Entrada';
        else return 'Salida';
    }
    
    
$listadopermisos='';
$fechabusqueda='';
$filtro='';
$lista = '';
$listaprincipal='';
$listaretardos='';
$listafaltas='';
$datos='';
$listaempleado = '';
$titulo_reporte='';
$titulo_informacion='';
$listaperfil='';
$listacargos = '';
$registros='';
   
    $informacion= $_GET['informacion'];
    if ($informacion==1) {
        $titulo_informacion='<b>Tipo de Informaci&oacute;n:</b> Asistencia';
        $forma_reporte=$_GET['forma_reporte'];
        $fechaInicio=date("d-m-Y",strtotime($_GET['fechainicio']));
        $fechaFin=date("d-m-Y",strtotime($_GET['fechafin']));
        $fechabusqueda="<b>Desde:</b> $fechaInicio <b>Hasta:</b> $fechaFin";
        if ($_GET['cedula']!=null) {
           $cedula=$_GET['cedula'];
           $filtro_persona=  'cedula ='.$cedula;
         $empleado = getListaPersona($filtro_persona);
        for ($i = 0; $i < count($empleado); $i++) {
            $objeto = $empleado[$i];
            $listaempleado.='<tr><th>C&eacute;dula</th><th>Nombres</th><th>Apellidos</th><th>Estado</th></tr>';
            $listaempleado.= '<tr>';
            $listaempleado.= "<td>{$objeto['cedula']}</td>";
            $listaempleado.= "<td>{$objeto['primernombre']}  {$objeto['segundonombre']}</td>";
            $listaempleado.= "<td>{$objeto['primerapellido']}  {$objeto['segundoapellido']}</td>";
            $estado=Estado($objeto['estado']);
            $listaempleado.= "<td>{$estado}</td>";
            $listaempleado.= '</tr>';
        } 
        } else {
           $cedula=''; 
        }
        if ($_GET['codCargo']!=null || $_GET['codPerfil']!=null) {
            $codcargo=$_GET['codCargo'];
            $codperfil=$_GET['codPerfil'];
            $filtroperfil='codigo='.$codperfil;
            $perfiles= getListaPerfil($filtroperfil);
            for ($i = 0; $i < count($perfiles); $i++) {
                $perfil=$perfiles[$i];
                $listaperfil.='<tr>';
                $listaperfil.='<th>Perfil:</th>';
                $listaperfil.="<td>{$perfil['nombre']}</td>";    
                $listaperfil.='</tr>';
            }
            $filtrocargo='codigo='.$codcargo;
            $cargos = getListaCargo($filtrocargo);
            for ($i = 0; $i < count($cargos); $i++) {
                $cargo = $cargos[$i];
                $listacargos.='<tr>';
                $listacargos.='<th>Cargo:</th>';
                $listacargos.="<td>{$cargo['nombre']}</td>";
                $listacargos.='</tr>';
            }
        }else{
           $codcargo='';
           $codperfil='';
        }
        if ($forma_reporte==1) {
            $titulo_reporte='REPORTE INDIVIDUAL';
            $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  cedulaPersona=$cedula";
        }else{
            if ($forma_reporte==2) {
                $titulo_reporte='REPORTE GENERAL';
                $filtro="lemo_registro.cedulapersona=lemo_persona.cedula  and fecha between '$fechaInicio' and '$fechaFin' and  codcargo=$codcargo";
            }
        }
    
        $registros= getListaReporte($filtro);
        for ($i = 0; $i < count($registros); $i++) {
            $registro = $registros[$i];
            $listaprincipal="<tr><th>C&Eacute;DULA</th><th>NOMBRES</th><th>FECHA</th><th>HORA<br> ASIGNADA</th><th>HORA<br> REGISTRADA</th><th>Detalle</th><th>TIPO (ENTRADA/SALIDA)</th></tr>";
            $lista.='<tr>';
            $lista.="<td>{$registro['cedulapersona']}</td>";
            $filtro_persona=  'cedula ='.$registro['cedulapersona'];
            $empleado = getListaPersona($filtro_persona);
            for ($k = 0; $k < count($empleado); $k++) {
            $objeto = $empleado[$k];
            $lista.="<td>{$objeto['primernombre']} {$objeto['primerapellido']}</td>";
            }
            $fecharegistro= substr($registro['fecha'], 0, 10);
            $fecharegistro_f=date("d-m-Y",strtotime($fecharegistro));
            $lista.= "<td>{$fecharegistro_f}</td>";
            $fecharegistroformateada=strtotime($fecharegistro);
            $diaregistro= date('w', $fecharegistroformateada);
            $filtroturno='cedulapersona='.$registro['cedulapersona'].' and dia='.$diaregistro;
            $turnos= getListaTurno($filtroturno);
            for ($j = 0; $j < count($turnos); $j++) {
                $turno = $turnos[$j];
                //true=entrada
                if ($registro['tipo']==true) {
                    $horainicio=$turno['horainicio'];
                    $lista.="<td>{$horainicio}</td>";
                    $horainicioR= substr($registro['fecha'], 10);
                    $lista.="<td>{$horainicioR}</td>";
                    if (strtotime($horainicio)==strtotime($horainicioR) || strtotime($horainicio)>strtotime($horainicioR)) {
                        $lista.="<td><font color='blue'><b>Puntual</b></font></td>";       
                    }else{
                        if (strtotime($horainicio)<strtotime($horainicioR)) {
                            $demora=restaHoras($horainicio, $horainicioR);
                               $lista.="<td><font color='red'><b>{$demora}</b></font></td>";

                        }
                    }
                    $tipoenletras=getTipoEnLetras($registro['tipo']);
                    $lista.="<td>{$tipoenletras}</td>";
                }else{
                    //false=salida
                    if($registro['tipo']==false){
                        $horaFin=$turno['horafin'];
                        $lista.="<td>{$horaFin}</td>";
                        $horasalidaR= substr($registro['fecha'], 10);
                        $lista.="<td>{$horasalidaR}</td>";
                    if (strtotime($horaFin)==strtotime($horasalidaR) || strtotime($horaFin)<strtotime($horasalidaR)) {
                        $lista.="<td><font color='blue'><b>Horario Cumplido</b></font></td>";       
                    }else{
                        if (strtotime($horaFin)>strtotime($horasalidaR)) {
                            $demora=restaHoras($horasalidaR, $horaFin);
                           $lista.="<td><font color='red'><b>{$demora}</b></font></td>";

                        }
                    }
                    }
                    $tipoenletras=getTipoEnLetras($registro['tipo']);
                    $lista.="<td>{$tipoenletras}</td>";

                }
            }    
            $lista.='</tr>';
        }  
    }else{
        //informacion 1=Asistencia 2=Retardos 3=Faltas
        //reporte 1=Individual 2=General
        if ($informacion==2) {
                $titulo_informacion='<b>Tipo de Informaci&oacute;n:</b> Retardos';
                $forma_reporte=$_GET['forma_reporte'];
                $fechaInicio=date("d-m-Y",strtotime($_GET['fechainicio']));
                $fechaFin=date("d-m-Y",strtotime($_GET['fechafin']));
                $fechabusqueda="<b>Desde:</b> $fechaInicio <b>Hasta:</b> $fechaFin";
                if ($_GET['cedula']!=null) {
                   $cedula=$_GET['cedula'];
                   $filtro_persona=  'cedula ='.$cedula;
                 $empleado = getListaPersona($filtro_persona);
                for ($i = 0; $i < count($empleado); $i++) {
                    $objeto = $empleado[$i];
                    $listaempleado.= '<tr><th>C&eacute;dula</th><th>Nombres</th><th>Apellidos</th><th>Estado</th></tr>';
                    $listaempleado.= '<tr>';
                    $listaempleado.= "<td>{$objeto['cedula']}</td>";
                    $listaempleado.= "<td>{$objeto['primernombre']}  {$objeto['segundonombre']}</td>";
                    $listaempleado.= "<td>{$objeto['primerapellido']}  {$objeto['segundoapellido']}</td>";
                    $estado=Estado($objeto['estado']);
                    $listaempleado.= "<td>{$estado}</td></tr>";
                } 
                } else {
                   $cedula=''; 
                }
                if ($_GET['codCargo']!=null || $_GET['codPerfil']!=null) {
                    $codcargo=$_GET['codCargo'];
                    $codperfil=$_GET['codPerfil'];
                    $filtroperfil='codigo='.$codperfil;
                    $perfiles= getListaPerfil($filtroperfil);
                    for ($i = 0; $i < count($perfiles); $i++) {
                        $perfil=$perfiles[$i];
                        $listaperfil.='<tr>';
                        $listaperfil.='<th>Perfil:</th>';
                        $listaperfil.="<td>{$perfil['nombre']}</td>";    
                        $listaperfil.='</tr>';
                    }
                    $filtrocargo='codigo='.$codcargo;
                    $cargos = getListaCargo($filtrocargo);
                    for ($i = 0; $i < count($cargos); $i++) {
                        $cargo = $cargos[$i];
                        $listacargos.='<tr>';
                        $listacargos.='<th>Cargo:</th>';
                        $listacargos.="<td>{$cargo['nombre']}</td>";
                        $listacargos.='</tr>';
                    }
                }else{
                   $codcargo='';
                   $codperfil='';
                }
                if ($forma_reporte==1) {
                    $titulo_reporte='REPORTE INDIVIDUAL';
                    $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  cedulaPersona=$cedula";
                }else{
                    if ($forma_reporte==2) {
                        $titulo_reporte='REPORTE GENERAL';
                        $filtro="lemo_registro.cedulapersona=lemo_persona.cedula  and fecha between '$fechaInicio' and '$fechaFin' and  codcargo=$codcargo";
                    }
                }
                
            $contador=0;
            $contador2=0;
            $registros= getListaReporte($filtro);
            for ($i = 0; $i < count($registros); $i++) {
                $registro = $registros[$i];
                $listaprincipal="<tr><th>C&Eacute;DULA</th><th>NOMBRES</th><th>FECHA</th><th>HORA<br> ASIGNADA</th><th>HORA<br> REGISTRADA</th><th>Detalle</th><th>TIPO (ENTRADA/SALIDA)</th></tr>";
                $fecharegistro= substr($registro['fecha'], 0, 10);
                $fecharegistro_f2=date("d-m-Y",strtotime($registro['fecha']));
                $fecharegistroformateada=strtotime($fecharegistro);
                $diaregistro= date('w', $fecharegistroformateada);
                $filtroturno='cedulapersona='.$registro['cedulapersona'].' and dia='.$diaregistro;
                $turnos= getListaTurno($filtroturno);
                for ($j = 0; $j < count($turnos); $j++) {
                    $turno = $turnos[$j];
                    //true=entrada
                    $horainicioR= substr($registro['fecha'], 10);
                    $horainicio=$turno['horainicio'];
                    if ($registro['tipo']==true) {                        
                        if (strtotime($horainicio)==strtotime($horainicioR) || strtotime($horainicio)>strtotime($horainicioR)) {
                            //NO HACER NADA
                        }else{
                            if (strtotime($horainicio)<strtotime($horainicioR)) {
                                $contador=$contador+1;
                                $lista.='<tr>';
                                $lista.="<td>{$registro['cedulapersona']}</td>";
                                $filtro_persona=  'cedula ='.$registro['cedulapersona'];
                                $empleado = getListaPersona($filtro_persona);
                                for ($k = 0; $k < count($empleado); $k++) {
                                $objeto = $empleado[$k];
                                    $lista.="<td>{$objeto['primernombre']} {$objeto['primerapellido']}</td>";
                                }
                                $lista.= "<td>{$fecharegistro_f2}</td>";
                                $horainicioR= substr($registro['fecha'], 10);
                                $horainicio=$turno['horainicio'];
                                $lista.="<td>{$horainicio}</td>";
                                $lista.="<td>{$horainicioR}</td>";
                                $demora=restaHoras($horainicio, $horainicioR);
                                $lista.="<td><font color='red'><b>{$demora}</b></font></td>";
                                $tipoenletras=getTipoEnLetras($registro['tipo']);
                                $lista.="<td>{$tipoenletras}</td></tr>";
                            }
                        }
                    }else{
                            //false=salida
                        if($registro['tipo']==false){
                        $horaFin=$turno['horafin'];
                        $horasalidaR= substr($registro['fecha'], 10);
                        if (strtotime($horaFin)==strtotime($horasalidaR) || strtotime($horaFin)<strtotime($horasalidaR)) {
                            //NO HACER NADA
                        }else{
                            if (strtotime($horaFin)>strtotime($horasalidaR)) {
                                $contador2=$contador2+1;
                                $lista.='<tr>';
                                $lista.="<td>{$registro['cedulapersona']}</td>";
                                $filtro_persona=  'cedula ='.$registro['cedulapersona'];
                                $empleado = getListaPersona($filtro_persona);
                                for ($k = 0; $k < count($empleado); $k++) {
                                $objeto = $empleado[$k];
                                    $lista.="<td>{$objeto['primernombre']} {$objeto['primerapellido']}</td>";
                                }
                                $lista.= "<td>{$fecharegistro_f2}</td>";
                                $horaFin=$turno['horafin'];
                                $horasalidaR= substr($registro['fecha'], 10);
                                $lista.="<td>{$horaFin}</td>";
                                $lista.="<td>{$horasalidaR}</td>";
                                $demora=restaHoras($horasalidaR, $horaFin);
                                $lista.="<td><font color='red'><b>{$demora}</b></font></td>";
                                $tipoenletras=getTipoEnLetras($registro['tipo']);
                                $lista.="<td>{$tipoenletras}</td></tr>";
                            }
                        }
                        }
                    }
                }    
                $lista.='</tr>';
            }
            $contadortotal=$contador+$contador2;
            $listaretardos.='<table>';
            $listaretardos.='<tr><th>Numero de Retardos</th></tr>';
            $listaretardos.="<tr><td>$contadortotal</td></tr>";
            $listaretardos.="</table>";
        }else{
           //informacion 1=Asistencia 2=Retardos 3=Faltas
            //reporte 1=Individual 2=General
            if ($informacion==3) {            
                $titulo_reporte='REPORTE INDIVIDUAL';
                $forma_reporte='';
                $titulo_informacion='<b>Tipo de Informaci&oacute;n:</b> Ausencias';
                $fechaInicio=date("d-m-Y",strtotime($_GET['fechainicio']));
                $fechaFin=date("d-m-Y",strtotime($_GET['fechafin']));
                $fechabusqueda="<b>Desde:</b> $fechaInicio <b>Hasta:</b> $fechaFin";
                if ($_GET['cedula']!=null) {
                   $cedula=$_GET['cedula'];
                   $filtro_persona=  'cedula ='.$cedula;
                 $empleado = getListaPersona($filtro_persona);
                for ($i = 0; $i < count($empleado); $i++) {
                    $objeto = $empleado[$i];
                    $listaempleado.='<tr><th>C&eacute;dula</th><th>Nombres</th><th>Apellidos</th><th>Estado</th></tr>';
                    $listaempleado.= '<tr>';
                    $listaempleado.= "<td>{$objeto['cedula']}</td>";
                    $listaempleado.= "<td>{$objeto['primernombre']}  {$objeto['segundonombre']}</td>";
                    $listaempleado.= "<td>{$objeto['primerapellido']}  {$objeto['segundoapellido']}</td>";
                    $estado=Estado($objeto['estado']);
                    $listaempleado.= "<td>{$estado}</td>";
                    $listaempleado.= '</tr>';
                } 
                } else {
                   $cedula=''; 
                }
                if ($_GET['codCargo']!=null || $_GET['codPerfil']!=null) {
                    $codcargo=$_GET['codCargo'];
                    $codperfil=$_GET['codPerfil'];
                    $filtroperfil='codigo='.$codperfil;
                    $perfiles= getListaPerfil($filtroperfil);
                    for ($i = 0; $i < count($perfiles); $i++) {
                        $perfil=$perfiles[$i];
                        $listaperfil.='<tr>';
                        $listaperfil.='<th>Perfil:</th>';
                        $listaperfil.="<td>{$perfil['nombre']}</td>";    
                        $listaperfil.='</tr>';
                    }
                    $filtrocargo='codigo='.$codcargo;
                    $cargos = getListaCargo($filtrocargo);
                    for ($i = 0; $i < count($cargos); $i++) {
                        $cargo = $cargos[$i];
                        $listacargos.='<tr>';
                        $listacargos.='<th>Cargo:</th>';
                        $listacargos.="<td>{$cargo['nombre']}</td>";
                        $listacargos.='</tr>';
                    }
                }else{
                   $codcargo='';
                   $codperfil='';
                }
                $listadopermisos="";
                $filtropermiso='cedulapersona='.$cedula;
                $listadopermisos.="<table>";
                $listadopermisos.="<tr><th>N&uacute;mero del Permiso</th><th>Fecha Solicitud</th><th>Fecha Inicio</th><th>Fecha Fin</th></tr>";
                $contadorp=0;
                $fechasPermisosMatrices=array();
                $permisos= getListaPermiso($filtropermiso);
                 for ($k = 0; $k < count($permisos); $k++) {
                    $permisof = $permisos[$k];
                    $contadorp++;
                    $fecha_solicitud=date("d-m-Y",strtotime($permisof['fechasolicitud']));
                    $listadopermisos.="<tr><td>{$contadorp}</td><td>{$fecha_solicitud}</td>";
                    $fechainiciop=date("d-m-Y",strtotime($permisof['fechainicio']));
                    $fechafinoe=date("d-m-Y",strtotime($permisof['fechafin']));
                    $listadopermisos.="<td>{$fechainiciop}</td>";
                    $listadopermisos.="<td>{$fechafinoe}</td></tr>";
                    for($s=strtotime($permisof['fechainicio']); $s<=strtotime($permisof['fechafin']); $s+=86400){
                        $recorridoFechaP=date("Y-m-d", $s);   
                            $fechasPermisosMatrices[$s]=$recorridoFechaP;
                        }
                    } 
               $listadopermisos.="</table>";
     
                $contadorfaltas=0;
                $contador_faltas_justificadas=0;
                $contador_no_justificacion=0;
                $fechaIniciof= strtotime($_GET['fechainicio']);
                $fechaFinf=strtotime($_GET['fechafin']);
                        for($r=$fechaIniciof; $r<=$fechaFinf; $r+=86400){
                        $listaprincipal="<tr><th>DIA</th><th>FECHA</th><th>JUSTIFICACION</th></tr>";
                        $recorridoFecha=date("Y-m-d", $r); 
                        $recorridoFechaconvertida = strtotime($recorridoFecha);
                        $recorridoFechaconvertida_formato=date("d-m-Y",strtotime($recorridoFecha));
                        $DiasSemana=array("","Lunes","Martes","Miercoles","Jueves","Viernes");
                        $diaregistro= date('w', $recorridoFechaconvertida);
                        if ($diaregistro==1 || $diaregistro==2  || $diaregistro==3 || $diaregistro==4 || $diaregistro==5) {
                           $BD='assistcontrol';
                           $P='lemo_';
                           $selectCount = "select count(codigo) as contador from {$P}registro where cast(fecha as date)='$recorridoFecha' and cedulaPersona=$cedula";
                           $contador = Conector::ejecutarQuery($selectCount, $BD)[0]['contador'];
                            if ($contador==0) {
                                $contadorfaltas++;
                                //COMPARAR PERMISOS
                                $lista.= "<tr><td>{$DiasSemana[$diaregistro]}</td>";
                                $lista.= "<td>{$recorridoFechaconvertida_formato}</td>";                    
                                if (in_array($recorridoFecha, $fechasPermisosMatrices)) {
                                    $contador_faltas_justificadas++;
                                    $lista.="<td><font color='blue'><b>SI</b></font></td>";
                                }else{
                                    $contador_no_justificacion++;
                                    $lista.="<td><font color='red'><b>NO</b></font></td>";
                                }
                                       
                                }
                            }
                        }
                       
                    
                        $listafaltas.='<table>';
                        $listafaltas.='<tr><th>N&uacute;mero de Ausencias</th><th>Justificadas</th><th>Sin Justificaci&oacute;n</th></tr>';
                        $listafaltas.="<tr><td>$contadorfaltas</td><td>$contador_faltas_justificadas</td><td>$contador_no_justificacion</td></tr>";
                        $listafaltas.="</table>";
                        
                   }
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
<b><?=$titulo_reporte?></b>
<br><br>
<?=$fechabusqueda?>
<br><br>
<?=$titulo_informacion?>
<br><br>
<table>
<?=$listaempleado?>
<?=$listaperfil?>
<?=$listacargos?>    
</table>
<br><br>
<?=$listadopermisos?>  
<br><br>
<table>
<?=$listaprincipal?>
<?=$lista?>
</table>
<br><br>
<?=$listaretardos?>  
<?=$listafaltas?>  
</center>
</body>
