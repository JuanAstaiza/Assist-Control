<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'admon/clases/EstadoUsuario.php';
$chkEstado='checked';
if (isset($_GET['usuario'])){
    $accion='Modificar';
    $usuario=new Usuario('usuario', $_GET['usuario']);
    if (!$usuario->getEstado()) $chkEstado='';
    $roUsuario='readonly';
    $fechainiciacion=substr($usuario->getFechaIniciacion(), 0, 10);
    $fechafinalizacion=substr($usuario->getFechaFinalizacion(), 0, 10);
    $empresa=$usuario->getIdEmpresa();
    $perfil=$usuario->getIdPerfil();
} else {
    $accion='Adicionar';
    $usuario=new Usuario(null, null);
    $roUsuario='';
    $usuario->setFechaIniciacion(date('Y-m-d'));
    $fechainiciacion='';
    $fechafinalizacion='';
    $empresa='';
    $perfil='';
}
?>

<h3><?=strtoupper($accion)?> USUARIO</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/usuariosActualizar.php">
<table border="0">
    <tr><th>Nombres (*):</th><td><input type="text" name="nombres" maxlength="50" size="50" value='<?=$usuario->getNombres()?>' /></td></tr>
    <tr><th>Apellidos (*):</th><td><input type="text" name="apellidos" maxlength="50" size="50" value='<?=$usuario->getApellidos()?>' /></td></tr>
    <tr><th>Tel&eacute;fono: </th><td><input type="number" name="telefono" maxlength="20" size="20" value='<?=$usuario->getTelefono()?>' /></td></tr>
    <tr><th>Correo electr&oacute;nico: </th><td><input type="email" name="email" maxlength="100" size="50" value='<?=$usuario->getEmail()?>' /></td></tr>
    <tr><th>Fecha de nacimiento: </th><td><input type="date" name="fechaNacimiento" value='<?=$usuario->getFechaNacimiento()?>' /></td></tr>
    <tr><th>Empresa (*):</th><td><select name="idEmpresa"><?=Empresa::getListaEnOptions($empresa)?></select></td></tr>
    <tr><th>Perfil (*):</th><td><select name="idPerfil"><?=Perfil::getListaEnOptions($perfil)?></select></td></tr>    
    <tr><th>Usuario (*):</th><td><input type="text" name="usuario" maxlength="20" size="20" value='<?=$usuario->getUsuario()?>' <?=$roUsuario?> required/></td></tr>
    <tr><th>Contrase&ntilde;a (*):</th><td><input type="password" name="clave" maxlength="35" size="20" value='<?=$usuario->getClave()?>' required/></td></tr>   
    <tr><th>Estado: </th><td><input type="checkbox" name="estado" <?=$chkEstado?> /> Activo</td></tr>
    <tr><th>Fecha de iniciaci&oacute;n (*):</th><td><input type="date" name="fechaIniciacion" value='<?=$fechainiciacion?>' /></td></tr>
    <tr><th>Fecha de finalizaci&oacute;n: </th><td><input type="date" name="fechaFinalizacion" value='<?=$fechafinalizacion?>' /></td></tr>
</table>
    <input type="hidden" name="usuarioAnterior" value="<?=$usuario->getUsuario()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    