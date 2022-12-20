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
header('Content-Type: text/html; charset=UTF-8');

if (isset($_GET['cedula'])){
    $accion='Modificar';
    $persona=new Persona_A('cedula', $_GET['cedula']);
    $disabled= "disabled";
    $imagen="<img src='assistControl/fotos/{$persona->getFoto()}' width='60' height='75'/><br>";
    $cambiarfoto= "<b>Cambiar Foto:</b>";
    $required="";
    $estado_predeterminado= boolval($persona->getEstado());
    $genero_predeterminado= boolval($persona->getGenero());
    $pais=$persona->getCiudad()->getDepartamento()->getCodPais();
    $departamento=$persona->getCiudad()->getDepartamento()->getCodigo();
    $ciudad=$persona->getCodCiudad();
    $perfil=$persona->getCargo()->getCodPerfil();
    $cargo=$persona->getCodCargo();
    $vinculacion=$persona->getCodTipoVinculacion();
    $areaenseñanza=$persona->getCodAreaEnsenanza();
    $situacion=$persona->getCodSituacion();
}else {
    $accion='Adicionar';
    $persona=new Persona_A(null, null);
    $disabled="";
    $imagen="";
    $cambiarfoto="";
    $required="required";
    $estado_predeterminado="";
    $genero_predeterminado="";
    $pais="";
    $ciudad="";
    $departamento="";
    $perfil="";
    $cargo="";
    $vinculacion="";
    $areaenseñanza="";
    $situacion="";
}    
?>

<script type="text/javascript">
<?= Departamento_A::getListaEnArregloJS()?>
function cargarDepartamentos(codPais){
    window.document.formulario.codDepartamento.options.length=0;
    for (var i = 0; i < departamentos.length; i++) {
        if (departamentos[i][2]==codPais){
            window.document.formulario.codDepartamento.options.length=i+1;
            window.document.formulario.codDepartamento.options[i].value=departamentos[i][0];
            window.document.formulario.codDepartamento.options[i].text=departamentos[i][1];            
        }
    }
    cargarCiudades(departamentos[0][0]);
}
<?= Ciudad_A::getListaEnArregloJS()?>
function cargarCiudades(codDepartamento){
    window.document.formulario.codCiudad.options.length=0;
    for (var i = 0; i < ciudades.length; i++) {
           if (ciudades[i][2]==codDepartamento){
            window.document.formulario.codCiudad.options.length=i+1;
            window.document.formulario.codCiudad.options[i].value=ciudades[i][0];
            window.document.formulario.codCiudad.options[i].text=ciudades[i][1];            
        }
    }
}


<?= Cargo::getListaEnArregloJS()?>
function cargarCargos(codPerfil){
    window.document.formulario.codCargo.options.length=0;
    for (var i = 0; i < cargos.length; i++) {
        if (cargos[i][2]==codPerfil){
            window.document.formulario.codCargo.options.length=i+1;
            window.document.formulario.codCargo.options[i].value=cargos[i][0];
            window.document.formulario.codCargo.options[i].text=cargos[i][1];            
        }
    }
}


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




