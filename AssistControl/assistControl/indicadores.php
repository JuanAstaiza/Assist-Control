<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'clases/Conector.php';

    function getListaPersona() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
            . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
            . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona  order by random() limit 10;";
       return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
   function getListaIndicadorPermiso() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = "select concat({$P}persona.primernombre||' '|| {$P}persona.primerapellido)as nombre, count({$P}permiso.cedulapersona) as cantidadpermisos  "
        . "from {$P}persona,{$P}permiso where {$P}persona.cedula={$P}permiso.cedulapersona group by {$P}persona.primernombre, {$P}persona.primerapellido order by cantidadpermisos desc limit 10;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaTurno($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, horaInicio, horaFin, dia, descripcion from {$P}turno $filtro order by dia;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function getListaReporte($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fecha, tipo from {$P}registro,{$P}persona $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
     function getListaAsistencias() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = " select concat({$P}persona.primernombre||' '|| {$P}persona.primerapellido)as nombre, count(cedulapersona) as numeroasistencias from {$P}registro,{$P}persona where {$P}registro.cedulapersona={$P}persona.cedula and tipo=true group by {$P}persona.primernombre,{$P}persona.primerapellido  order by random() desc limit 10;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    //INDICADOR DE PERMISOS

    $listapermisos='';
    $datosGraficaspermiso='';
    $listapermisos.='<table border="1">';
    $listapermisos.='<tr><th colspan="3">PETICIONES DE PERMISOS</th></tr>';
    $listapermisos.="<tr><th>Posición</th><th>Nombre Empleado</th><th>Cantidad Permisos</th></tr>"; 
    $datosGraficaspermiso.="var datosP=[";
    $colorpermiso=array("#116A67","#51D506","#D5CE06","#060FD5","#0686D5","#06A9D5","#06D59C","#D59C06","#06C8D5","#D50606");
    $permisos = getListaIndicadorPermiso();
    for ($i = 0; $i < count($permisos); $i++) {
       $objeto = $permisos[$i];
        $nombres=$objeto['nombre'];
        $nPermisos=$objeto['cantidadpermisos'];
        if( $i>0) $datosGraficaspermiso.=', ';
        $listapermisos.="<tr><td>".($i+1)."</td><td>".$objeto['nombre']."</td><td>".$objeto['cantidadpermisos']."</td></tr>";
        $datosGraficaspermiso.="\n{'detallepermiso': '$nombres', 'N_permiso': $nPermisos, colorpermiso: '$colorpermiso[$i]'}";
    }  
    $listapermisos.="</table>";    
    $datosGraficaspermiso.='];';
    $graficaP="<script type='text/javascript'>
            var chart;
            $datosGraficaspermiso
                AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = datosP;
                chart.categoryField = 'detallepermiso';
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 45; // this line makes category values to be rotated
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillAlpha = 1;
                categoryAxis.fillColor = '#FAFAFA';
                categoryAxis.gridPosition = 'start';

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.dashLength = 5;
                valueAxis.title = 'Cantidad Permisos';
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = 'N_permiso';
                graph.colorField = 'colorpermiso';
                graph.balloonText = '<b>[[category]]: [[value]]</b> Permisos';
                graph.type = 'column';
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = 'top-right';

                // WRITE
                chart.write('chartdivpermiso');
            });
