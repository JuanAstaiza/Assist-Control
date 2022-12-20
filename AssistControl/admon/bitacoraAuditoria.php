<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'clases/SucesoAuditoria.php';
require_once 'clases/BitacoraAuditoria.php';
require_once 'clases/Usuario.php';

$filtro=" suceso='I'or suceso='F'";
foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;
if (isset($cFecha) && isset($cUsuario)) {
    $filtro=" fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' and  usuario='$usuario'";
}else{
    if (isset($cFecha)) {
    $cFecha='checked';
    $filtro=" fecha between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' ";
    }else{
        $cFecha=''; $fechaInicio=''; $fechaFin='';
         if (isset($cUsuario)) {
               $filtro=" usuario='$usuario' ";
        }else{
            $cUsuario=''; $usuario=''; 
            if (isset($cInicio)) {
                if ($_POST['inicio']=="I") {
                    $filtro=" suceso='I'";
                }else{
                    $filtro=" suceso='S'";
                }
            }
        }
    }   
}

//PAGINACION
$totalRegistros= count(BitacoraAuditoria::getLista($filtro,null));
$totalPaginas= ceil($totalRegistros/registrosXPagina3);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina3;
$registroFinal=$paginaActual*registrosXPagina3;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden=' order by  fecha desc limit ' . registrosXPagina3 . ' offset ' . $registroInicial;
//FIN PAGINACION

$lista='';
$datos= BitacoraAuditoria::getListaEnObjetos($filtro, $orden);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getFecha()}</td>";
    $lista.="<td>{$objeto->getSuceso()->getNombre()}</td>";
    $lista.="<td>{$objeto->getFinSesion()->getFecha()}</td>";
    $lista.="<td>{$objeto->getDuracionSesion()}</td>";
    $lista.="<td>{$objeto->getIp()}</td>";
    $lista.="<td>{$objeto->getUsuario()->getUsuario()}</td>";
    $lista.="<td>{$objeto->getUsuario()->getEmpresa()->getRazonSocial()}</td>";
    $lista.='</tr>';
}
if ($IDEMPRESA==2) {
    $titulo="INICIOS DE SESSION DE USUARIOS";
}else{
    $titulo="BITACORA AUDITORIA";
}
?>
<form method="POST">
    <table border="0">
        <tr><td><input type="checkbox" name="cFecha" value="<?=$cFecha?>">Fecha:</td>
            <td colspan="3">
                Desde: <input type="date" name="fechaInicio" value="<?=$fechaInicio?>"/>
                Hasta: <input type="date" name="fechaFin" value="<?=$fechaFin?>"/>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" name="cUsuario" value="<?=$cUsuario?>">Usuario:</td>
            <td><select name="usuario"><?= Usuario::getListaEnOptions(null)?></select></td>
        </tr>
        <tr><td><input type="checkbox" name="cInicio"/>Inicio</td>
                <td>
                    <input type="radio" name="inicio" value="I" /> Ingreso
                    <input type="radio" name="inicio" value="F" /> Salida
       </td>
        </tr>
     </table>
    <input type="submit" name="buscar"  value="Buscar"/>
 </form>
<h3><?=$titulo?></h3>
 <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
<table border="1">
    <tr><th>INICIO</th><th>RESULTADO</th><th>FIN</th><th>DURACION</th><th>IP</th><th>USUARIO</th><th>EMPRESA</th></tr>
    <?=$lista?>
</table>
 <form name="formulario" method="POST">
<input type="hidden" name="filtro" value="<?=$filtro?>">
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
