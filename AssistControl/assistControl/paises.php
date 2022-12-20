<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Pais_A.php';

foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;

//PAGINACION
$totalRegistros= count(Pais_A::getLista(null,null));
$totalPaginas= ceil($totalRegistros/registrosXPagina3);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina3;
$registroFinal=$paginaActual*registrosXPagina3;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden=' limit ' . registrosXPagina3 . ' offset ' . $registroInicial;
//FIN PAGINACION

$lista = '';
$paises = Pais_A::getListaEnObjetos(null, $orden);
for ($i = 0; $i < count($paises); $i++) {
    $pais = $paises[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$pais->getCodigo()}</td>";
    $lista.= "<td>{$pais->getNombre()}</td>";
    $lista.= '<td>';
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/paisesFormulario.php&codigo={$pais->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
    $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/paisesActualizar.php&codigo={$pais->getCodigo()}'); />";
    $lista.= '</td>';
    $lista.= '</tr>';
}
?>
<h3>LISTA DE PAISES</h3><br/><br/>
     <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
    <table border="1">
        <tr><th>C&oacute;digo</th><th>Nombre</th><th><a href="principal.php?CONTENIDO=assistControl/paisesFormulario.php" title="Adicionar"><img src="presentacion/imagenes/AssitControl/adicionar.png"/></a></th></tr>
        <?=$lista?>
    </table>
<form name="formulario" method="POST">
<img id="primero" src="presentacion/imagenes/primero.png" title="Ir a la primer P&aacute;gina" onclick="cambiarPagina(1);">
<img id="anterior" src="presentacion/imagenes/anterior.png" title="Ir a la anterior P&aacute;gina" onclick="cambiarPagina(<?=$paginaActual-1?>);">
<input type="number" name="paginaActual" value="<?=$paginaActual?>" style="width: 40px"  onchange="(this.value)" readonly/>
<img id="siguiente" src="presentacion/imagenes/siguiente.png" title="Ir a la siguiente P&aacute;gina" onclick="cambiarPagina(<?=$paginaActual+1?>);"/>
<img id="ultimo" src="presentacion/imagenes/ultimo.png" title="Ir a la ultima P&aacute;gina" onclick="cambiarPagina(<?=$totalPaginas?>);">
</form>
<script type="text/javascript">
    
    if (<?=$paginaActual?>==1) {
        document.getElementById("primero").removeAttribute("onclick");
        document.getElementById("anterior").removeAttribute("onclick");
    }
    
    if (<?=$paginaActual?>==<?=$totalPaginas?>) {
        document.getElementById("ultimo").removeAttribute("onclick");
        document.getElementById("siguiente").removeAttribute("onclick");
    }
    
    function cambiarPagina(pagina){
        document.formulario.paginaActual.value=pagina;
        document.formulario.submit();
    }

</script>
