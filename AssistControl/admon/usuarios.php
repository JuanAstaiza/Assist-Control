<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/EstadoUsuario.php';

foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;
$filtro=null;
$TEXTO=null;
$mensaje_busqueda='';
if (isset($_POST['search'])) {
    $OPCION=$_POST['opciones'];
    if (isset($_POST['textoAbuscar'])) {
       $TEXTO=$_POST['textoAbuscar'];
    }                //validamos filtros
            if ($OPCION==1){
                $filtro= " usuario='$TEXTO'";
            }else{
                    if ($OPCION==3) {
                        $filtro=NULL;
                }           
        }
    }

//PAGINACION
$totalRegistros= count(Usuario::getLista($filtro,null));
$totalPaginas= ceil($totalRegistros/registrosXPagina2);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina2;
$registroFinal=$paginaActual*registrosXPagina2;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden='  limit ' . registrosXPagina2 . ' offset ' . $registroInicial;
//FIN PAGINACION

$lista='';
$datos= Usuario::getListaEnObjetos($filtro, $orden);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getNombresCompletos()}</td>";    
    $lista.="<td>{$objeto->getTelefono()}</td>";    
    $lista.="<td>{$objeto->getEmail()}</td>";    
    $lista.="<td>{$objeto->getFechaNacimiento()}</td>";    
    $lista.="<td>{$objeto->getEmpresa()}</td>";    
    $lista.="<td>{$objeto->getUsuario()}</td>";    
    $lista.="<td>{$objeto->getPerfil()}</td>";    
    $lista.="<td>{$objeto->getEstado()}</td>";    
    $lista.="<td>{$objeto->getFechaIniciacion()}</td>";    
    $lista.="<td>{$objeto->getFechaFinalizacion()}</td>";    
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/usuariosFormulario.php&usuario={$objeto->getUsuario()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/usuariosActualizar.php&usuario={$objeto->getUsuario()}')>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<script type="text/javascript" >
function ShowSelected(){
var opcion_a_buscar = document.getElementById("opciones").value;
    if (opcion_a_buscar==='1') {
        document.getElementById('textoAbuscar').disabled = false;
        document.getElementById('msg').innerHTML = 'Por favor introduzca el Usuario en la caja Numerica.';
    }else{
            if (opcion_a_buscar==='2') {
                document.getElementById('textoAbuscar').disabled = true;
                document.getElementById('msg').innerHTML = 'Por favor dar Click en el Boton Buscar.';

            }
        }
   }
</script>
<h3>LISTA DE USUARIOS</h3>
<br/>
<form name="formulario_principal" method="POST">
<!--INICIO DEL BUSCADOR-->
<center><div id="msg" style="color:blue; font-weight:bold;font-size:14px;"></div></center>
<center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje_busqueda?></div></center>
<table>
    <td><select name="opciones"  id="opciones" onchange="ShowSelected();">
        <option value="0">Escoja</option>
        <option value="1">Usuario</option>
        <option value="2">Mostrar Todos</option> 
        </select></td>
        <td><input type="text" name="textoAbuscar" id="textoAbuscar" disabled></td>
        <td><input type="submit" value="Buscar" name="search" onclick="ShowSelected();"></td>
    </table>
</form>
<br><br>
<b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
<table border="1">
    <tr>
        <th>NOMBRES</th><th>TEL&Eacute;FONO</th><th>CORREO ELECTR&Oacute;NICO</th><th>FECHA DE NACIMIENTO</th><th>EMPRESA</th><th>USUARIO</th><th>PERFIL</th><th>ESTADO</th><th>FECHA DE INICIO</th><th>FECHA DE FINALIZACI&Oacute;N</th>
        <th><a href="principal.php?CONTENIDO=admon/usuariosFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>
    </tr>
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