<h3><?=strtoupper($accion)?> EMPLEADO</h3>
<form name="formulario"  method="post" action="principal.php?CONTENIDO=assistControl/empleadosActualizar.php" enctype="multipart/form-data" onsubmit="return validar(this)">
<table border="0">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$imagen?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$cambiarfoto?>
    <div id="msg" style="color:red; font-weight:bold;font-size:14px;"></div>
    <tr><th>Foto:</th><td><input type="file" name="imagen"  value='<?=$persona->getFoto()?>' accept="image/*" <?=$required?>/></td></tr>
        <tr><th>C&eacute;dula Ciudania (*):</th><td><input type="number" name="cedula" value="<?=$persona->getCedula()?>" <?=$disabled?> required/></td></tr>
        <tr><th>Fecha de Expedici&oacute;n (*):</th><td><input type="date" name="fechaExpedicion" value='<?=$persona->getFechaExpedicion()?>' required/></td></tr>
        <tr><th>Lugar de Expedici&oacute;n (*):</th><td><input type="text" name="lugarExpedicion" value='<?=$persona->getLugarExpedicion()?>'/></td></tr>
        <tr><th>Fecha de Nacimiento:</th><td><input type="date" name="fechaNacimiento" value='<?=$persona->getFechaNacimiento()?>' required/></td></tr>
        <tr><th>Grupo Sangu&iacute;neo (*): </th><td><select name="grupoSanguineo" required><?= GrupoSanguineo::getListaEnOptions($persona->getGrupoSanguineo())?></select></td></tr>    
        <tr><th>Primer Nombre (*):</th><td><input type="text" name="primerNombre" value='<?=$persona->getPrimerNombre()?>' required/></td></tr>
        <tr><th>Segundo Nombre:</th><td><input type="text" name="segundoNombre" value='<?=$persona->getSegundoNombre()?>'/></td></tr>
        <tr><th>Primer Apellido (*):</th><td><input type="text" name="primerApellido" value='<?=$persona->getPrimerApellido()?>' required/></td></tr>
        <tr><th>Segundo Apellido:</th><td><input type="text" name="segundoApellido" value='<?=$persona->getSegundoApellido()?>'/></td></tr>
        <tr><th>Genero (*):</th><td><select name="genero"><?= Genero::getListaEnOptions($genero_predeterminado)?></select></td></tr>
        <tr><th>Pais Nacimiento:</th><td><select name="codPais" onchange="cargarDepartamentos(this.value);"><option value="0">Escoja</option> <?= Pais_A::getListaEnOptions($pais)?></select></td></tr>
        <tr><th>Departamento Nacimiento: </th><td><select name="codDepartamento" onchange="cargarCiudades(this.value);"><option value="0">Escoja</option> <?= Departamento_A::getListaEnOptions($departamento)?></select></td></tr>
        <tr><th>Ciudad Nacimiento:</th><td><select name="codCiudad" required><option value="0">Escoja</option> <?= Ciudad_A::getListaEnOptions($ciudad)?></select></td></tr>
        <tr><th>Direcci&oacute;n de Residencia:</th><td><input type="text" name="direccion" value='<?=$persona->getDireccionResidencia()?>' size="35"/></td></tr>
        <tr><th>Tel&eacute;fono o Celular:</th><td><input type="number" name="telefono" value="<?=$persona->getTelefono()?>"/></td></tr>
        <tr><th>Email:</th><td><input type="email" name="correo" value="<?=$persona->getEmail()?>" size="35"/></td></tr>                 
        <tr><th>Perfil:</th><td><select name="codPerfil" onchange="cargarCargos(this.value);"><option value="0">Escoja</option> <?= Perfil_A::getListaEnOptions($perfil)?></select></td></tr>
        <tr><th>Cargo:</th><td><select name="codCargo" required><option value="0">Escoja</option> <?= Cargo::getListaEnOptions($cargo)?></select></select></td></tr>
        <tr><th>Tipo Vinculaci&oacute;n:</th><td><select name="codTipoVinculacion"><?= Vinculacion::getListaEnOptions($vinculacion)?></select></td></tr>
        <tr><th>Area de Ense&ntilde;anza:</th><td><select name="codAreaEnsenanza"><?= AreaEnsenanza::getListaEnOptions($areaenseñanza)?></select></td></tr>
        <tr><th>Profesi&oacute;n:</th><td><input type="text" name="profesion" value='<?=$persona->getProfesion()?>'/></td></tr>
        <tr><th>Situaci&oacute;n:</th><td><select name="codSituacion"><?= Situacion::getListaEnOptions($situacion)?></select></td></tr>
        <tr><th>Estado:</th><td><select name="estado"><?= Estado::getListaEnOptions($estado_predeterminado)?></select></td></tr>
        <tr><th>Fecha de Ingreso:</th><td><input type="date" name="fechaIngreso" value='<?=$persona->getFechaIngreso() ?>' required/></td></tr>
        <tr><th>Fecha de Salida:</th><td><input type="date" name="fechaSalida" value='<?=$persona->getFechaSalida()?>' required/></td></tr>
</table>
        <input type="hidden" name="cedulaanterior" value="<?=$persona->getCedula()?>"/>
        <input type="hidden" name="imagenanterior" value="<?=$persona->getFoto()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    
