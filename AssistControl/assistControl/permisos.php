<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Permiso.php';
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Motivo.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Estado.php';

$filtro=null;
$OPCION=null;
$TEXTO=null;
$fecha=null;
foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;
if (isset($_POST['search'])) {
    $OPCION=$_POST['opciones'];
    if (isset($_POST['textoAbuscar'])) {
       $TEXTO=$_POST['textoAbuscar'];
    }else{
        if (isset($_POST['fechasolicitud'])) {
            $fecha=$_POST['fechasolicitud'];
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
                        $filtro= "fechasolicitud='$fecha'";
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
$totalRegistros= count(Permiso::getLista($filtro,null));
$totalPaginas= ceil($totalRegistros/registrosXPagina2);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina2;
$registroFinal=$paginaActual*registrosXPagina2;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden=' order by  codigo desc limit ' . registrosXPagina2 . ' offset ' . $registroInicial;
//FIN PAGINACION
if (isset($_POST['search'])) {
    $orden=null;
}
$lista = '';
$permisos = Permiso::getListaEnObjetos($filtro, $orden);
for ($i = 0; $i < count($permisos); $i++) {
    $permiso = $permisos[$i];
    $filtro='cedula='.$permiso->getCedulaPersona();
    $personas = Persona_A::getListaEnObjetos($filtro, null);
    for ($j = 0; $j < count($personas); $j++) {
        $persona = $personas[$j];
        $estado=$persona->getEstadoEnLetras()->getNombre();
        if ($estado=='Inactivo') {
            $lista.='<tr bgcolor="#FE2E2E">';
            $lista.="<td>{$permiso->getCedulaPersona()}</td>";
            $lista.= "<td><div class='colorear rojo'><img src='assistControl/fotos/{$permiso->getPersona()->getFoto()}' width='60' height='75'/></div></td>";
            $lista.="<td>{$permiso->getPersona()->getPrimerNombre()}   {$permiso->getPersona()->getPrimerApellido()}</td>"; 
            $fechasolicitud=date("d-m-Y",strtotime($permiso->getFechaSolicitud())); 
            $lista.="<td>{$fechasolicitud}</td>";
            $fechainicio=date("d-m-Y",strtotime($permiso->getFechaInicio())); 
            $lista.="<td>{$fechainicio}</td>";
            $fechafin=date("d-m-Y",strtotime($permiso->getFechaFin())); 
            $lista.="<td>{$fechafin}</td>";
            $lista.="<td>{$permiso->getMotivo()->getNombre()} </td>";
            $lista.="<td><a target='_blank' href='assistControl/archivos/{$permiso->getAnexo()}'><img src='presentacion/imagenes/AssitControl/anexo.png' width='40' height='40' title='Archivo'/></a></td>";
            $lista.='<td>';
            $lista.="<a href='principal.php?CONTENIDO=assistControl/permisosFormularioAdministrador.php&codigo={$permiso->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
            $lista.= "<a href='principal.php?CONTENIDO=assistControl/detallesPermiso.php&codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}' title='Detalles del Permiso'><img src='presentacion/imagenes/AssitControl/ficha.png' width='30' height='30'/></a>";
            $link="<a target='_blank'  href='assistControl/reportes/permiso_del_empleado_pdf.php?codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}'>";
            $lista.="$link<img src='presentacion/imagenes/AssitControl/pdf2.png' width='40' height='40' title='Exportar Permiso en Documento PDF'/></a>";
            $link2="<a target='_blank'  href='assistControl/reportes/permiso_del_empleado_word.php?codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}'>";
            $lista.="$link2<img src='presentacion/imagenes/AssitControl/word.png' width='40' height='40' title='Exportar Permiso en Documento WORD'/></a>";
            $link3="<a target='_blank'  href='assistControl/reportes/permiso_del_empleado_excel.php?codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}'>";
            $lista.="$link3<img src='presentacion/imagenes/AssitControl/excel.png' width='40' height='40' title='Exportar Permiso en Documento EXCEL'/></a>";
            $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/permisosActualizar.php&codigo={$permiso->getCodigo()}'); />";
            $lista.='</td>';
            $lista.='</tr>';  
        }else{
            $lista.='<tr>';
            $lista.="<td>{$permiso->getCedulaPersona()}</td>";
            $lista.= "<td><img src='assistControl/fotos/{$permiso->getPersona()->getFoto()}' width='60' height='75'/></td>";
            $lista.="<td>{$permiso->getPersona()->getPrimerNombre()}   {$permiso->getPersona()->getPrimerApellido()}</td>"; 
            $fechasolicitud=date("d-m-Y",strtotime($permiso->getFechaSolicitud())); 
            $lista.="<td>{$fechasolicitud}</td>";
            $fechainicio=date("d-m-Y",strtotime($permiso->getFechaInicio())); 
            $lista.="<td>{$fechainicio}</td>";
            $fechafin=date("d-m-Y",strtotime($permiso->getFechaFin())); 
            $lista.="<td>{$fechafin}</td>";
            $lista.="<td>{$permiso->getMotivo()->getNombre()} </td>";
            $lista.="<td><a target='_blank' href='assistControl/archivos/{$permiso->getAnexo()}'><img src='presentacion/imagenes/AssitControl/anexo.png' width='40' height='40' title='Archivo'/></a></td>";
            $lista.='<td>';
            $lista.="<a href='principal.php?CONTENIDO=assistControl/permisosFormularioAdministrador.php&codigo={$permiso->getCodigo()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
            $lista.= "<a href='principal.php?CONTENIDO=assistControl/detallesPermiso.php&codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}' title='Detalles del Permiso'><img src='presentacion/imagenes/AssitControl/ficha.png' width='30' height='30'/></a>";
            $link="<a target='_blank'  href='assistControl/reportes/permiso_del_empleado_pdf.php?codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}'>";
            $lista.="$link<img src='presentacion/imagenes/AssitControl/pdf.png' width='40' height='40' title='Exportar Permiso en Documento PDF'/></a>";
            $link2="<a target='_blank'  href='assistControl/reportes/permiso_del_empleado_word.php?codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}'>";
            $lista.="$link2<img src='presentacion/imagenes/AssitControl/word.png' width='40' height='40' title='Exportar Permiso en Documento WORD'/></a>";
            $link3="<a target='_blank'  href='assistControl/reportes/permiso_del_empleado_excel.php?codigo={$permiso->getCodigo()}&cedula={$permiso->getCedulaPersona()}'>";
            $lista.="$link3<img src='presentacion/imagenes/AssitControl/excel.png' width='40' height='40' title='Exportar Permiso en Documento EXCEL'/></a>";
            $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/permisosActualizar.php&codigo={$permiso->getCodigo()}'); />";
            $lista.='</td>';
            $lista.='</tr>';  
        }
    }
  
}
$link="<a target='_blank'  href='assistControl/reportes/listado_de_permisos_excel.php?opcion=$OPCION&texto=$TEXTO&fecha=$fecha'>";
$link2="<a target='_blank'  href='assistControl/reportes/listado_de_permisos_word.php?opcion=$OPCION&texto=$TEXTO&fecha=$fecha'>";
$link3="<a target='_blank'  href='assistControl/reportes/listado_de_permisos_pdf.php?opcion=$OPCION&texto=$TEXTO&fecha=$fecha'>";


$contadorregistros=Permiso::getListaEnObjetos($filtro, null);
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
        document.getElementById('fechaSolicitud').disabled = true;
        document.getElementById('msg').innerHTML = 'Por favor introduzca la Cedula en la caja Numerica.';
    }else{
        if(opcion_a_buscar==='2'){
            document.getElementById('textoAbuscar').type = 'text';
            document.getElementById('textoAbuscar').disabled = false;
            document.getElementById('fechaSolicitud').disabled = true;   
            document.getElementById('msg').innerHTML = 'Por favor introduzca el texto que desea buscar en la caja de Texto.';
        }else{
            if (opcion_a_buscar==='3') {
                document.getElementById('textoAbuscar').type = 'text';
                document.getElementById('textoAbuscar').disabled = false;
                document.getElementById('fechaSolicitud').disabled = true;   
                document.getElementById('msg').innerHTML = 'Por favor introduzca el texto que desea buscar en la caja de Texto.';
            }else{
                if (opcion_a_buscar==='4') {
                    document.getElementById('textoAbuscar').disabled = true;
                    document.getElementById('fechaSolicitud').disabled = false;   
                    document.getElementById('msg').innerHTML = 'Por favor introduzca la fecha de Solicitud que desea buscar.';
                }else{
                    if (opcion_a_buscar==='5') {
                    document.getElementById('textoAbuscar').disabled = true;
                    document.getElementById('fechaSolicitud').disabled = true;   
                    document.getElementById('msg').innerHTML = 'Por favor dar Click en el Boton Buscar.';
                }   
                }   
            }
        }
   }
}
</script>
<form name="formulario_principal" method="POST">
<h3>LISTA DE PERMISOS</h3><br/><br/>
    <br>
<!--INICIO DEL BUSCADOR-->
<table>
    <td><select name="opciones"  id="opciones" onchange="ShowSelected();">
        <option value="0">Escoja</option>
        <option value="1">C&eacute;dula</option>
        <option value="2">Nombres</option>
        <option value="3">Apellidos</option>
        <option value="4">Fecha Solicitud</option>
        <option value="5">Mostrar Todos</option> 
        </select></td>
        <td><input type="number" name="textoAbuscar" id="textoAbuscar" disabled></td>
        <td><b>Fecha Solicitud:</b>&nbsp;&nbsp<input type="date" name="fechasolicitud" id="fechaSolicitud" disabled></td>
        <td><input type="submit" value="Buscar" name="search" onclick="ShowSelected();"></td>
    </table>
</form>
<center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje_numerosRegistros?></div></center>
    <br><br>
    <table border="1">
        <b>Exportar en:</b>&nbsp;&nbsp;&nbsp;<?=$link?><img src="presentacion/imagenes/AssitControl/excel.png " width="40" height="40" title="Documento EXCEL"/></a>&nbsp;&nbsp;&nbsp;<?=$link2?><img src="presentacion/imagenes/AssitControl/word.png " width="40" height="40" title="Documento WORD"/></a>&nbsp;&nbsp;&nbsp;<?=$link3?><img src="presentacion/imagenes/AssitControl/pdf.png " width="40" height="40" title="Documento PDF"/></a>
    <br><br>  
    <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
    <tr><th>Cedula</th><th>Foto</th><th>Nombres</th><th>Fecha Solicitud</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Motivo</th><th>Anexo</th>
            <th><a href="principal.php?CONTENIDO=assistControl/permisosFormularioAdministrador.php" title="Adicionar"><img src="presentacion/imagenes/AssitControl/adicionar.png"/></a></th></tr>
        <?=$lista?>
    </table>
<form name="formulario"  method="POST">
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
