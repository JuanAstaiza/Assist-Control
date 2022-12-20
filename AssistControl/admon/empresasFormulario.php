<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Pais.php';
require_once 'admon/clases/Departamento.php';
require_once 'admon/clases/Ciudad.php';
require_once 'admon/clases/NivelAuditoria.php';
require_once 'admon/clases/Idioma.php';
require_once 'clases/Archivo.php';
if (isset($_GET['id'])){
    $accion='Modificar';
    $empresa=new Empresa('id', $_GET['id']);
    $roEmpresa='readonly';
    $roPrefijo='readonly';
    $pais=$empresa->getCiudad()->getDepartamento()->getCodPais();
    $departamento=$empresa->getCiudad()->getCodDepartamento();
    $ciudad=$empresa->getCodCiudad();
    $archivo=$empresa->getCss();
    $nivelauditoria=$empresa->getNivelAuditoria();
    $idioma=$empresa->getIdioma();
} else {
    $accion='Adicionar';
    $empresa=new Empresa(null, null);
    $roEmpresa='';
    $roPrefijo='';
    $pais='';
    $departamento='';
    $ciudad='';
    $archivo='';
    $nivelauditoria='';
    $idioma='';
}
?>

<script type="text/javascript">
<?= Departamento::getListaEnArregloJS()?>
<?= Ciudad::getListaEnArregloJS()?>
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
$(document).ready(function(){
    $('#codPais').change(function(){    
         $('#codDepartamento').load('admon/clases/Pais.php',{
            metodo: 'getDepartamentosEnOptions',
            codPais: $('#codPais').val(),
            predeterminado: 0
        });
    });
    $('#codDepartamento').change(function(){    
         $('#codCiudad').load('admon/clases/Departamento.php',{
            metodo: 'getCiudadesEnOptions',
            codDepartamento: $('#codDepartamento').val(),
            predeterminado: 0
        });
    });
});
</script>

<h3><?=strtoupper($accion)?> EMPRESA</h3>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/empresasActualizar.php" onload="">
<table border="0">
    <tr><th>Nit: </th><td><input type="text" name="nit" maxlength="20" size="20" value='<?=$empresa->getNit()?>' /></td></tr>
    <tr><th>Raz&oacute;n social (*):</th><td><input type="text" name="razonSocial" maxlength="100" size="50" value='<?=$empresa->getRazonSocial()?>' required/></td></tr>
    <tr><th>Direcci&oacute;n: </th><td><input type="text" name="direccion" maxlength="100" size="50" value='<?=$empresa->getDireccion()?>' /></td></tr>
    <tr><th>Pais: </th><td><select name="codPais" id="codPais"><?=Pais::getListaEnOptions($pais)?></select></td></tr>
    <tr><th>Departamento: </th><td><select name="codDepartamento" id="codDepartamento"><?= Departamento::getListaEnOptions($departamento, null)?></select></td></tr>
    <tr><th>Ciudad: </th><td><select name="codCiudad" id="codCiudad"><?= Ciudad::getListaEnOptions($ciudad, null)?></select></td></tr>
    <tr><th>Sitio web: </th><td><input type="url" name="url" maxlength="100" size="50" value='<?=$empresa->getUrl()?>' /></td></tr>
    <tr><th>Correo electr&oacute;nico: </th><td><input type="email" name="email" maxlength="100" size="50" value='<?=$empresa->getEmail()?>' /></td></tr>
    <tr><th>CSS: </th><td><select name="css"><?=Archivo::getListaArchivosEnOptions('presentacion/css', 'css', $archivo)?></select></td></tr>
    <tr><th>Base de datos: </th><td><input type="text" name="bd" maxlength="30" size="30" value='<?=$empresa->getBd()?>' <?=$roEmpresa?> required/></td></tr>
    <tr><th>Prefijo base de datos: </th><td><input type="text" name="prefijo" maxlength="30" size="30" value='<?=$empresa->getPrefijo()?>' <?=$roPrefijo?> /></td></tr>
    <tr><th>Nivel de auditoria: </th><td><select name="nivelAuditoria"><?= NivelAuditoria::getListaEnOptions($nivelauditoria)?></select></td></tr>
    <tr><th>Idioma: </th><td><select name="idioma"><?= Idioma::getListaEnOptions($idioma)?></select></td></tr>    
</table>
    <input type="hidden" name="id" value="<?=$empresa->getId()?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form>    