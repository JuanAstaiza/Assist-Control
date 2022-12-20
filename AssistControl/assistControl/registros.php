<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Registro.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Estado.php';


$filtro=null;
$OPCION=null;
$TEXTO=null;
foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;
if (isset($_POST['search'])) {
    $OPCION=$_POST['opciones'];
    if (isset($_POST['textoAbuscar'])) {
       $TEXTO=$_POST['textoAbuscar'];
    }else{
        if (isset($_POST['fecha'])) {
            $fecha=$_POST['fecha'];
          }
    } 
        
                    //validamos filtros
            if ($OPCION==1){
                $filtro= "cast(cedulapersona as varchar(999999)) like '$TEXTO%'";
            }else{
               if ($OPCION==2) {
                   $prefijo="lemo_persona.";
                    $palabras=str_word_count($TEXTO);
                   if ($palabras==1) {
                        $filtro= "{$prefijo}primerNombre like '$TEXTO%'";
                   }else{
                       if ($palabras==2) {  
                            list($p_nombre, $s_nombre) = explode(" ", $TEXTO);
                            $filtro= "{$prefijo}primerNombre like '$p_nombre%' and {$prefijo}segundoNombre like '$s_nombre%'";
                       }else{
                           $filtro=null;
                       }
                   }
                   
                }else{
                    if ($OPCION==3) {
                       $palabras=str_word_count($TEXTO);
                       $prefijo="lemo_persona.";
                        if ($palabras==1) {
                             $filtro= "{$prefijo}primerApellido like '$TEXTO%'";
                        }else{
                            if ($palabras==2) {  
                                list($p_apellido,$s_apellido) = explode(" ", $TEXTO);
                                $filtro= "{$prefijo}primerApellido like '$p_apellido%' and {$prefijo}segundoApellido like '$s_apellido%'";
                            }else{
                                if ($palabras>2) {
                                    $filtro=null;
                                }
                            }
                        }
                    }else{
                        if ($OPCION==4) {
                        $filtro="fecha between '".$fecha." 00:00:00' and '".$fecha." 23:59:59'";
                        }else{
                            if ($OPCION==5) {
                                 $filtro=NULL;
                            } 
                    }
                    }
                    
            }
        }
    
}
 //PAGINACION
$totalRegistros= count(Registro::getLista($filtro,null));
$totalPaginas= ceil($totalRegistros/registrosXPagina2);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina2;
$registroFinal=$paginaActual*registrosXPagina2;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden=' order by  fecha desc limit ' . registrosXPagina2 . ' offset ' . $registroInicial;
//FIN PAGINACION   

