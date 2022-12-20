<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Turno.php';
require_once 'assistControl/clases/Dia.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Estado.php';

$horainicio="";
$HorFin="";
$dia="";
$descripcion="";
$aviso="";

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
    $bloqueado="";
    $aviso="";
    $accion = 'Modificar';
    $turno = new Turno('codigo', $_GET['codigo']);
    $horainicio=$turno->getHoraInicio();
    $HorFin=$turno->getHoraFin();
    $dia=$turno->getDia();
    $descripcion=$turno->getDescripcion();
} else {
    $accion = 'Adicionar';
    $turno = new Turno(null, null);
    $filtro_turno=  'cedulaPersona ='.$_GET['cedula'];
    $contador=0;
    $bloqueado="";
    $turnos = Turno::getListaEnObjetos($filtro_turno);  
    for ($i = 0; $i < count($turnos); $i++) {
    $turno = $turnos[$i];
        $contador=$contador+1;
        if ($contador==7) {
            $bloqueado="disabled";
            $aviso="<font size=5 color=red> <h2>AVISO:</h2></font> <h4>No puede añadir más Turnos.Ya ha ingresado 7 turnos equivalentes a una Semana.Gracias</h4>";
        }
    }
    $dia=$contador;
}
?>
<center>
    <br/><br/>
    <h3><?=strtoupper($accion)?> TURNO</h3>
    <br><br><br>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Foto</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table><br><br>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/turnosActualizar.php&cedula='<?=$_GET['cedula']?>'">
        <table>
            <tr><th>Hora Inicio(*):</th><td><input type="time" name="HoraInicio" value='<?=$horainicio?>' required <?=$bloqueado?>/></td></tr>
            <tr><th>Hora Fin(*):</th><td><input type="time" name="HoraFin" value='<?=$HorFin?>'required  <?=$bloqueado?>/></td></tr>
            <tr><th>Dia (*):</th><td><select name="dia" <?=$bloqueado?>><?=Dia::getListaEnOptions($accion,$dia)?></select></td></tr>
            <tr><th>Descripci&oacute;n:</th><td><textarea name="descripcion" rows="10" cols="40" maxlength="2500"  <?=$bloqueado?>><?=$descripcion?></textarea></td></tr>
          </table>         
        <input type="hidden" name="codigo" value="<?=$turno->getCodigo()?>"/>
        <input type="hidden" name="cedula" value="<?=$_GET['cedula']?>"/>
        <input type="submit" name="accion" value="<?=$accion?>" <?=$bloqueado?>/>
    </form>
    <?=$aviso?>
</center>



