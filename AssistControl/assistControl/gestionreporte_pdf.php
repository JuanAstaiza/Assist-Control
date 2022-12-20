<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'assistControl/clases/Reporte_pdf.php';

$lista = '';
$modificar_diseño='';
$listaencabezado='';
$reporte_pdf = Reporte_pdf::getListaEnObjetos(null);
for ($i = 0; $i < count($reporte_pdf); $i++) {
    $datos = $reporte_pdf[$i];
        $listaencabezado = "<td><img src='assistControl/reportes/img/{$datos->getImg_banner()}' width='750' height='100'/></td>";
        $lista.= "<td>{$datos->getDireccion_sede()}</td>";
        $lista.= "<td>{$datos->getPagina_web()}</td>";
        $lista.= "<td>{$datos->getTelefono()}</td>";
        $lista.= "<td>{$datos->getEmail()}</td>";
        $modificar_diseño= "<a href='principal.php?CONTENIDO=assistControl/gestionreporte_pdf_Formulario.php&codigo={$datos->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
}
$link="<a target='_blank'  href='assistControl/reportes/diseno_pdf.php'>";
?>
<h3>DISE&Ntilde;O DEL REPORTE PDF</h3><br/><br/>
<table border="1">
    <tr><th>ENCABEZADO</th></tr>
    <tr><?=$listaencabezado?></tr>
</table>
<br><br>
<table>
    <tr><th colspan="4">PIE DE PAGINA</th></tr>
    <tr><th>Direcci&oacute;n</th><th>P&aacute;gina Web</th><th>Tel&eacute;fono</th><th>Email</th></tr>
    <tr><?=$lista?></tr>
</table>
<br>
<?=$modificar_diseño?>&nbsp;&nbsp;&nbsp;
<?=$link?><img src="assistControl/reportes/img/vista_previa.png " width="40" height="40" title="Ver Vista Previa"/></a>

