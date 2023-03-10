<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../clases/Conector.php';
require('../../lib/fpdf181/fpdf.php');
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

class PDF extends FPDF
{
// Cabecera de p?gina
function Header()
{ 
    // Logo
    $this->Image('img/banner.jpg',5,10,285);
    $this->Ln(25);
    $this->Cell(18, 10, '', 0);
    $this->Cell(230, 10, '',0);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(57, 10, 'Fecha: '.date('d-m-Y').'', 0);
    $this->Ln(10);
    $this->SetFont('Arial', 'B', 15);
    $this->Cell(100, 8, '', 0);
    $this->Cell(100, 8, 'PERMISO DEL EMPLEADO', 0);
    // Salto de l?nea
    $this->Ln(20);
}

// Pie de p?gina
function Footer()
{
    $this->SetY(195);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,7,'Sede Central: carrera. 4? # 16-180 Sector Potrerillo.  Tel?fonos: (2) 7219744 - (2) 7219743','T',0,'C');
    $this->SetY(198);
    $this->Cell(0,7,'P?gina Web: www.iemoraosejo.edu.co   Email: luiseduardomoraosejo2011@gmail.com','',0,'C');
    $this->SetY(199.5);
    $this->Cell(0,9.5,'Pasto / Nari?o / Colombia','',0,'C');
    $this->SetY(197);
    $this->SetX(15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'P?gina '.$this->PageNo().'/{nb}',0,0,'');
    $this->Image('img/incotec.png',267,197,15);
    $this->SetY(193);
    $this->SetX(273);
    $this->Cell(0,9.5,'SC-CER433946',0,0,'');
}
}

$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Cell(65, 8, '', 0); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8,'CEDULA', 1);
$pdf->Cell(45, 8,'NOMBRES', 1);
$pdf->Cell(45, 8,'APELLIDOS', 1);
$pdf->Cell(20, 8,'ESTADO', 1);
$pdf->Ln(8);
$pdf->Cell(65, 8, '', 0); 

$contador=0;
$total="";

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
    $pdf->Ln(20);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 8, '', 0);
$pdf->Cell(40, 8,'FECHA SOLICITUD', 1);
$pdf->Cell(30, 8,'FECHA INICIO', 1);
$pdf->Cell(30, 8,'FECHA FIN', 1);
$pdf->Cell(100, 8,'MOTIVO', 1);
$pdf->Ln(8);
$filtropermiso=  'codigo='.$_GET['codigo'];
$permisos = getListaPermiso($filtropermiso);
for ($i = 0; $i < count($permisos); $i++) {
    $permiso = $permisos[$i];    
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(45, 8, '', 0);
    $fechasolicitud=date("d-m-Y",strtotime($permiso['fechasolicitud'])); 
    $pdf->Cell(40, 8, utf8_decode($fechasolicitud), 1);
    $fechainicio=date("d-m-Y",strtotime($permiso['fechainicio'])); 
    $pdf->Cell(30, 8, utf8_decode($fechainicio), 1);
    $fechafin=date("d-m-Y",strtotime($permiso['fechafin'])); 
    $pdf->Cell(30, 8, utf8_decode($fechafin), 1);
    $filtromotivo='codigo='.$permiso['codmotivo'];
    $motivos = getListaMotivo($filtromotivo);
    for ($i = 0; $i < count($motivos); $i++) {
        $motivo = $motivos[$i];    
        $pdf->Cell(100, 8, utf8_decode($motivo['nombre']), 1);
    }    
}   
       
$pdf->Output();


?>


