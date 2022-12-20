<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Titulo.php';
require_once 'assistControl/clases/NivelEducativo.php';
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
    $titulo = new Titulo('codigo', $_GET['codigo']);
    $niveleseducativos=$titulo->getCodnivelEducativo();
} else {
    $accion = 'Adicionar';
    $titulo = new Titulo(null, null);
    $niveleseducativos="";
 }
?>
<center>
    <br/><br/>
    <h3><?=strtoupper($accion)?> ESPECIALIDAD</h3>
    <br><br><br>
    <table border="1">
    <tr>
        <th>C&eacute;dula</th><th>Foto</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
    </tr>
    <?=$listaempleado?>
    </table><br><br>
    <form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/titulosActualizar.php&cedula='<?=$_GET['cedula']?>'">
        <table>
            <tr><th>Tipo del T&iacute;tulo:</th><td><select name="codNivelEducativo" required><?= NivelEducativo::getListaEnOptions($niveleseducativos)?></select></td></tr>
            <tr><th>Nombre del T&iacute;tulo:</th><td><input type="text" name="nombre" value='<?=$titulo->getNombre()?>' size="60" required/></td></tr>
          </table>         
        <input type="hidden" name="codigo" value="<?=$titulo->getCodigo()?>"/>
        <input type="hidden" name="cedula" value="<?=$_GET['cedula']?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>