$lista = '';
$registros= Registro::getListaEnObjetos($filtro, $orden);
for ($i = 0; $i < count($registros); $i++) {
    $registro = $registros[$i];
    $filtro_persona='cedula='.$registro->getCedulaPersona();
        $personas = Persona_A::getListaEnObjetos($filtro_persona, null);
    for ($j = 0; $j < count($personas); $j++) {
        $persona = $personas[$j];
        $estado=$persona->getEstadoEnLetras()->getNombre();
        if ($estado=='Inactivo') {
            $lista.='<tr bgcolor="#FE2E2E">';
            $lista.="<td>{$registro->getCedulaPersona()}</td>";
            $lista.= "<td><div class='colorear rojo'><img src='assistControl/fotos/{$registro->getPersona()->getFoto()}' width='60' height='75'/></div></td>";
            $lista.="<td>{$registro->getPersona()->getPrimerNombre()}   {$registro->getPersona()->getPrimerApellido()}</td>";
            $lista.= "<td>{$registro->getPersona()->getCargo()->getPerfil()->getNombre()}</td>";
            $lista.= "<td>{$registro->getPersona()->getCargo()->getNombre()}</td>";
            $fecharegistroDiario=date("d-m-Y H:i:s",strtotime($registro->getFecha()));
            $lista.= "<td>{$fecharegistroDiario}</td>";
            $lista.= "<td>{$registro->getTipoEnLetras()}</td>";
            $lista.= '<td>';
            $lista.= "<a href='principal.php?CONTENIDO=assistControl/registrosFormulario.php&codigo={$registro->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
            $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/registrosActualizar.php&codigo={$registro->getCodigo()}'); />";
            $lista.= '</td>';
            $lista.='</tr>';
        }else{
            $lista.='<tr>';
            $lista.="<td>{$registro->getCedulaPersona()}</td>";
            $lista.= "<td><img src='assistControl/fotos/{$registro->getPersona()->getFoto()}' width='60' height='75'/></td>";
            $lista.="<td>{$registro->getPersona()->getPrimerNombre()}   {$registro->getPersona()->getPrimerApellido()}</td>";
            $lista.= "<td>{$registro->getPersona()->getCargo()->getPerfil()->getNombre()}</td>";
            $lista.= "<td>{$registro->getPersona()->getCargo()->getNombre()}</td>";
            $fecharegistroDiario=date("d-m-Y H:i:s",strtotime($registro->getFecha()));
            $lista.= "<td>{$fecharegistroDiario}</td>";
            $lista.= "<td>{$registro->getTipoEnLetras()}</td>";
            $lista.= '<td>';
            $lista.= "<a href='principal.php?CONTENIDO=assistControl/registrosFormulario.php&codigo={$registro->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
            $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/registrosActualizar.php&codigo={$registro->getCodigo()}'); />";
            $lista.= '</td>';
            $lista.='</tr>';
            
        }
    }

}
$contadorregistros=Registro::getListaEnObjetos($filtro, null);
$numeroregistros=count($contadorregistros);
if ($numeroregistros>0) {
    $mensaje_numerosRegistros="Se han encontrado $numeroregistros resultados.";
}else{
   $mensaje_numerosRegistros="No se encuentran resultados con los criterios de b&uacute;squeda.";
}
?>
<style type="text/css">
    .colorear {
position: relative;
/* Estas dos propiedades solo sirven para centrar */
display: table;
margin:0 auto;
}
/* Y esta para evitar el margin automatico de Blogger en los enlaces */
.colorear a {
margin: 0 !important;
}
.colorear:before, 
.separator:before {
content: "";
display: block;
position: absolute;
/* Todas las posiciones a cero */
top: 0;
bottom: 0;
left: 0;
right: 0;
background: rgba(255,102,0, 0.5); /*Sepia*/
}
.colorear:hover:before {
background: none;
}
.rojo:before {
background: rgba(255,0,0, 0.5);
}
</style>
<script type="text/javascript" >
function ShowSelected(){
 var opcion_a_buscar = document.getElementById("opciones").value; 
    if (opcion_a_buscar==='1') {
        document.getElementById('textoAbuscar').type = 'number';
        document.getElementById('textoAbuscar').disabled = false;
        document.getElementById('fecha').disabled = true;
        document.getElementById('msg').innerHTML = 'Por favor introduzca la Cedula en la caja Numerica.';
    }else{
        if(opcion_a_buscar==='2'){
            document.getElementById('textoAbuscar').type = 'text';
            document.getElementById('textoAbuscar').disabled = false;
            document.getElementById('fecha').disabled = true;   
            document.getElementById('msg').innerHTML = 'Por favor introduzca el texto que desea buscar en la caja de Texto.';
        }else{
            if (opcion_a_buscar==='3') {
                document.getElementById('textoAbuscar').type = 'text';
                document.getElementById('textoAbuscar').disabled = false;
                document.getElementById('fecha').disabled = true;   
                document.getElementById('msg').innerHTML = 'Por favor introduzca el texto que desea buscar en la caja de Texto.';
            }else{
                if (opcion_a_buscar==='4') {
                    document.getElementById('textoAbuscar').disabled = true;
                    document.getElementById('fecha').disabled = false;   
                    document.getElementById('msg').innerHTML = 'Por favor introduzca la fecha de registro que desea buscar.';
                }else{
                    if (opcion_a_buscar==='5') {
                    document.getElementById('textoAbuscar').disabled = true;
                    document.getElementById('fecha').disabled = true;   
                    document.getElementById('msg').innerHTML = 'Por favor dar Click en el Boton Buscar.';
                }   
                }   
            }
        }
   }
}  
</script>
<br>
<center>
<form name="formulario_principal" method="POST">
    <h3>LISTA DE REGISTROS</h3><br/><br/>
    <center><div id="msg" style="color:blue; font-weight:bold;font-size:14px;"></div></center>
<table>
    <td><select name="opciones"  id="opciones" onchange="ShowSelected();">
        <option value="0">Escoja</option>
        <option value="1">C&eacute;dula</option>
        <option value="2">Nombres</option>
        <option value="3">Apellidos</option>
        <option value="4">Fecha de Registro</option>
        <option value="5">Mostrar Todos</option> 
        </select></td>
        <td><input type="number" name="textoAbuscar" id="textoAbuscar" disabled></td>
        <td><b>Fecha Registro:</b>&nbsp;&nbsp<input type="date" name="fecha" id="fecha" disabled></td>
        <td><input type="submit" value="Buscar" name="search" onclick="ShowSelected();"></td>
    </table>
</form>
<center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje_numerosRegistros?></div></center>
    <br><br>
    <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
        <table border="1">
            <tr><th>C&Eacute;DULA</th><th>FOTO</th><th>NOMBRES<th>PERFIL</th><th>CARGO</th><th>FECHA REGISTRO</th><th>TIPO</th><th><a href="principal.php?CONTENIDO=assistControl/registrosFormulario.php"><img src="presentacion/imagenes/AssitControl/adicionar.png"/></a></th></tr>
            <?=$lista?>
        </table>
</center>
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
<br>
<a href="principal.php?CONTENIDO=assistControl/variosregistros.php"><button type="button" class="botones">Registros Actuales</button></a>

