<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../clases/Conector.php';
require('../../lib/fpdf181/fpdf.php');
date_default_timezone_set('America/Bogota');

function restaHoras($horaIni, $horaFin){ 
return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
 
}
     function getListaDiseño_Reporte() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = "select codigo,img_banner, direccion_sede, pagina_web, telefono, email from {$P}reporte_pdf;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
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

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
 $diseño_predeterminado = getListaDiseño_Reporte();
for ($i = 0; $i < count($diseño_predeterminado); $i++) {
    $datos = $diseño_predeterminado[$i];   
    // banner
    $this->Image("img/{$datos['img_banner']}",5,10,285,28);
}
    $this->Ln(25);
    $this->Cell(18, 10, '', 0);
    $this->Cell(230, 10, '',0);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(57, 10, 'Fecha: '.date('d-m-Y').'', 0);
    $this->Ln(10);
    $this->SetFont('Arial', 'B', 15);
    $this->Cell(100, 8, '', 0);
    $this->Cell(100, 8, $_GET['reporte'], 0);
    // Salto de línea
    $this->Ln(15);
}

function Footer()
{
     $diseño_predeterminado = getListaDiseño_Reporte();
for ($i = 0; $i < count($diseño_predeterminado); $i++) {
    $datos = $diseño_predeterminado[$i];   
    $this->SetY(195);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,7,"Sede Central: {$datos['direccion_sede']}  Teléfonos: {$datos['telefono']}",'T',0,'C');
    $this->SetY(198);
    $this->Cell(0,7,"Página Web: {$datos['pagina_web']}   Email: {$datos['email']}",'',0,'C');
    $this->SetY(199.5);
    $this->Cell(0,9.5,"Pasto / Nariño / Colombia",'',0,'C');
}
    $this->SetY(197);
    $this->SetX(15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'');
    $this->Image('img/incotec.png',267,197,15);
    $this->SetY(193);
    $this->SetX(273);
    $this->Cell(0,9.5,'SC-CER433946',0,0,'');
}
}
$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Cell(90, 8, '', 0); 
$pdf->SetFont('Arial', 'B', 12);

