<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Ciudad.php';
require_once 'admon/clases/Departamento.php';
require_once 'admon/clases/Pais.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $ciudad = new Ciudad('codigo', $_GET['codigo']);
    $readonly="readonly";
    $pais=$ciudad->getDepartamento()->getCodPais();
    $departamento=$ciudad->getDepartamento()->getCodigo();
            
} else {
    $accion = 'Adicionar';
    $ciudad = new Ciudad(null, null);
    $readonly="";
    $pais="";
    $departamento="";
}
?>
<script type="text/javascript">
<?= Departamento::getListaEnArregloJS()?>
function cargarDepartamentos(codPais){
    window.document.formulario.codDepartamento.options.length=0;
    for (var i = 0; i < departamentos.length; i++) {
        if (departamentos[i][2]==codPais){
            window.document.formulario.codDepartamento.options.length=i+1;
            window.document.formulario.codDepartamento.options[i].value=departamentos[i][0];
            window.document.formulario.codDepartamento.options[i].text=departamentos[i][1];            
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
});
</script>
<center>
    <h3><?= strtoupper($accion)?> CIUDAD</h3><br/><br/>
    <form name="formulario" method="POST" action="principal.php?CONTENIDO=admon/ciudadesActualizar.php">
        <table border="0">
     <tr><th>Pais </th><td><select name="codPais" id="codPais"><option value="0">Escoja</option> <?=Pais::getListaEnOptions($pais)?></select></td></tr>
    <tr><th>Departamento </th><td><select name="codDepartamento" id="codDepartamento"><?= Departamento::getListaEnOptions($departamento,null)?></select></td></tr>
    <tr><th>Codigo (*):</th><td><input type="number"  name="codigo" value="<?=$ciudad->getCodigo()?>" required <?=$readonly?>></td></tr>
    <tr><th>Ciudad (*):</th><td><input type="text" name="nombre" value="<?=$ciudad->getNombre()?>" maxlength="100" size="50" required/></td></tr>
        </table>
        <input type="submit" name="accion" value="<?=$accion?>"/>
        <input type="hidden" name="codigoAnterior" value="<?=$ciudad->getCodigo()?>"/>
    </form>
</center>