<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../clases/Conector.php';
require('../../lib/fpdf181/fpdf.php');
date_default_timezone_set('America/Bogota');

$TEXTO=null;
$cargo=null;
$estado=null;

 $OPCION=$_GET['opcion'];
    if ($OPCION==4 || $OPCION==5 || $OPCION==6) {
        if ($OPCION==4) {
           $cargo= $_GET['cargo'];
           if ($cargo!=null) {
                $filtro= "codCargo='$cargo'";
           }else{
                $mensaje_busqueda="Por favor Seleccione en el Listado un Cargo de acuerdo con el Perfil.";
           }
        }else{
            if ($OPCION==5) {
                $estado= $_GET['estado'];
                if ($estado!=null) {
                     $filtro= "estado='$estado'";
                }else{
                     $mensaje_busqueda="Por favor Seleccione en el Listado un Estado.";
                }
            }else{
                if ($OPCION==6) {
                    $filtro=null;
                }
            }
        }
    }else{
        $TEXTO=$_GET['texto'];
        if ($TEXTO!=null) {               
                //validamos filtros
            if ($OPCION==1){
                $filtro= "cast(cedula as varchar(999999)) like '$TEXTO%'";
            }else{
               if ($OPCION==2) {
                   $palabras=str_word_count($TEXTO);
                   if ($palabras==1) {
                        $filtro= "primerNombre like '$TEXTO%'";
                   }else{
                       if ($palabras==2) {  
                            list($p_nombre, $s_nombre) = explode(" ", $TEXTO);
                            $filtro= "primerNombre like '$p_nombre%' and segundoNombre like '$s_nombre%'";
                       }
                   }
                }else{
                    if ($OPCION==3) {
                        $palabras=str_word_count($TEXTO);
                        if ($palabras==1) {
                             $filtro= "primerApellido like '$TEXTO%'";
                        }else{
                            if ($palabras==2) {  
                                list($p_apellido,$s_apellido) = explode(" ", $TEXTO);
                                $filtro= "primerApellido like '$p_apellido%' and segundoApellido like '$s_apellido%'";
                            }else{
                                if ($palabras>2) {
                                    $filtro=null;
                                }
                            }
                        }
                    }
                }
            }
        }else {
           $filtro=null;
        }
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
    // banner
     $diseño_predeterminado = getListaDiseño_Reporte();
for ($i = 0; $i < count($diseño_predeterminado); $i++) {
    $datos = $diseño_predeterminado[$i];   
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
    $this->Cell(100, 8, 'LISTADO DE EMPLEADOS', 0);
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
$pdf->Cell(40, 8,'CEDULA', 1);
$pdf->Cell(45, 8,'NOMBRES', 1);
$pdf->Cell(45, 8,'APELLIDOS', 1);
$pdf->Cell(40, 8,'FECHA INGRESO', 1);
$pdf->Cell(40, 8,'FECHA SALIDA', 1);
$pdf->Cell(40, 8,'CONTACTO', 1);
$pdf->Cell(20, 8,'ESTADO', 1);
$pdf->Ln(8);
    
$personas = getListaPersona ($filtro);
for ($i = 0; $i < count($personas); $i++) {
    $persona = $personas[$i];
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(5, 8, $i+1, 1); 
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 8, utf8_decode($persona['cedula']), 1);
    $pdf->Cell(45, 8, utf8_decode($persona['primernombre'])." ". utf8_decode($persona['segundonombre']), 1);
    $pdf->Cell(45, 8, utf8_decode($persona['primerapellido'])." ".  utf8_decode($persona['segundoapellido']), 1);
    $fechaingreso=date("d-m-Y",strtotime($persona['fechaingreso'])); 
    $pdf->Cell(40, 8, utf8_decode($fechaingreso), 1);
    $fechasalida=date("d-m-Y",strtotime($persona['fechasalida'])); 
    $pdf->Cell(40, 8, utf8_decode($fechasalida), 1);
    $pdf->Cell(40, 8, utf8_decode($persona['telefono']), 1);
    $pdf->Cell(20, 8, utf8_decode(Estado($persona['estado'])), 1);
    $pdf->Ln(8);
}
            

$pdf->Output();


?>