</script> ";
 //INDICADOR DE  RETARDOS
            $datosGraficasretardos='';
            $datosGraficasretardos.="var datosR=[";
            $colorretardo=array("#849249","#2cc84d","#43783c","#81c5e2","#1aed44","#6c1cd9","#a2dbeb","#f9ef53","#3d179b","#8a79fc");
            $personas= getListaPersona();
            for ($l= 0; $l < count($personas); $l++) {
            $persona = $personas[$l];
            if( $l>0) $datosGraficasretardos.=', ';
            $contador=0;
            $contador2=0;  
            $nombre=$persona['primernombre']." " .$persona['primerapellido'];
            $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and cedulaPersona={$persona['cedula']}";
            $registros= getListaReporte($filtro);
            for ($i = 0; $i < count($registros); $i++) {
                $registro = $registros[$i];
                $fecharegistro= substr($registro['fecha'], 0, 10);
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
                            }
                        }
                        }
                    }
                } 
            }
            $contadortotal=$contador+$contador2;
            $datosGraficasretardos.="\n{'detalleN': '$nombre', 'N_retardos': $contadortotal, colorretardos: '$colorretardo[$l]'}";
     }
     $datosGraficasretardos.='];';
     $graficaF="<script type='text/javascript'>
            var chart;
            $datosGraficasretardos
             
            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = datosR;
                chart.categoryField = 'detalleN';
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = 'start';

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = 'Cantidad de Retardos';
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = 'N_retardos';
                graph.colorField = 'colorretardos';
                graph.balloonText = '<b>[[category]]: [[value]]</b> Retardos';
                graph.type = 'column';
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = 'top-right';


                // WRITE
                chart.write('chartdivfaltas');
            });
</script> ";
//INDICADOR DE ASISTENCIAS
$listaAsistencias='';
$nombres='';
$datosGraficasAsistecias='';
$datosGraficasAsistecias.="var chartData=[";
$datosGraficasAsistecias.="{";
$colorasistencia=array("#f74e18","#45cf03","#09f7c3","#68e387","#cfe0b6","#5ceb79");
$asistencias= getListaAsistencias();
for ($i= 0; $i < count($asistencias); $i++) {
    $asitencia = $asistencias[$i];
   $nombre_empleado=$asitencia['nombre'];
   if( $i>0) $datosGraficasAsistecias.=', ';
   $datosGraficasAsistecias.="\n'Asistencia': 'Asistencias','{$asitencia['nombre']}': {$asitencia['numeroasistencias']}";
   $nombres.="   var graph = new AmCharts.AmGraph();
                graph.title = '{$asitencia['nombre']}';
                graph.labelText = '[[value]]';
                graph.valueField = '{$asitencia['nombre']}';
                graph.type = 'column';
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                graph.lineColor = '$colorasistencia[$i]';
                graph.balloonText = '<b>[[category]]: [[value]]</b>';
                chart.addGraph(graph);
";
   
 } 
$datosGraficasAsistecias.="}";
$datosGraficasAsistecias.='];';
$graficaA="<script type='text/javascript'>
            var chart;
            
            $datosGraficasAsistecias

             AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
               chart.categoryField = 'Asistencia';
                chart.plotAreaBorderAlpha = 0.2;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;
                categoryAxis.gridPosition = 'start';

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.stackType = 'regular';
                valueAxis.gridAlpha = 0.1;
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                $nombres

              
                // LEGEND
                var legend = new AmCharts.AmLegend();
                legend.borderAlpha = 0.2;
                legend.horizontalGap = 10;
                chart.addLegend(legend);

                // WRITE
                chart.write('chartdiv');
            });

            // this method sets chart 2D/3D
            function setDepth() {
                if (document.getElementById('rb1').checked) {
                    chart.depth3D = 0;
                    chart.angle = 0;
                } else {
                    chart.depth3D = 25;
                    chart.angle = 30;
                }
                chart.validateNow();
            }
        </script>";
?>
<h2>INDICADORES</h2><br>
<table>
    <tr><th><h3>EMPLEADOS CON MAYORES PERMISOS</h3></th><th><h3>RETARDOS</h3></th></tr>
    <tr><td><?=$graficaP?><div id="chartdivpermiso" style="width: 500px; height: 300px;"></div></td>
        <td><?=$graficaF?><div id="chartdivfaltas" style="width: 600px; height: 400px;"></div></td></tr>
    <tr><th colspan="2"><h3>ASISTENCIAS</h3></th></tr>
    <tr><td colspan="2"><center><?=$graficaA?>
       <div id="chartdiv" style="width: 600px; height: 400px;"></div>
        <div style="margin-left:30px;">
        <input type="radio" checked="true" name="group" id="rb1" onclick="setDepth()">2D
        <input type="radio" name="group" id="rb2" onclick="setDepth()">3D
        </div></center>
       </td></tr>
</table>