$informacion= $_GET['informacion'];
//informacion 1=Asistencia 2=Faltas
    //reporte 1=Individual 2=General
    if ($informacion==1) {
        $titulo_informacion='Asistencia';
        $forma_reporte=$_GET['forma_reporte'];
        $fechaInicio=date("d-m-Y",strtotime($_GET['fechainicio']));
        $fechaFin=date("d-m-Y",strtotime($_GET['fechafin']));
        $pdf->Cell(40, 8,'Desde: '. ' ' . $fechaInicio . '  ' .'Hasta: '. '  ' . $fechaFin, 0);
        if ($_GET['cedula']!=null) {
           $cedula=$_GET['cedula'];
           $filtro_persona=  'cedula ='.$cedula;
         $empleado = getListaPersona($filtro_persona);
        for ($i = 0; $i < count($empleado); $i++) {
            $objeto = $empleado[$i];
            $pdf->Ln(8);
            $pdf->Cell(55, 8,'', 0);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(40, 8,'CEDULA', 1);
            $pdf->Cell(45, 8,'NOMBRES', 1);
            $pdf->Cell(45, 8,'APELLIDOS', 1);
            $pdf->Cell(20, 8,'ESTADO', 1);
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(55, 8,'', 0);
            $pdf->Cell(40, 8, utf8_decode($objeto['cedula']), 1);
            $pdf->Cell(45, 8, utf8_decode($objeto['primernombre'])." ". utf8_decode($objeto['segundonombre']), 1);
            $pdf->Cell(45, 8, utf8_decode($objeto['primerapellido'])." ".  utf8_decode($objeto['segundoapellido']), 1);
            $pdf->Cell(20, 8, utf8_decode(Estado($objeto['estado'])), 1);
        } 
        } else {
           $cedula=''; 
        }
         $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  cedulaPersona=$cedula";
        $pdf->Ln(9); 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(98, 8, '', 0); 
        $pdf->Cell(44, 8,'Tipo de Información:', 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(70, 8, utf8_decode($titulo_informacion), 0);
        $pdf->Ln(9);
        $pdf->Cell(43, 8,'', 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(25, 8,'FECHA', 1);
        $pdf->Cell(44, 8,'HORA ASIGNADA', 1);
        $pdf->Cell(44, 8,'HORA REGISTRADA', 1);
        $pdf->Cell(38, 8,'DETALLE', 1);
        $pdf->Cell(25, 8,'TIPO (E/S)', 1);
        $registros= getListaReporte($filtro);
        for ($i = 0; $i < count($registros); $i++) {
            $registro = $registros[$i];
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(43, 8,'', 0);
            $fecharegistro= substr($registro['fecha'], 0, 10);
            $fecharegistroc=date("d-m-Y",strtotime($fecharegistro));
            $pdf->Cell(25, 8, utf8_decode($fecharegistroc), 1);
            $fecharegistroformateada=strtotime($fecharegistro);
            $diaregistro= date('w', $fecharegistroformateada);
            $filtroturno='cedulapersona='.$registro['cedulapersona'].' and dia='.$diaregistro;
            $turnos= getListaTurno($filtroturno);
            for ($j = 0; $j < count($turnos); $j++) {
                $turno = $turnos[$j];
                //true=entrada
                if ($registro['tipo']==true) {
                    $horainicio=$turno['horainicio'];
                    $pdf->Cell(44, 8,$horainicio, 1);
                    $horainicioR= substr($registro['fecha'], 10);
                    $pdf->Cell(44, 8,$horainicioR, 1);
                    if (strtotime($horainicio)==strtotime($horainicioR) || strtotime($horainicio)>strtotime($horainicioR)) {
                        $pdf->SetTextColor(0,0,255); 
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(38, 8, 'Puntual', 1);
                        $pdf->SetTextColor(0,0,0); 
                        $pdf->SetFont('Arial', '', 12);
                    }else{
                        if (strtotime($horainicio)<strtotime($horainicioR)) {
                            $demora=restaHoras($horainicio, $horainicioR);
                            $pdf->SetTextColor(255,61,61); 
                            $pdf->SetFont('Arial', 'B', 12);
                            $pdf->Cell(38, 8, $demora, 1);
                            $pdf->SetTextColor(0,0,0); 
                            $pdf->SetFont('Arial', '', 12);

                        }
                    }
                    $pdf->Cell(25, 8, utf8_decode(getTipoEnLetras($registro['tipo'])), 1);
                }else{
                    //false=salida
                    if($registro['tipo']==false){
                        $horaFin=$turno['horafin'];
                       $pdf->Cell(44, 8,$horaFin, 1);
                        $horasalidaR= substr($registro['fecha'], 10);
                        $pdf->Cell(44, 8,$horasalidaR, 1);
                    if (strtotime($horaFin)==strtotime($horasalidaR) || strtotime($horaFin)<strtotime($horasalidaR)) {
                            $pdf->SetTextColor(0,0,255); 
                            $pdf->SetFont('Arial', 'B', 12);
                            $pdf->Cell(38, 8, 'Horario Cumplido', 1);
                            $pdf->SetTextColor(0,0,0); 
                            $pdf->SetFont('Arial', '', 12);
                        }else{
                        if (strtotime($horaFin)>strtotime($horasalidaR)) {
                            $demora=restaHoras($horasalidaR, $horaFin);
                            $pdf->SetTextColor(255,61,61); 
                            $pdf->SetFont('Arial', 'B', 12);
                            $pdf->Cell(38, 8, $demora, 1);
                            $pdf->SetTextColor(0,0,0); 
                            $pdf->SetFont('Arial', '', 12);
                        } 
                    }
                    }
                    $pdf->Cell(25, 8, utf8_decode(getTipoEnLetras($registro['tipo'])), 1);

                }
            }    
        }
    }else{
        //informacion 1=Asistencia 2=Faltas
        //reporte 1=Individual 2=General
        if ($informacion==2) {
                $titulo_informacion='Retardos';
                $forma_reporte=$_GET['forma_reporte'];
                $fechaInicio=date("d-m-Y",strtotime($_GET['fechainicio']));
                $fechaFin=date("d-m-Y",strtotime($_GET['fechafin']));
                $pdf->Cell(40, 8,'Desde: '. ' ' . $fechaInicio . '  ' .'Hasta: '. '  ' . $fechaFin, 0);
                if ($_GET['cedula']!=null) {
                   $cedula=$_GET['cedula'];
                   $filtro_persona=  'cedula ='.$cedula;
                 $empleado = getListaPersona($filtro_persona);
                for ($i = 0; $i < count($empleado); $i++) {
                    $objeto = $empleado[$i];
                    $pdf->Ln(8);
                    $pdf->Cell(55, 8,'', 0);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(40, 8,'CEDULA', 1);
                    $pdf->Cell(45, 8,'NOMBRES', 1);
                    $pdf->Cell(45, 8,'APELLIDOS', 1);
                    $pdf->Cell(20, 8,'ESTADO', 1);
                    $pdf->Ln(8);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(55, 8,'', 0);
                    $pdf->Cell(40, 8, utf8_decode($objeto['cedula']), 1);
                    $pdf->Cell(45, 8, utf8_decode($objeto['primernombre'])." ". utf8_decode($objeto['segundonombre']), 1);
                    $pdf->Cell(45, 8, utf8_decode($objeto['primerapellido'])." ".  utf8_decode($objeto['segundoapellido']), 1);
                    $pdf->Cell(20, 8, utf8_decode(Estado($objeto['estado'])), 1);
                } 
                } else {
                   $cedula=''; 
                }
            
                $filtro="lemo_registro.cedulapersona=lemo_persona.cedula and fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  cedulaPersona=$cedula";
            $contador=0;
            $contador2=0;
            $pdf->Ln(9); 
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(98, 8, '', 0); 
            $pdf->Cell(44, 8,'Tipo de Información:', 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(70, 8, utf8_decode($titulo_informacion), 0);
            $pdf->Ln(9);
            $pdf->Cell(43, 8,'', 0);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(25, 8,'FECHA', 1);
            $pdf->Cell(44, 8,'HORA ASIGNADA', 1);
            $pdf->Cell(44, 8,'HORA REGISTRADA', 1);
            $pdf->Cell(38, 8,'DETALLE', 1);
            $pdf->Cell(25, 8,'TIPO (E/S)', 1);
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
                                $pdf->Ln(8);
                                $pdf->SetFont('Arial', '', 12);
                                $pdf->Cell(43, 8,'', 0);
                                $fecharegistroc=date("d-m-Y",strtotime($fecharegistro));
                                $pdf->Cell(25, 8, utf8_decode($fecharegistroc), 1);
                                $horainicio=$turno['horainicio'];
                                $pdf->Cell(44, 8,$horainicio, 1);
                                $horainicioR= substr($registro['fecha'], 10);
                                $pdf->Cell(44, 8,$horainicioR, 1);
                                $demora=restaHoras($horainicio, $horainicioR);
                                $pdf->SetTextColor(255,61,61); 
                                $pdf->SetFont('Arial', 'B', 12);
                                $pdf->Cell(38, 8, $demora, 1);
                                $pdf->SetTextColor(0,0,0); 
                                $pdf->SetFont('Arial', '', 12);
                                $pdf->Cell(25, 8, utf8_decode(getTipoEnLetras($registro['tipo'])), 1);
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
                                $pdf->Ln(8);
                                $pdf->SetFont('Arial', '', 12);
                                $pdf->Cell(43, 8,'', 0);
                                $fecharegistroc=date("d-m-Y",strtotime($fecharegistro));
                                $pdf->Cell(25, 8, utf8_decode($fecharegistroc), 1);
                                $horaFin=$turno['horafin'];
                                $pdf->Cell(44, 8,$horaFin, 1);
                                $horasalidaR= substr($registro['fecha'], 10);
                                $pdf->Cell(44, 8,$horasalidaR, 1);
                                $demora=restaHoras($horasalidaR, $horaFin);
                                $pdf->SetTextColor(255,61,61); 
                                $pdf->SetFont('Arial', 'B', 12);
                                $pdf->Cell(38, 8, $demora, 1);
                                $pdf->SetTextColor(0,0,0); 
                                $pdf->SetFont('Arial', '', 12);
                                $pdf->Cell(25, 8, utf8_decode(getTipoEnLetras($registro['tipo'])), 1);

                            }
                        }
                        }
                    }
                }    
            }
            $contadortotal=$contador+$contador2;
            $pdf->Ln(12);
            $pdf->Cell(110, 8,'', 0);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(153,0,0); 
            $pdf->Cell(45, 8,'Número de Retardos', 1);
            $pdf->SetTextColor(0,0,0); 
            $pdf->Ln(8);
            $pdf->Cell(110, 8,'', 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(45, 8,$contadortotal, 1);
        }else{
               if ($informacion==3) {
                $titulo_informacion='Ausencias';
                $fechaInicio=date("d-m-Y",strtotime($_GET['fechainicio']));
                $fechaFin=date("d-m-Y",strtotime($_GET['fechafin']));
                $pdf->Cell(40, 8,'Desde: '. ' ' . $fechaInicio . '  ' .'Hasta: '. '  ' . $fechaFin, 0);
                if ($_GET['cedula']!=null) {
                   $cedula=$_GET['cedula'];
                   $filtro_persona=  'cedula ='.$cedula;
                 $empleado = getListaPersona($filtro_persona);
                for ($i = 0; $i < count($empleado); $i++) {
                    $objeto = $empleado[$i];
                    $pdf->Ln(8);
                    $pdf->Cell(55, 8,'', 0);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(40, 8,'CEDULA', 1);
                    $pdf->Cell(45, 8,'NOMBRES', 1);
                    $pdf->Cell(45, 8,'APELLIDOS', 1);
                    $pdf->Cell(20, 8,'ESTADO', 1);
                    $pdf->Ln(8);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(55, 8,'', 0);
                    $pdf->Cell(40, 8, utf8_decode($objeto['cedula']), 1);
                    $pdf->Cell(45, 8, utf8_decode($objeto['primernombre'])." ". utf8_decode($objeto['segundonombre']), 1);
                    $pdf->Cell(45, 8, utf8_decode($objeto['primerapellido'])." ".  utf8_decode($objeto['segundoapellido']), 1);
                    $pdf->Cell(20, 8, utf8_decode(Estado($objeto['estado'])), 1);
                } 
                } else {
                   $cedula=''; 
                }
                $pdf->Ln(9); 
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(98, 8, '', 0); 
                $pdf->Cell(44, 8,'Tipo de Información:', 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(70, 8, utf8_decode($titulo_informacion), 0);
                $pdf->Ln(9);
                $pdf->Cell(50, 8,'', 0);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(25, 8,'No Permiso', 1);
                $pdf->Cell(45, 8,'FECHA SOLICITUD', 1);
                $pdf->Cell(45, 8,'FECHA INICIO', 1);
                $pdf->Cell(45, 8,'FECHA FIN', 1);
                $listadopermisos="";
                $filtropermiso='cedulapersona='.$cedula;
                $contadorp=0;
                $fechasPermisosMatrices=array();
                $permisos= getListaPermiso($filtropermiso, null);
                for ($k = 0; $k < count($permisos); $k++) {
                    $permisof = $permisos[$k];
                    $contadorp++;
                    $pdf->Ln(8);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(50, 8,'', 0);
                    $pdf->Cell(25, 8, $contadorp, 1);
                    $fechapermiso=date("d-m-Y",strtotime($permisof['fechasolicitud']));
                    $pdf->Cell(45, 8, utf8_decode($fechapermiso), 1);
                    $fechainiciop=date("d-m-Y",strtotime($permisof['fechainicio']));
                    $pdf->Cell(45, 8, utf8_decode($fechainiciop), 1);
                    $fechafinoe=date("d-m-Y",strtotime($permisof['fechafin']));
                    $pdf->Cell(45, 8, utf8_decode($fechafinoe), 1);
                     for($s=strtotime($permisof['fechainicio']); $s<=strtotime($permisof['fechafin']); $s+=86400){
                        $recorridoFechaP=date("Y-m-d", $s);   
                            $fechasPermisosMatrices[$s]=$recorridoFechaP;
                        }
                }
                    $pdf->Ln(15);
                    $pdf->Cell(82, 8,'', 0);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(30, 8,'DIA', 1);
                    $pdf->Cell(30, 8,'FECHA', 1);
                    $pdf->Cell(40, 8,'JUSTIFICACION', 1);
                $contadorfaltas=0;
                $contador_faltas_justificadas=0;
                $contador_no_justificacion=0;
                $fechaIniciof= strtotime($_GET['fechainicio']);
                $fechaFinf=strtotime($_GET['fechafin']);
                    for($r=$fechaIniciof; $r<=$fechaFinf; $r+=86400){
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
                                    $pdf->Ln(8);
                                    $pdf->SetFont('Arial', '', 12);
                                    $pdf->Cell(82, 8,'', 0);
                                    $pdf->Cell(30, 8, $DiasSemana[$diaregistro], 1);
                                     $recorridoFechas=date("d-m-Y",strtotime($recorridoFecha));
                                     $pdf->Cell(30, 8, utf8_decode($recorridoFechas), 1);
                                     if (in_array($recorridoFecha, $fechasPermisosMatrices)) {
                                    $contador_faltas_justificadas++;
                                    $pdf->SetTextColor(0,0,255); 
                                    $pdf->SetFont('Arial', 'B', 12);
                                    $pdf->Cell(40, 8, "SI", 1);
                                    $pdf->SetTextColor(0,0,0); 
                                    $pdf->SetFont('Arial', '', 12);
                                    }else{
                                        $pdf->SetTextColor(255,61,61); 
                                        $pdf->SetFont('Arial', 'B', 12);
                                        $contador_no_justificacion++;
                                        $pdf->Cell(40, 8, "NO", 1);
                                        $pdf->SetTextColor(0,0,0); 
                                        $pdf->SetFont('Arial', '', 12);
                                    }
                                       
                                
                                 }
                            }
                        }
                    } 
                        $pdf->Ln(15);
                        $pdf->Cell(68, 8,'', 0);
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->SetTextColor(153,0,0); 
                        $pdf->Cell(48, 8,'Número de Ausencias', 1);
                        $pdf->SetTextColor(0,0,255); 
                        $pdf->Cell(35, 8,'Justificadas', 1);
                        $pdf->SetTextColor(153,0,0); 
                        $pdf->Cell(45, 8,'Sin Justificación', 1);
                        $pdf->SetTextColor(0,0,0); 
                        $pdf->Ln(8);
                        $pdf->Cell(68, 8,'', 0);
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(48, 8,$contadorfaltas, 1);
                        $pdf->Cell(35, 8,$contador_faltas_justificadas, 1);
                        $pdf->Cell(45, 8,$contador_no_justificacion, 1);
        }
    }

    $pdf->Output(); //FINALIZACION
