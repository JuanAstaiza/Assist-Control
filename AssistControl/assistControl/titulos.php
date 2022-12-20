<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Estado.php';
require_once 'assistControl/clases/Titulo.php';
require_once 'assistControl/clases/NivelEducativo.php';


$listaempleado = '';
$listatitulo = '';
$filtro_persona=  'cedula ='.$_GET['cedula'];
$empleado = Persona_A::getListaEnObjetos($filtro_persona, null);
for ($i = 0; $i < count($empleado); $i++) {
    $objeto = $empleado[$i];
        $estado= $objeto->getEstadoEnLetras()->getNombre();
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
        $listatitulo.= "<th><a href='principal.php?CONTENIDO=assistControl/titulosFormulario.php&cedula={$objeto->getCedula()}' title='Adicionar'><img src='presentacion/imagenes/AssitControl/adicionar.png'/></a></th>";
    }
    $link="<a target='_blank'  href='assistControl/reportes/listado_especialidades_excel.php?cedula={$objeto->getCedula()}'>";
    $link2="<a target='_blank'  href='assistControl/reportes/listado_especialidades_word.php?cedula={$objeto->getCedula()}'>";
    $link3="<a target='_blank'  href='assistControl/reportes/listado_especialidades_pdf.php?cedula={$objeto->getCedula()}'>";
}
$lista = '';
$filtro_turno='cedulaPersona ='.$_GET['cedula'];
$titulos = Titulo::getListaEnObjetos($filtro_turno);
for ($i = 0; $i < count($titulos); $i++) {
    $titulo = $titulos[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$titulo->getNivelEducativoEnLetras()->getNombre()}</td>";
    $lista.= "<td>{$titulo->getNombre()}</td>";
        $filtro_persona=  'cedula ='.$_GET['cedula'];
    $empleado_ = Persona_A::getListaEnObjetos($filtro_persona, null);
    for ($j = 0; $j < count($empleado_); $j++) {
        $objeto = $empleado_[$j];
        $estado= $objeto->getEstadoEnLetras()->getNombre();
        if ($estado=='Activo') {
            $lista.= '<td>';
            $lista.= "<a href='principal.php?CONTENIDO=assistControl/titulosFormulario.php&cedula={$titulo->getCedulaPersona()}&codigo={$titulo->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
            $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/titulosActualizar.php&cedula={$titulo->getCedulaPersona()}&codigo={$titulo->getCodigo()}'); />";
            $lista.= '</td>';
        }
    }
    $lista.= '</tr>';

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
</style>
<center>
    <br/><br/>
        <h3>LISTA DE ESPECIALIDADES</h3>
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
        <tr><th>Tipo del T&iacute;tulo</th><th>Nombre del T&iacute;tulo</th>
        <?=$listatitulo?></tr>
        <?=$lista?>
    </table>
    <br><br>
        <a href="principal.php?CONTENIDO=assistControl/empleados.php"><button type="button" class="botones">Atr&aacute;s</button></a>

</center>
