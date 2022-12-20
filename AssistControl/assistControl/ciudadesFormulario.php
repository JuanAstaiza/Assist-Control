<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Ciudad_A.php';
require_once 'assistControl/clases/Departamento_A.php';
require_once 'assistControl/clases/Pais_A.php';
if (isset($_GET['codigo'])) {
    $accion = 'Modificar';
    $ciudad = new Ciudad_A('codigo', $_GET['codigo']);
    $pais=$ciudad->getDepartamento()->getCodPais();
    $departamento=$ciudad->getCodDepartamento();
} else {
    $accion = 'Adicionar';
    $ciudad = new Ciudad_A(null, null);
    $departamento="";
    $pais="";
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
}
</script>
<center>
    <h3><?= strtoupper($accion)?> CIUDAD</h3><br/><br/>
    <form name="formulario"  method="POST" action="principal.php?CONTENIDO=assistControl/ciudadesActualizar.php">
        <table border="0">
            <tr><th>Pais: </th><td><select name="codPais" onchange="cargarDepartamentos(this.value);"><option value="0">Escoja</option> <?= Pais_A::getListaEnOptions($pais)?></select></td></tr>
            <tr><th>Departamento: </th><td><select name="codDepartamento"><option value="0">Escoja</option> <?= Departamento_A::getListaEnOptions($departamento)?></select></td></tr>
                <tr><th>Ciudad (*):</th><td><input type="text" name="nombre" value="<?=$ciudad->getNombre()?>" maxlength="100" size="50" required/></td></tr>
        </table>
        <input type="hidden" name="codigo" value="<?=$ciudad->getCodigo()?>"/>
        <input type="submit" name="accion" value="<?=$accion?>"/>
    </form>
</center>