<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../clases/Conector.php';
require('../../lib/fpdf181/fpdf.php');
date_default_timezone_set('America/Bogota');

    function getListaDise�o_Reporte() {
        $BD='assistcontrol'; $P='lemo_';
        $cadenaSQL = "select codigo,img_banner, direccion_sede, pagina_web, telefono, email from {$P}reporte_pdf;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }

class PDF extends FPDF
{
// Cabecera de p�gina
function Header()
{
 $dise�o_predeterminado = getListaDise�o_Reporte();
for ($i = 0; $i < count($dise�o_predeterminado); $i++) {
    $datos = $dise�o_predeterminado[$i];   
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
    $this->Cell(100, 8, '', 0);
    // Salto de l�nea
    $this->Ln(20);
}

//Pie de p�gina

function Footer()
{
 $dise�o_predeterminado = getListaDise�o_Reporte();
for ($i = 0; $i < count($dise�o_predeterminado); $i++) {
    $datos = $dise�o_predeterminado[$i];   
    $this->SetY(195);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,7,"Sede Central: {$datos['direccion_sede']}  Tel�fonos: {$datos['telefono']}",'T',0,'C');
    $this->SetY(198);
    $this->Cell(0,7,"P�gina Web: {$datos['pagina_web']}   Email: {$datos['email']}",'',0,'C');
    $this->SetY(199.5);
    $this->Cell(0,9.5,"Pasto / Nari�o / Colombia",'',0,'C');
}
    $this->SetY(197);
    $this->SetX(15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'P�gina '.$this->PageNo().'/{nb}',0,0,'');
    $this->Image('img/incotec.png',267,197,15);
    $this->SetY(193);
    $this->SetX(273);
    $this->Cell(0,9.5,'SC-CER433946',0,0,'');
}
}

// Creaci�n del objeto de la clase heredada
$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
           

$pdf->Output();


?>

