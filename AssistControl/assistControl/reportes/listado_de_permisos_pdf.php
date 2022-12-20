<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../clases/Conector.php';
require('../../lib/fpdf181/fpdf.php');
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
    
    function getListaDiseño_Reporte() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = "select codigo,img_banner, direccion_sede, pagina_web, telefono, email from {$P}reporte_pdf;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
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
    $this->Cell(100, 8, 'LISTADO DE PERMISOS', 0);
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
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(5, 8, 'No', 1); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(32, 8,'CEDULA', 1);
$pdf->Cell(42, 8,'NOMBRES', 1);
$pdf->Cell(42, 8,'APELLIDOS', 1);
$pdf->Cell(40, 8,'FECHA SOLICITUD', 1);
$pdf->Cell(30, 8,'FECHA INICIO', 1);
$pdf->Cell(25, 8,'FECHA FIN', 1);
$pdf->Cell(60, 8,'MOTIVO', 1);
$pdf->Ln(8);
    
$personas = getListaPermisos($filtro);
for ($i = 0; $i < count($personas); $i++) {
    $persona = $personas[$i];
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(5, 8, $i+1, 1); 
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(32, 8, utf8_decode($persona['cedulapersona']), 1);
    $filtropersona='cedula='.$persona['cedulapersona'];
    $datospersona = getListaPersona($filtropersona);
    for ($j = 0; $j < count($datospersona); $j++) {
       $datos = $datospersona[$j];
       $pdf->Cell(42, 8, utf8_decode($datos['primernombre'])." ". utf8_decode($datos['segundonombre']), 1);
       $pdf->Cell(42, 8, utf8_decode($datos['primerapellido'])." ".  utf8_decode($datos['segundoapellido']), 1);
    }
    $fechasolicitud=date("d-m-Y",strtotime($persona['fechasolicitud'])); 
    $pdf->Cell(40, 8, utf8_decode($fechasolicitud), 1);
    $fechainicio=date("d-m-Y",strtotime($persona['fechainicio'])); 
    $pdf->Cell(30, 8, utf8_decode($fechainicio), 1);
    $fechafin=date("d-m-Y",strtotime($persona['fechafin'])); 
    $pdf->Cell(25, 8, utf8_decode($fechafin), 1); 
    $filtromotivo='codigo='.$persona['codmotivo'];
    $motivos = getListaMotivos($filtromotivo);
    for ($k = 0; $k < count($motivos); $k++) {
        $motivo = $motivos[$k];
        $pdf->Cell(60, 8, utf8_decode($motivo['nombre']), 1);
    }
    $pdf->Ln(8);
    
}
            

$pdf->Output();


?>

