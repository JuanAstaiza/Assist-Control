<?php

require_once 'assistControl/clases/Registro.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Turno.php';
require_once 'assistControl/clases/Permiso.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Estado.php';
require_once 'assistControl/clases/Perfil_A.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function restaHoras($horaIni, $horaFin){ 
return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
 
}
$tamaño='';
$verregistros='';
$usuario= unserialize($_SESSION['usuario']);
$cedula=$usuario->getUsuario();
$listadopermisos='';
$forma_reporte='';
$Cfieldset='';
$Ffieldset='';
$comentario_legend='';
$link='';
$exportar_reporte='';
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
$registros='';
$numeroregistros_paginacion='';
$listainformacionpaginacion='';
$listapaginacion='';
$mensaje_numerosRegistros='';
$fechaInicio="";
$fechaFin="";
if (isset($_POST['generar'])) {
$informacion= $_POST['informacion'];
//informacion 1=Asistencia 2=Faltas
    //reporte 1=Individual 2=General
    if ($informacion==1) {
       $tamaño="width=950,height=400";
        $titulo_informacion='<b>Tipo de Informaci&oacute;n:</b> Asistencia';
        $fechaInicio=$_POST['fechaInicio'];
        $fechaFin=$_POST['fechaFin'];
        $fechabusqueda="<b>Desde:</b> $fechaInicio <b>Hasta:</b> $fechaFin";
        if (isset($_POST['cedula'])) {
           $cedula=$_POST['cedula'];
           $filtro_persona=  'cedula ='.$cedula;
         $empleado = Persona_A::getListaEnObjetos($filtro_persona, null);
        for ($i = 0; $i < count($empleado); $i++) {
            $objeto = $empleado[$i];
            $estado=$objeto->getEstadoEnLetras()->getNombre();
            if ($estado=='Inactivo') {
                $listaempleado.='<tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th></tr>';
                $listaempleado.= '<tr bgcolor="#FE2E2E">';
                $listaempleado.= "<td>{$objeto->getCedula()}</td>";
                $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
                $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
                $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
                $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
                $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
                $listaempleado.= '</tr>';
            }else{
                $listaempleado.='<tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th></tr>';
                $listaempleado.= '<tr>';
                $listaempleado.= "<td>{$objeto->getCedula()}</td>";
                $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
                $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
                $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
                $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
                $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
                $listaempleado.= '</tr>';
                
            }
            
        } 
        } else {
           $cedula=''; 
        }
            $titulo_reporte='REPORTE INDIVIDUAL';
            $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  cedulaPersona=$cedula";
          
        $registros= Registro::getListaEnObjetosReporte($filtro);
        $numeroregistros_paginacion=count(Registro::getListaReporte($filtro));
        for ($i = 0; $i < count($registros); $i++) {
            $registro = $registros[$i];
            $listaprincipal="<tr><th>FECHA</th><th>HORA<br> ASIGNADA</th><th>HORA<br> REGISTRADA</th><th>Detalle</th><th>TIPO (ENTRADA/SALIDA)</th></tr>";
            $lista.='<tr>';
            $fecharegistro= substr($registro->getFecha(), 0, 10);
            $lista.= "<td>{$fecharegistro}</td>";
            $fecharegistroformateada=strtotime($fecharegistro);
            $diaregistro= date('w', $fecharegistroformateada);
            $filtroturno='cedulapersona='.$registro->getCedulaPersona().' and dia='.$diaregistro;
            $turnos= Turno::getListaEnObjetos($filtroturno);
            for ($j = 0; $j < count($turnos); $j++) {
                $turno = $turnos[$j];
                //true=entrada
                if ($registro->getTipo()==true) {
                    $horainicio=$turno->getHoraInicio();
                    $lista.="<td>{$horainicio}</td>";
                    $horainicioR= substr($registro->getFecha(), 10);
                    $lista.="<td>{$horainicioR}</td>";
                    if (strtotime($horainicio)==strtotime($horainicioR) || strtotime($horainicio)>strtotime($horainicioR)) {
                        $lista.="<td><font color='blue'><b>Puntual</b></font></td>";       
                    }else{
                        if (strtotime($horainicio)<strtotime($horainicioR)) {
                            $demora=restaHoras($horainicio, $horainicioR);
                               $lista.="<td><font color='red'><b>{$demora}</b></font></td>";

                        }
                    }
                    $lista.="<td>{$registro->getTipoEnLetras()}</td>";
                }else{
                    //false=salida
                    if($registro->getTipo()==false){
                        $horaFin=$turno->getHoraFin();
                        $lista.="<td>{$horaFin}</td>";
                        $horasalidaR= substr($registro->getFecha(), 10);
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
                    $lista.="<td>{$registro->getTipoEnLetras()}</td>";

                }
            }    
            $lista.='</tr>';
        }  
    }else{
        //informacion 1=Asistencia 2=Faltas
        //reporte 1=Individual 2=General
        if ($informacion==2) {
                $tamaño="width=950,height=400";
                $titulo_informacion='<b>Tipo de Informaci&oacute;n:</b> Retardos';
                foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;  
                $fechaInicio=$_POST['fechaInicio'];
                $fechaFin=$_POST['fechaFin'];
                $fechabusqueda="<b>Desde:</b> $fechaInicio <b>Hasta:</b> $fechaFin";
                if (isset($_POST['cedula'])) {
                   $cedula=$_POST['cedula'];
                $filtro_persona=  'cedula ='.$cedula;
                $empleado = Persona_A::getListaEnObjetos($filtro_persona, null);
                for ($i = 0; $i < count($empleado); $i++) {
                    $objeto = $empleado[$i];
                $estado=$objeto->getEstadoEnLetras()->getNombre();
                    if ($estado=='Inactivo') {
                        $listaempleado.='<tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th></tr>';
                        $listaempleado.= '<tr bgcolor="#FE2E2E">';
                        $listaempleado.= "<td>{$objeto->getCedula()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
                        $listaempleado.= '</tr>';
                    }else{
                        $listaempleado.='<tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th></tr>';
                        $listaempleado.= '<tr>';
                        $listaempleado.= "<td>{$objeto->getCedula()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
                        $listaempleado.= '</tr>';

                    }
                }   
                } else {
                   $cedula=''; 
                }
                
            $titulo_reporte='REPORTE INDIVIDUAL';
            $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  cedulaPersona=$cedula";
            $contador=0;
            $contador2=0;
            $registros= Registro::getListaEnObjetosReporte($filtro);
            for ($i = 0; $i < count($registros); $i++) {
                $registro = $registros[$i];
                $listaprincipal="<tr><th>FECHA</th><th>HORA<br> ASIGNADA</th><th>HORA<br> REGISTRADA</th><th>Detalle</th><th>TIPO (ENTRADA/SALIDA)</th></tr>";
                $fecharegistro= substr($registro->getFecha(), 0, 10);
                $fecharegistroformateada=strtotime($fecharegistro);
                $diaregistro= date('w', $fecharegistroformateada);
                $filtroturno='cedulapersona='.$registro->getCedulaPersona().' and dia='.$diaregistro;
                $turnos= Turno::getListaEnObjetos($filtroturno);
                for ($j = 0; $j < count($turnos); $j++) {
                    $turno = $turnos[$j];
                    //true=entrada
                    $horainicioR= substr($registro->getFecha(), 10);
                    $horainicio=$turno->getHoraInicio();
                    if ($registro->getTipo()==true) {                        
                        if (strtotime($horainicio)==strtotime($horainicioR) || strtotime($horainicio)>strtotime($horainicioR)) {
                            //NO HACER NADA
                        }else{
                            if (strtotime($horainicio)<strtotime($horainicioR)) {
                                $contador=$contador+1;
                                $lista.='<tr>';
                                $lista.= "<td>{$fecharegistro}</td>";
                                $horainicioR= substr($registro->getFecha(), 10);
                                $horainicio=$turno->getHoraInicio();
                                $lista.="<td>{$horainicio}</td>";
                                $lista.="<td>{$horainicioR}</td>";
                                $demora=restaHoras($horainicio, $horainicioR);
                                $lista.="<td><font color='red'><b>{$demora}</b></font></td>";
                                $lista.="<td>{$registro->getTipoEnLetras()}</td>";
                            }
                        }
                    }else{
                            //false=salida
                        if($registro->getTipo()==false){
                        $horaFin=$turno->getHoraFin();
                        $horasalidaR= substr($registro->getFecha(), 10);
                        if (strtotime($horaFin)==strtotime($horasalidaR) || strtotime($horaFin)<strtotime($horasalidaR)) {
                            //NO HACER NADA
                        }else{
                            if (strtotime($horaFin)>strtotime($horasalidaR)) {
                                $contador2=$contador2+1;
                                $lista.='<tr>';
                                $lista.= "<td>{$fecharegistro}</td>";
                                $horaFin=$turno->getHoraFin();
                                $horasalidaR= substr($registro->getFecha(), 10);
                                $lista.="<td>{$horaFin}</td>";
                                $lista.="<td>{$horasalidaR}</td>";
                                $demora=restaHoras($horasalidaR, $horaFin);
                                $lista.="<td><font color='red'><b>{$demora}</b></font></td>";
                                $lista.="<td>{$registro->getTipoEnLetras()}</td>";

                            }
                        }
                        }
                    }
                }    
                $lista.='</tr>';
            }
            $contadortotal=$contador+$contador2;
            $listaretardos.='<tr><th>Numero de Retardos</th></tr>';
            $listaretardos.="<tr><td>$contadortotal</td></tr>";
            $numeroregistros_paginacion=$contadortotal;
        }else{
            //informacion 1=Asistencia 2=Retardos 3=Faltas
            //reporte 1=Individual 2=General
            if ($informacion==3) {        
                $tamaño="width=400,height=400";
                $titulo_reporte='REPORTE INDIVIDUAL';
                $forma_reporte='';
                $titulo_informacion='<b>Tipo de Informaci&oacute;n:</b> Ausencias';
                $fechaInicio=date("d-m-Y",strtotime($_POST['fechaInicio']));
                $fechaFin=date("d-m-Y",strtotime($_POST['fechaFin']));
                $fechabusqueda="<b>Desde:</b> $fechaInicio <b>Hasta:</b> $fechaFin";
                if (isset($_POST['cedula'])) {
                $cedula=$_POST['cedula'];
                $filtro_persona=  'cedula ='.$cedula;
                $empleado = Persona_A::getListaEnObjetos($filtro_persona, null);
                for ($i = 0; $i < count($empleado); $i++) {
                    $objeto = $empleado[$i];
                $estado=$objeto->getEstadoEnLetras()->getNombre();
                    if ($estado=='Inactivo') {
                        $listaempleado.='<tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th></tr>';
                        $listaempleado.= '<tr bgcolor="#FE2E2E">';
                        $listaempleado.= "<td>{$objeto->getCedula()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
                        $listaempleado.= '</tr>';
                    }else{
                        $listaempleado.='<tr><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th></tr>';
                        $listaempleado.= '<tr>';
                        $listaempleado.= "<td>{$objeto->getCedula()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
                        $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
                        $listaempleado.= '</tr>';

                    }
                }   
                } else {
                   $cedula=''; 
                }
                $listadopermisos="";
                $filtropermiso='cedulapersona='.$cedula;
                $listadopermisos.="<tr><th>N&uacute;mero del Permiso</th><th>Fecha Solicitud</th><th>Fecha Inicio</th><th>Fecha Fin</th></tr>";
                $contadorp=0;
                $fechasPermisosMatrices=array();
                $permisos= Permiso::getListaEnObjetos($filtropermiso, null);
                 for ($k = 0; $k < count($permisos); $k++) {
                    $permisof = $permisos[$k];
                    $contadorp++;
                    $permisoS=date("d-m-Y",strtotime($permisof->getFechaSolicitud()));
                    $listadopermisos.="<tr><td>{$contadorp}</td><td>{$permisoS}</td>";
                    $fechaInicioP=date("d-m-Y",strtotime($permisof->getFechaInicio()));
                    $fechaFinP=date("d-m-Y",strtotime($permisof->getFechaFin()));
                    $listadopermisos.="<td>{$fechaInicioP}</td>";
                    $listadopermisos.="<td>{$fechaFinP}</td></tr>";
                    for($s=strtotime($permisof->getFechaInicio()); $s<=strtotime($permisof->getFechaFin()); $s+=86400){
                        $recorridoFechaP=date("Y-m-d", $s);   
                            $fechasPermisosMatrices[$s]=$recorridoFechaP;
                        }
                    } 
                    
                $contadorfaltas=0;
                $contador_faltas_justificadas=0;
                $contador_no_justificacion=0;
                $fechaIniciof= strtotime($_POST['fechaInicio']);
                $fechaFinf=strtotime($_POST['fechaFin']);
                        for($r=$fechaIniciof; $r<=$fechaFinf; $r+=86400){
                        $listaprincipal="<tr><th>DIA</th><th>FECHA</th><th>JUSTIFICACION</th></tr>";
                        $recorridoFecha=date("Y-m-d", $r); 
                        $recorridoFechaconvertida = strtotime($recorridoFecha);
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
                                $lista.= "<td>{$recorridoFecha}</td>";                    
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
                       
                    
                        $listafaltas.='<tr><th>N&uacute;mero de Ausencias</th><th>Justificadas</th><th>Sin Justificaci&oacute;n</th></tr>';
                        $listafaltas.="<tr><td>$contadorfaltas</td><td>$contador_faltas_justificadas</td><td>$contador_no_justificacion</td></tr>";
                        $numeroregistros_paginacion=$contadorfaltas;
                        
                   }
        }
    }
 

$numeroregistros=$numeroregistros_paginacion;
if ($numeroregistros>0) {
    $mensaje_numerosRegistros="Se han encontrado $numeroregistros resultados.";
    $link="<a target='_blank'  href='assistControl/reportes/reporteUsuario_excel.php?reporte=$titulo_reporte&informacion=$informacion&fechainicio=$fechaInicio&fechafin=$fechaFin&cedula=$cedula&forma_reporte=$forma_reporte'>";
    $link2="<a target='_blank'  href='assistControl/reportes/reporteUsuario_word.php?reporte=$titulo_reporte&informacion=$informacion&fechainicio=$fechaInicio&fechafin=$fechaFin&cedula=$cedula&forma_reporte=$forma_reporte'>";
    $link3="<a target='_blank'  href='assistControl/reportes/reporteUsuario_pdf.php?reporte=$titulo_reporte&informacion=$informacion&fechainicio=$fechaInicio&fechafin=$fechaFin&cedula=$cedula&forma_reporte=$forma_reporte'>";
    $exportar_reporte="<b>Exportar en:</b>&nbsp;&nbsp;&nbsp;$link<img src='presentacion/imagenes/AssitControl/excel.png' width='40' height='40' title='Documento EXCEL'/></a>&nbsp;&nbsp;&nbsp;$link2<img src='presentacion/imagenes/AssitControl/word.png' width='40' height='40' title='Documento WORD'/></a>&nbsp;&nbsp;&nbsp;$link3<img src='presentacion/imagenes/AssitControl/pdf.png' width='40' height='40' title='Documento PDF'/></a>";
    $parametros="?reporte=$titulo_reporte&informacion=$informacion&fechainicio=$fechaInicio&fechafin=$fechaFin&cedula=$cedula&forma_reporte=$forma_reporte'";
    $verregistros="<a  onclick='verreportes();'><img src='presentacion/imagenes/AssitControl/registros.png' width='100' height='100' title='Ver Informaci&oacute;n del Reporte'/></a>";
}else{
   $mensaje_numerosRegistros="No se encuentran resultados con los criterios de b&uacute;squeda.";
}
$Cfieldset="<fieldset>";
$Ffieldset="</fieldset>";
$comentario_legend="<legend><font color='blue'><b>DATOS PRINCIPALES DEL REPORTE</b></font></legend>";


}
?>
<script type="text/javascript">
    function verreportes(){
        window.open("assistControl/ver_registrosUsuario.php<?=$parametros?>",null,"<?=$tamaño?>,scrollbars=yes,resizable=no"); 
    }
</script>
<h2>REPORTES</h2><br>
<form name="formulario" method="POST">
    <table>
        <tr><th>Informaci&oacute;n:</th><td colspan="5"><select name="informacion" required><option value="null">Escoja una opcion</option><option value="1">Asistencias</option><option value="2">Retardos</option><option value="3">Ausencias</option></select></td></tr>
        <tr><th>Desde:</th><td><input type="date" name="fechaInicio" value="<?=$fechaInicio?>" required/></td><th>Hasta</th><td colspan="3"><input type="date" name="fechaFin" value="<?=$fechaFin?>" required/></td></tr>
        <tr><td><input type="hidden"  name="cedula" value="<?=$cedula?>" readonly/></td></tr>
    </table>
    <br><br>
   <input type="submit" value="Generar" name="generar">
</form><br>
<center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje_numerosRegistros?></div></center>
<br>
<?=$exportar_reporte?>
<br><br>
<?=$Cfieldset?>
<?=$comentario_legend?>
<b><?=$titulo_reporte?></b>
<br><br>
<?=$fechabusqueda?>
<br><br>
<?=$titulo_informacion?>
<br><br>
<table>
<?=$listaempleado?>
</table>
<br><br>
<table>
    <?=$listadopermisos?>  
</table>
<br><br>
<?=$verregistros?>
<!--AQUI COMIENZA EL INFORMACION DEL REPORTE  
<table>
//$listaprincipal
//$lista
</table>
AQUI TERMINA EL INFORMACION DEL REPORTE   -->
<br><br>
<table>
<?=$listaretardos?>  
<?=$listafaltas?>  
</table>
<?=$Ffieldset?>
