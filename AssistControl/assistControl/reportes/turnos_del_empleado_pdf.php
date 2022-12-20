<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../clases/Conector.php';
require('../../lib/fpdf181/fpdf.php');
date_default_timezone_set('America/Bogota');

    
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

     function getListaTurno($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, horaInicio, horaFin, dia, descripcion from {$P}turno $filtro order by dia;";
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
    $this->Cell(110, 8, '', 0);
    $this->Cell(100, 8, 'LISTADO DE TURNOS', 0);
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
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

// Creación del objeto de la clase heredada
$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Cell(55, 8, '', 0); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8,'CEDULA', 1);
$pdf->Cell(45, 8,'NOMBRES', 1);
$pdf->Cell(45, 8,'APELLIDOS', 1);
$pdf->Cell(20, 8,'ESTADO', 1);
$pdf->Ln(8);
$pdf->Cell(55, 8, '', 0); 
$filtropersona=  'cedula='.$_GET['cedula'];
$detalles_persona = getListaPersona($filtropersona);
for ($i = 0; $i < count($detalles_persona); $i++) {
    $persona = $detalles_persona[$i];
    $pdf->SetFont('Arial', '', 12);
    $pdf->Image('../fotos/'.$persona['foto'],30,55,27);
    $pdf->Cell(40, 8, utf8_decode($persona['cedula']), 1);
    $pdf->Cell(45, 8, utf8_decode($persona['primernombre'])." ". utf8_decode($persona['segundonombre']), 1);
    $pdf->Cell(45, 8, utf8_decode($persona['primerapellido'])." ".  utf8_decode($persona['segundoapellido']), 1);
    $pdf->Cell(20, 8, utf8_decode(Estado($persona['estado'])), 1);
    $pdf->Ln(18);
    $filtrocargo=  'codigo='.$persona['codcargo'];
    $detallescargo = getListaCargo($filtrocargo);
    for ($i = 0; $i < count($detallescargo); $i++) {
        $cargo = $detallescargo[$i];
        $filtroperfil='codigo='.$cargo['codperfil'];
        $detallesperfil = getListaPerfil($filtroperfil);
        for ($i = 0; $i < count($detallesperfil); $i++) {
                $perfil = $detallesperfil[$i];
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(10, 8, '', 0); 
                $pdf->Cell(20, 8,'PERFIL:', 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(70, 8, utf8_decode($perfil['nombre']), 0);
                $pdf->Ln(5);  
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(10, 8, '', 0); 
                $pdf->Cell(20, 8,'CARGO:', 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(70, 8, utf8_decode($cargo['nombre']), 0);
                $pdf->Ln(8);   
       }
    }
    $pdf->Ln(10);
}



$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, '', 0);
$pdf->Cell(40, 8,'HORA (INICIO/FIN)', 1);
$pdf->Cell(45, 8,'DIA', 1);
$pdf->Ln(8);
$filtroturno=  'cedulaPersona='.$_GET['cedula'];
$turnos = getListaTurno($filtroturno);
for ($i = 0; $i < count($turnos); $i++) {
    $turno = $turnos[$i];
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 8, '', 0);
    $pdf->Cell(40, 8, utf8_decode($turno['horainicio']). "-" .utf8_decode($turno['horafin']), 1);
    $pdf->Cell(45, 8, utf8_decode(Turnos($turno['dia'])), 1);
    $pdf->Ln(8);
}          

$pdf->Output();


?>


