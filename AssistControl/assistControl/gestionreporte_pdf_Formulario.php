<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'assistControl/clases/Reporte_pdf.php';

if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $reporte = new Reporte_pdf('codigo', $_GET['codigo']);
$listaencabezado='';
$reporte_pdf = Reporte_pdf::getListaEnObjetos(null);
for ($i = 0; $i < count($reporte_pdf); $i++) {
    $datos = $reporte_pdf[$i];
        $listaencabezado = "<td><img src='assistControl/reportes/img/{$datos->getImg_banner()}' width='750' height='100'/></td>";
}
}
?>
<script type="text/javascript">
function validar(){
    var OK = true;
    var frm = document.forms["formulario"];
    var f = frm.elements["imagen"];
    if (f.value==="") {
         OK = true; 
    }else{
        if( !f.value.match(/.(jpg)|(png)$/) ){
            document.getElementById("msg").innerHTML = "Extension debe ser jpg o png.";
            OK = false;
        }
    }
    return OK;
}
</script>


<h3><?=strtoupper($accion)?> DISE&Ntilde;O DEL REPORTE PDF</h3>
         <table border="1">
            <tr><th>ENCABEZADO</th></tr>
            <tr><?=$listaencabezado?></tr>
            <tr><td><center><b>Tama&ntilde;o:</b> 1283 px <b>x</b> 131 px <b>Tipo de Fomato:</b> jpg o png </center></td></tr>
        </table>   
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/gestionreporte_pdf_Actualizar.php" enctype="multipart/form-data" onsubmit="return validar(this)">
         <table>
            <tr><th>Imagen Encabezado:</th><td><input type="file" name="imagen"  value='<?=$datos->getImg_banner()?>' accept="image/*" /></td></tr>
            <tr><th colspan="2"><center>PIE DE PAGINA:</center></th></tr>
            <tr><th colspan="2"></th></tr>
            <tr><th>Direcci&oacute;n de la Sede Central:</th><td><input type="text" name="direccion" value='<?=$datos->getDireccion_sede()?>' size="35" required/></td></tr>
            <tr><th>P&aacute;gina Web:</th><td><input type="text" name="paginaweb" value="<?=$datos->getPagina_web()?>" size="35" required/></td></tr>                 
            <tr><th>Tel&eacute;fono:</th><td><input type="text" name="telefono"  value='<?=$datos->getTelefono()?>' size="35" required/></td></tr>
            <tr><th>Email:</th><td><input type="email" name="correo" value="<?=$datos->getEmail()?>" size="35" required/></td></tr>                 
        </table>
        
        <br><br>
        <input type="hidden" name="codigoAnterior" value="<?=$datos->getCodigo()?>"/>
        <input type="hidden" name="imagenanterior" value="<?=$datos->getImg_banner()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>