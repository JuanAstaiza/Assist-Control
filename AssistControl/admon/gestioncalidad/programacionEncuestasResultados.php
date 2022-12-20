<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__) . '/../../clases/Conector.php';
require_once dirname(__FILE__) . '/../clases/Encuesta.php';
require_once dirname(__FILE__) . '/../clases/Pregunta.php';
require_once dirname(__FILE__) . '/../clases/AlternativaRespuesta.php';
require_once dirname(__FILE__) . '/../clases/ProgramacionEncuesta.php';

foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;

$programacionEncuesta= new ProgramacionEncuesta('id', $_GET['id']);
$encuesta=$programacionEncuesta->getEncuesta();
//PAGINACION
$totalRegistros= count($encuesta->getPreguntasEnObjetos(null));
$totalPaginas= ceil($totalRegistros/registrosXPaginaEncuestas);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPaginaEncuestas;
$registroFinal=$paginaActual*registrosXPaginaEncuestas;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden='  limit ' . registrosXPaginaEncuestas . ' offset ' . $registroInicial;
//FIN PAGINACION

$preguntas= $encuesta->getPreguntasEnObjetos($orden);
$lista='';
$datosGraficas=array();
for ($i = 0; $i < count($preguntas); $i++) {
    $pregunta=$preguntas[$i];
    $lista.='<br><b>' . ($i+1).". {$pregunta->getEnunciado()}</b>";
    $respuestas=$pregunta->getRespuestasTabuladas($programacionEncuesta->getId());
    //print_r($respuestas);
    $lista.='<table border="1">';
    $lista.="<tr><th>Respuesta</th><th>Cantidad</th></tr>";    
    $datosGraficas[$i]="var grafica1;\n";
    $datosGraficas[$i].="var titulo1='{$pregunta->getEnunciado()}?';\n";
    $datosGraficas[$i].="var datosGrafica1=[";
    for ($j = 0; $j < count($respuestas); $j++) {
        foreach ($respuestas[$j] as $Variable => $Valor) {
            if( $j>0) $datosGraficas[$i].=', ';
            $lista.="<tr>";
            $lista.="<td>" . $Variable . "</td>";
            $lista.="<td>" . $Valor . "</td>";
            $lista.="</tr>";
            $datosGraficas[$i].="\n{'detalle': '$Variable', 'valor': $Valor}";
        }
    }
    $datosGraficas[$i].='];';
    $lista.='</table>';
    $lista.="\n\n<div id='capa$i' style='width: 400px; height: 500px;'></div>";
    $lista.="\n<script type='text/javascript'>\n$datosGraficas[$i]\ngenerarGraficaBarras3D(datosGrafica1, capa$i, titulo1);</script>\n\n";
 }
?>
<table border="0">
    <tr><th>Encuesta</th><td><?=$encuesta->getNombre()?></td></tr>
    <tr><th>Objetivo</th><td><?=$encuesta->getObjetivo()?></td></tr>
    <tr><th>Descripci&oacute;n</th><td><?=$encuesta->getDescripcion()?></td></tr>
</table><br>
<h3>RESULTADOS</h3>
 <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
 <br><br>
<?=$lista?>
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



