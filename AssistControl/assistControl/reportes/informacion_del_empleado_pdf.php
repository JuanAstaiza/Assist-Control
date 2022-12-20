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
    
    function getListaDiseño_Reporte() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = "select codigo,img_banner, direccion_sede, pagina_web, telefono, email from {$P}reporte_pdf;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }

$pdf = new FPDF();
//ENCABEZADO
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
     $diseño_predeterminado = getListaDiseño_Reporte();
for ($i = 0; $i < count($diseño_predeterminado); $i++) {
    $datos = $diseño_predeterminado[$i];   
    // banner
    $pdf->Image("img/{$datos['img_banner']}",5,10,200,22);
}    
$pdf->Ln(20);
$pdf->Cell(18, 10, '', 0);
$pdf->Cell(144, 10, '',0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(57, 10, 'Fecha: '.date('d-m-Y').'', 0);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(100, 8, 'DETALLES DEL EMPLEADO', 0);
$pdf->Ln(30);
//____________________________________________________________________________

//CONTENIDO
$filtropersona=  'cedula='.$_GET['cedula'];
$detalles_persona = getListaPersona($filtropersona);
for ($i = 0; $i < count($detalles_persona); $i++) {
    $persona = $detalles_persona[$i];
    $pdf->Image('../fotos/'.$persona['foto'],87,60,27);
    $pdf->Ln(27);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Nombre Completo:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['primernombre'])." ". utf8_decode($persona['segundonombre'])." ". utf8_decode($persona['primerapellido'])." ".  utf8_decode($persona['segundoapellido']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->SetFillColor(212);
    $pdf->Cell(57, 8, 'Cédula Ciudania:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['cedula']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Fecha de Expedición:', 1);
    $pdf->SetFont('Arial', '', 12);
    $fechaexpedicion=date("d-m-Y",strtotime($persona['fechaexpedicion'])); 
    $pdf->Cell(70, 8, utf8_decode($fechaexpedicion), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Lugar de Expedición:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['lugarexpedicion']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Fecha de Nacimiento:', 1);
    $pdf->SetFont('Arial', '', 12);
    $fechanacimiento=date("d-m-Y",strtotime($persona['fechanacimiento'])); 
    $pdf->Cell(70, 8, utf8_decode($fechanacimiento), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Grupo Sanguíneo:', 1);
    $pdf->SetFont('Arial', '', 12);
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
    $pdf->Cell(70, 8, utf8_decode(GrupoSanguineo($persona['gruposanguineo'])), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Género:', 1);
    $pdf->SetFont('Arial', '', 12);
    function Genero($genero){
        switch ($genero) {
            case '0': return 'Masculino'; break;
            case '1': return 'Femenino'; break;
            default: return 'Desconocido'; break;
        }
    }
    $pdf->Cell(70, 8, utf8_decode(Genero($persona['genero'])), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Lugar de Nacimiento:', 1);
    $pdf->SetFont('Arial', '', 12);
    $filtrociudad=  'codigo='.$persona['codciudad'];
    $detallesciudad = getListaCiudad($filtrociudad);
    for ($i = 0; $i < count($detallesciudad); $i++) {
        $ciudad = $detallesciudad[$i];
        $filtrodepartamento='codigo='.$ciudad['coddepartamento'];
            $detallesDepartamento = getListaDepartamento($filtrodepartamento);
        for ($i = 0; $i < count($detallesDepartamento); $i++) {
            $departamento = $detallesDepartamento[$i];
            $filtropais='codigo='.$departamento['codpais'];
            $detallespais = getListaPais($filtropais);
            for ($i = 0; $i < count($detallespais); $i++) {
                $pais = $detallespais[$i];
                $pdf->Cell(70, 8, utf8_decode($ciudad['nombre'])." - ". utf8_decode($departamento['nombre'])." - ".utf8_decode($pais['nombre']), 1);
                $pdf->Ln(8);   
            }
        }        
    }   
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Dirección de Residencia:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['direccionresidencia']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Telefono o Celular:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['telefono']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, ' Email:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['email']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Perfil:', 1);
    $pdf->SetFont('Arial', '', 12);
    $filtrocargo=  'codigo='.$persona['codcargo'];
    $detallescargo = getListaCargo($filtrocargo);
    for ($i = 0; $i < count($detallescargo); $i++) {
        $cargo = $detallescargo[$i];
        $filtroperfil='codigo='.$cargo['codperfil'];
        $detallesperfil = getListaPerfil($filtroperfil);
        for ($i = 0; $i < count($detallesperfil); $i++) {
                $perfil = $detallesperfil[$i];
                $pdf->Cell(70, 8, utf8_decode($perfil['nombre']), 1);
                $pdf->Ln(8);   
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(33, 8, '', 0); 
                $pdf->Cell(57, 8, 'Cargo:', 1);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(70, 8, utf8_decode($cargo['nombre']), 1);
                $pdf->Ln(8);   
       }
    }
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Tipo Vinculación:', 1);
    $pdf->SetFont('Arial', '', 12);
    $filtrovinculacion=  'codigo='.$persona['codtipovinculacion'];
    $detallesvinculacion = getListaTipoVinculacion($filtrovinculacion);
    for ($i = 0; $i < count($detallesvinculacion); $i++) {
        $vinculacion = $detallesvinculacion[$i];
        $pdf->Cell(70, 8, utf8_decode($vinculacion['nombre']), 1);
        $pdf->Ln(8);   
    }
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Area de Enseñanza:', 1);
    $pdf->SetFont('Arial', '', 12);
    $filtroenseñanza=  'codigo='.$persona['codareaensenanza'];
    $detallesenseñanaza = getListaAreaEnseñanza($filtroenseñanza);
    for ($i = 0; $i < count($detallesenseñanaza); $i++) {
        $enseñanza = $detallesenseñanaza[$i];
        $pdf->Cell(70, 8, utf8_decode($enseñanza['nombre']), 1);
        $pdf->Ln(8);   
    }
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Profesión:', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(70, 8, utf8_decode($persona['profesion']), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Situación:', 1);
    $pdf->SetFont('Arial', '', 12);
    $filtrosituacion=  'codigo='.$persona['codareaensenanza'];
    $detallessitacion = getListaSituacion($filtrosituacion);
    for ($i = 0; $i < count($detallessitacion); $i++) {
        $situacion = $detallessitacion[$i];
        $pdf->Cell(70, 8, utf8_decode($situacion['nombre']), 1);
        $pdf->Ln(8);   
    }
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Estado:', 1);
    $pdf->SetFont('Arial', '', 12);
    function Estado($estado){
        switch ($estado) {
            case '1': return 'Activo'; break;
            case '0': return 'Inactivo'; break;
            default: return 'Desconocido'; break;
        }
    }
    $pdf->Cell(70, 8, utf8_decode(Estado($persona['estado'])), 1);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(33, 8, '', 0); 
    $pdf->Cell(57, 8, 'Fecha de Ingreso y Salida:', 1);
    $pdf->SetFont('Arial', '', 12);
    $fechaingreso=date("d-m-Y",strtotime($persona['fechaingreso'])); 
    $fechasalida=date("d-m-Y",strtotime($persona['fechasalida'])); 
    $pdf->Cell(70, 8, utf8_decode($fechaingreso)."    ".utf8_decode($fechasalida), 1);
    $pdf->Ln(2);
//____________________________________________________________________________    
}
$diseño_predeterminado = getListaDiseño_Reporte();
for ($i = 0; $i < count($diseño_predeterminado); $i++) {
    $datos = $diseño_predeterminado[$i];   
    //PIE DE PAGINA
    $pdf->SetY(260);
    $pdf->SetFont('Arial','I',8);
    $pdf->Cell(0,7,"Sede Central: {$datos['direccion_sede']}  Teléfonos: {$datos['telefono']}",'T',0,'C');
    $pdf->SetY(263);
    $pdf->Cell(0,7,"Página Web: {$datos['pagina_web']}   Email: {$datos['email']}",'',0,'C');
    $pdf->SetY(265);
    $pdf->Cell(0,9.5,"Pasto / Nariño / Colombia",'',0,'C');
} 
    $pdf->SetY(267);
    $pdf->SetX(15);
    $pdf->Cell(0,9.5,'Página 1 de 1',0,0,'');
    $pdf->Image('img/incotec.png',179.9,266.5,20);
    $pdf->SetY(260);
    $pdf->SetX(178);
    $pdf->Cell(0,9.5,'SC-CER433946',0,0,'');
    
    //____________________________________________________________________________
    
$cedula=  'cedula_'.$_GET['cedula'];
$pdf->Output('DetallesEmpleado_'.$cedula.'.pdf','I'); //FINALIZACION

?>