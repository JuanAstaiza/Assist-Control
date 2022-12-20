<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Ciudad.php';
require_once 'admon/clases/Departamento.php';
require_once 'admon/clases/Pais.php';

foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;

//PAGINACION
$totalRegistros= count(Ciudad::getLista(null,null));
$totalPaginas= ceil($totalRegistros/registrosXPagina3);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina3;
$registroFinal=$paginaActual*registrosXPagina3;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden=' limit ' . registrosXPagina3 . ' offset ' . $registroInicial;
//FIN PAGINACION

$lista = '';
$ciudades = Ciudad::getListaEnObjetos(null, $orden);
for ($i = 0; $i < count($ciudades); $i++) {
    $ciudad = $ciudades[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$ciudad->getNombre()}</td>";
    $lista.= "<td>{$ciudad->getDepartamento()->getNombre()}</td>";
    $lista.= "<td>{$ciudad->getDepartamento()->getPais()->getNombre()}</td>";
    $lista.= '<td>';
    $lista.= "<a href='principal.php?CONTENIDO=admon/ciudadesFormulario.php&codigo={$ciudad->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'/></a>";
    $lista.= "<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/ciudadesActualizar.php&codigo={$ciudad->getCodigo()}'); />";
    $lista.= '</td>';
    $lista.= '</tr>';
}
?>
    <h3>LISTA DE CIUDADES</h3><br/><br/>
     <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
    <table border="1">
        <tr><th>Nombre</th><th>Departamento</th><th>Pais</th><th><a href="principal.php?CONTENIDO=admon/ciudadesFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"/></a></th></tr>
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
