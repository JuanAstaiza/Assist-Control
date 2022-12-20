<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Turno.php';
require_once 'assistControl/clases/Estado.php';
$lista = '';
       
$filtro_turno=  'cedulaPersona ='.$_GET['cedula'];
$turnos = Turno::getListaEnObjetos($filtro_turno);
for ($i = 0; $i < count($turnos); $i++) {
    $turno = $turnos[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$turno->getHoraInicio()}" . '-'. "{$turno->getHoraFin()}</td>";
    $lista.= "<td>{$turno->getDiaEnLetras()}</td>";
    $lista.= "<td><textarea rows='3' cols='85' wrap='soft' readonly>{$turno->getDescripcion()}</textarea></td>";
    $filtro_persona=  'cedula ='.$_GET['cedula'];
    $empleado_ = Persona_A::getListaEnObjetos($filtro_persona, null);
for ($j = 0; $j < count($empleado_); $j++) {
    $objeto = $empleado_[$j];
    $estado= $objeto->getEstadoEnLetras()->getNombre();
    if ($estado=='Activo') {
        $lista.= '<td>';
        $lista.= "<a href='principal.php?CONTENIDO=assistControl/turnosFormulario.php&cedula={$turno->getCedulaPersona()}&codigo={$turno->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
        $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/turnosActualizar.php&cedula={$turno->getCedulaPersona()}&codigo={$turno->getCodigo()}'); />";
        $lista.= '</td>';
    }
 }
    $lista.= '</tr>';
}
$listaempleado = '';
$listaturno = '';
$filtro_persona=  'cedula ='.$_GET['cedula'];
$empleado = Persona_A::getListaEnObjetos($filtro_persona, null);
for ($i = 0; $i < count($empleado); $i++) {
    $objeto = $empleado[$i];
       $estado=$objeto->getEstadoEnLetras()->getNombre();
    if ($estado=='Inactivo') {
        $listaempleado.= '<tr bgcolor="#FE2E2E">';
        $listaempleado.= "<td>{$objeto->getCedula()}</td>";
        $listaempleado.= "<td><div class='colorear rojo'><img src='assistControl/fotos/{$objeto->getFoto()}' width='60' height='75'/></div></td>";
        $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
        $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
        $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
        $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
        $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
        $listaempleado.= '</tr>';
    }else{
        $listaempleado.= '<tr>';
        $listaempleado.= "<td>{$objeto->getCedula()}</td>";
        $listaempleado.= "<td><img src='assistControl/fotos/{$objeto->getFoto()}' width='60' height='75'/></td>";
        $listaempleado.= "<td>{$objeto->getPrimerNombre()}" . " " ."{$objeto->getSegundoNombre()}</td>";
        $listaempleado.= "<td>{$objeto->getPrimerApellido()}" . " " ."{$objeto->getSegundoApellido()}</td>";
        $listaempleado.= "<td>{$objeto->getCargo()->getPerfil()->getNombre()}</td>";
        $listaempleado.= "<td>{$objeto->getCargo()->getNombre()}</td>";
        $listaempleado.= "<td>{$objeto->getEstadoEnLetras()->getNombre()}</td>";
        $listaempleado.= '</tr>';
        $listaturno.= "<th><a href='principal.php?CONTENIDO=assistControl/turnosFormulario.php&cedula={$objeto->getCedula()}' title='Adicionar'><img src='presentacion/imagenes/AssitControl/adicionar.png'/></a></th>";
        
    }
    $link="<a target='_blank'  href='assistControl/reportes/turnos_del_empleado_excel.php?cedula={$objeto->getCedula()}'>";
    $link2="<a target='_blank'  href='assistControl/reportes/turnos_del_empleado_word.php?cedula={$objeto->getCedula()}'>";
    $link3="<a target='_blank'  href='assistControl/reportes/turnos_del_empleado_pdf.php?cedula={$objeto->getCedula()}'>";

}
?>
<style type="text/css">
    .colorear {
position: relative;
/* Estas dos propiedades solo sirven para centrar */
display: table;
margin:0 auto;
}
/* Y esta para evitar el margin automatico de Blogger en los enlaces */
.colorear a {
margin: 0 !important;
}
.colorear:before, 
.separator:before {
content: "";
display: block;
position: absolute;
/* Todas las posiciones a cero */
top: 0;
bottom: 0;
left: 0;
right: 0;
background: rgba(255,102,0, 0.5); /*Sepia*/
}
.colorear:hover:before {
background: none;
}
.rojo:before {
background: rgba(255,0,0, 0.5);
}
</style>
<center>
    <br/><br/>
        <h3>LISTA DE TURNOS</h3>
    <br><br><br>
     <b>Exportar en:</b>&nbsp;&nbsp;&nbsp;<?=$link?><img src="presentacion/imagenes/AssitControl/excel.png " width="40" height="40" title="Documento EXCEL"/></a>&nbsp;&nbsp;&nbsp;<?=$link2?><img src="presentacion/imagenes/AssitControl/word.png " width="40" height="40" title="Documento WORD"/></a>&nbsp;&nbsp;&nbsp;<?=$link3?><img src="presentacion/imagenes/AssitControl/pdf.png " width="40" height="40" title="Documento PDF"/></a>
<br><br> 
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Foto</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table>
    <br><br><br>
    <table border="0">
        <tr><th>HORA (Inicio/Fin)</th><th>Dia</th><th>Descripci&oacute;n</th>
        <?=$listaturno?></tr>
        <?=$lista?>
    </table>
    <br><br>
    <a href="principal.php?CONTENIDO=assistControl/empleados.php"><button type="button" class="botones">Atr&aacute;s</button></a>
</center>
