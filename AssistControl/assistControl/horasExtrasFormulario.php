<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/HoraExtra.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Estado.php';

$listaempleado="";
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


if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $horaextra = new HoraExtra('codigo', $_GET['codigo']);
} else {
    $accion = 'Adicionar';
    $horaextra = new HoraExtra(null, null);
}
?>
<center>
    <br/><br/>
    <h3><?=strtoupper($accion)?> HORA EXTRA</h3>
    <br><br><br>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Foto</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table><br><br>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/horasExtrasActualizar.php&cedula='<?=$_GET['cedula']?>'">
        <table>
            <tr><th>Fecha Inicio(*):</th><th><input type="date" name="FechaInicio" value='<?=$horaextra->getFechaInicio()?>' required/></th><th>Hora Inicio(*):</th><th><input type="time" name="HoraInicio" value='<?=$horaextra->getHoraInicio()?>' required/></th></tr>
        <tr><th>Fecha Fin(*):</th><th><input type="date" name="FechaFin" value='<?=$horaextra->getFechaFin()?>' required/></th><th>Hora Fin(*):</th><th><input type="time" name="HoraFin" value='<?=$horaextra->getHoraFin()?>' required/></th></tr>
        </table>       
        <table>            
            <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" rows="10" cols="40" maxlength="2500"><?=$horaextra->getDescripcion()?></textarea></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$horaextra->getCodigo()?>"/>
        <input type="hidden" name="cedula" value="<?=$_GET['cedula']?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>



