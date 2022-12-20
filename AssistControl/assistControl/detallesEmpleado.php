<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Pais_A.php';
require_once 'assistControl/clases/Departamento_A.php';
require_once 'assistControl/clases/Ciudad_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Situacion.php';
require_once 'assistControl/clases/GrupoSanguineo.php';
require_once 'assistControl/clases/Genero.php';
require_once 'assistControl/clases/AreaEnsenanza.php';
require_once 'assistControl/clases/Vinculacion.php';
require_once 'assistControl/clases/Estado.php';

$filtro=  'cedula='.$_GET['cedula'];
$lista='';
$detalles = Persona_A::getListaEnObjetos($filtro, null);
for ($i = 0; $i < count($detalles); $i++) {
    $persona = $detalles[$i];
        $estado=$persona->getEstadoEnLetras()->getNombre();
        if ($estado=='Inactivo') {
            $lista.= "<div class='colorear rojo'><center><img  src='assistControl/fotos/{$persona->getFoto()}' width='114' height='152'/></center></div><br>";
        }else{
            $lista.= "<center><img  src='assistControl/fotos/{$persona->getFoto()}' width='114' height='152'/></center><br>";
        }
        $lista.="<tr><th>Nombre Completo:</th><td>{$persona->getPrimerNombre()}"." "."{$persona->getSegundoNombre()}"." ". "{$persona->getPrimerApellido()}". " "."{$persona->getSegundoApellido()}</td></tr>";
        $lista.="<tr><th>C&eacute;dula Ciudania:</th><td>{$persona->getCedula()}</td></tr>";
        $fechaexpedicion=date("d-m-Y",strtotime($persona->getFechaExpedicion())); 
        $lista.="<tr><th>Fecha de Expedici&oacute;n:</th><td>{$fechaexpedicion}</td></tr>";
        $lista.="<tr><th>Lugar de Expedici&oacute;n:</th><td>{$persona->getLugarExpedicion()}</td></tr>";
        $fechanacimiento=date("d-m-Y",strtotime($persona->getFechaExpedicion())); 
        $lista.="<tr><th>Fecha de Nacimiento:</th><td>{$fechanacimiento}</td></tr>";
        $lista.="<tr><th>Grupo Sangu&iacute;neo: </th><td>{$persona->getGrupoSanguineoEnLetras()->getNombre()}</td></tr>";
        $lista.="<tr><th>Genero:</th><td>{$persona->getGeneroEnLetras()->getNombre()}</td></tr>";
        $lista.="<tr><th>Pa&iacute;s Nacimiento:</th><td>{$persona->getCiudad()->getDepartamento()->getPais()->getNombre()}</td></tr>";
        $lista.="<tr><th>Departamento Nacimiento: </th><td>{$persona->getCiudad()->getDepartamento()->getNombre()}</td></tr>";
        $lista.="<tr><th>Ciudad Nacimiento:</th><td>{$persona->getCiudad()->getNombre()}</td></tr>";
        $lista.="<tr><th>Direcci&oacute;n de Residencia:</th><td>{$persona->getDireccionResidencia()}</td></tr>";
        $lista.="<tr><th>Tel&eacute;fono o Celular:</th><td>{$persona->getTelefono()}</td></tr>";
        $lista.="<tr><th>Email:</th><td>{$persona->getEmail()}</td></tr>";
        $lista.="<tr><th>Perfil:</th><td>{$persona->getCargo()->getPerfil()->getNombre()}</td></tr>";
        $lista.="<tr><th>Cargo:</th><td>{$persona->getCargo()->getNombre()}</td></tr>";
        $lista.="<tr><th>Tipo Vinculaci&oacute;n:</th><td>{$persona->getTipoVinculacion()->getNombre()}</td></tr>";
        $lista.="<tr><th>Area de Ense&ntilde;anza:</th><td>{$persona->getAreaEnsenanza()->getNombre()}</td></tr>";
        $lista.="<tr><th>Profesi&oacute;n:</th><td>{$persona->getProfesion()}</td></tr>";
        $lista.="<tr><th>Situaci&oacute;n:</th><td>{$persona->getSituacion()->getNombre()}</td></tr>";
        $lista.="<tr><th>Estado:</th><td>{$persona->getEstadoEnLetras()->getNombre()}</td></tr>";
        $fechaingreso=date("d-m-Y",strtotime($persona->getFechaIngreso())); 
        $lista.="<tr><th>Fecha de Ingreso:</th><td>{$fechaingreso}</td></tr>";
        $fechasalida=date("d-m-Y",strtotime($persona->getFechaSalida())); 
        $lista.="<tr><th>Fecha de Salida:</th><td>{$fechasalida}</td></tr>";
        $link="<a target='_blank'  href='assistControl/reportes/informacion_del_empleado_excel.php?cedula={$persona->getCedula()}'>";
        $link2="<a target='_blank'  href='assistControl/reportes/informacion_del_empleado_word.php?cedula={$persona->getCedula()}'>";
        $link3="<a target='_blank'  href='assistControl/reportes/informacion_del_empleado_pdf.php?cedula={$persona->getCedula()}'>";
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
    <h3>DETALLES DEL EMPLEADO</h3><br/><br/>
    <b>Exportar en:</b>&nbsp;&nbsp;&nbsp;<?=$link?><img src="presentacion/imagenes/AssitControl/excel.png " width="40" height="40" title="Documento EXCEL"/></a>&nbsp;&nbsp;&nbsp;<?=$link2?><img src="presentacion/imagenes/AssitControl/word.png " width="40" height="40" title="Documento WORD"/></a>&nbsp;&nbsp;&nbsp;<?=$link3?><img src="presentacion/imagenes/AssitControl/pdf.png " width="40" height="40" title="Documento PDF"/></a>
<br><br><br>
<table>
     <?=$lista?>
</table>
<br><br>
    <a href="principal.php?CONTENIDO=assistControl/empleados.php"><button type="button" class="botones">Atr&aacute;s</button></a>
</center>
