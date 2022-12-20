<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Permiso.php';
require_once 'assistControl/clases/Motivo.php';
require_once 'assistControl/clases/Estado.php';
$lista = '';

$filtro_permiso=  'codigo ='.$_GET['codigo'];
$pemisos = Permiso::getListaEnObjetos($filtro_permiso, null);
for ($i = 0; $i < count($pemisos); $i++) {
    $permiso = $pemisos[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$permiso->getFechaSolicitud()}</td>";
    $lista.= "<td>{$permiso->getFechaInicio()}</td>";
    $lista.= "<td>{$permiso->getFechaFin()}</td>";
    $lista.= "<td>{$permiso->getMotivo()->getNombre()}</td>";
    $lista.="<td><a target='_blank' href='assistControl/archivos/{$permiso->getAnexo()}'><img src='presentacion/imagenes/AssitControl/anexo.png' width='40' height='40' title='Archivo'/></a></td>";
    $lista.= '</tr>';
    $listadescripcion= "<td><textarea rows='10' cols='85' wrap='soft' readonly>{$permiso->getDescripcion()}</textarea></td>";

}
$listaempleado = '';
$listaturno = '';
$filtro_persona=  'cedula ='.$_GET['cedula'];
$empleado = Persona_A::getListaEnObjetos($filtro_persona, null);
for ($i = 0; $i < count($empleado); $i++) {
    $objeto = $empleado[$i];
    $listaempleado.= '<tr>';
    $listaempleado.= "<td>{$objeto->getCedula()}</td>";
    $listaempleado.= "<td><img src='assistControl/fotos/{$objeto->getFoto()}' width='60' height='75'/></td>";
    $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
    $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
    $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
    $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
    $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
    $listaempleado.= '</tr>';
}
?>

<center>
    <br/><br/>
        <h3>DETALLE DEL PERMISO</h3>
    <br><br><br>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Foto</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table>
    <br><br><br>
    <table border="0">
        <tr><th>Fecha Solicitud</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Motivo</th><th>Anexo</th></tr>
        <?=$lista?>
    </table>
    <br><br><br>
    <table border="0">
        <tr><th>Descripcion</th>
        <?=$listadescripcion?>
    </table>
    <br><br>
    <a href="principal.php?CONTENIDO=assistControl/permisos.php"><button type="button" class="botones">Atr&aacute;s</button></a>
</center>
