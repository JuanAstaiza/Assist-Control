<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Perfil_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Estado.php';
$mensaje_busqueda="";
$disabled="disabled";
$filtro=null;
$OPCION=null;
$TEXTO=null;
$cargo=null;
$estado=null;
foreach ($_POST as $Variable => $valor) ${$Variable}=$valor;
if (isset($_POST['search'])) {
    $OPCION=$_POST['opciones'];
    //validar CARGOS Y LISTAR TODOS LOS REGISTROS
    if ($OPCION==4 || $OPCION==5 || $OPCION==6) {
        if ($OPCION==4) {
           $cargo= $_POST['codCargo'];
           if ($cargo!=null) {
                $filtro= "codCargo='$cargo'";
           }else{
                $mensaje_busqueda="Por favor Seleccione en el Listado un Cargo de acuerdo con el Perfil.";
           }
        }else{
            if ($OPCION==5) {
                $estado= $_POST['codEstado'];
                if ($estado!=null) {
                     $filtro= "estado='$estado'";
                }else{
                     $mensaje_busqueda="Por favor Seleccione en el Listado un Estado.";
                }
            }else{
                if ($OPCION==6) {
                    $filtro=null;
                }
            }
        }
    }else{
        //validar CEDULA NOMBRES Y APELLIDOS
        $TEXTO=$_POST['textoAbuscar'];
        if ($TEXTO!=null) {               
                //validamos filtros
            if ($OPCION==1){
                $filtro= "cast(cedula as varchar(999999)) like '$TEXTO%'";
            }else{
               if ($OPCION==2) {
                   $palabras=str_word_count($TEXTO);
                   if ($palabras==1) {
                        $filtro= "primerNombre like '$TEXTO%'";
                   }else{
                       if ($palabras==2) {  
                            list($p_nombre, $s_nombre) = explode(" ", $TEXTO);
                            $filtro= "primerNombre like '$p_nombre%' and segundoNombre like '$s_nombre%'";
                       }else{
                           $mensaje_busqueda="Por favor introduzca MAXIMO 2 palabras.";
                           $filtro=null;
                       }
                   }
                }else{
                    if ($OPCION==3) {
                        $palabras=str_word_count($TEXTO);
                        if ($palabras==1) {
                             $filtro= "primerApellido like '$TEXTO%'";
                        }else{
                            if ($palabras==2) {  
                                list($p_apellido,$s_apellido) = explode(" ", $TEXTO);
                                $filtro= "primerApellido like '$p_apellido%' and segundoApellido like '$s_apellido%'";
                            }else{
                                if ($palabras>2) {
                                    $mensaje_busqueda="Por favor introduzca MAXIMO 2 palabras.";
                                    $filtro=null;
                                }
                            }
                        }
                    }
                }
            }
        }else $mensaje_busqueda="Por favor introduzca el texto que desea buscar.";
    }
}

//PAGINACION
$totalRegistros= count(Persona_A::getLista($filtro, null));
$totalPaginas= ceil($totalRegistros/registrosXPagina2);
if (!isset($paginaActual)) $paginaActual=1;
$registroInicial=($paginaActual-1)*registrosXPagina2;
$registroFinal=$paginaActual*registrosXPagina2;
if ($registroFinal>$totalRegistros) $registroFinal=$totalRegistros;
$orden=' limit ' . registrosXPagina2 . ' offset ' . $registroInicial;
//FIN PAGINACION
if (isset($_POST['search'])) {
    $orden=null;
}
$lista = '';
$personas = Persona_A::getListaEnObjetos($filtro, $orden);
for ($i = 0; $i < count($personas); $i++) {
    $persona = $personas[$i];
    $estado=$persona->getEstadoEnLetras()->getNombre();
    if ($estado=='Inactivo') {
        $lista.= '<tr bgcolor="#FE2E2E">';
        $lista.= "<td>{$persona->getCedula()}</td>";
        $lista.= "<td><div class='colorear rojo'><img src='assistControl/fotos/{$persona->getFoto()}' width='60' height='75'/></div></td>";
        $lista.= "<td>{$persona->getPrimerNombre()}" . " " ."{$persona->getSegundoNombre()}</td>";
        $lista.= "<td>{$persona->getPrimerApellido()}" . " " ."{$persona->getSegundoApellido()}</td>";
        $lista.= "<td>{$persona->getCargo()->getPerfil()->getNombre()}</td>";
        $lista.= "<td>{$persona->getCargo()->getNombre()}</td>";
        $lista.= "<td>{$persona->getEstadoEnLetras()->getNombre()}</td>";
        $lista.= '<td>';
    }else{
        $lista.= '<tr>';
        $lista.= "<td>{$persona->getCedula()}</td>";
        $lista.= "<td><img src='assistControl/fotos/{$persona->getFoto()}' width='60' height='75'/></td>";
        $lista.= "<td>{$persona->getPrimerNombre()}" . " " ."{$persona->getSegundoNombre()}</td>";
        $lista.= "<td>{$persona->getPrimerApellido()}" . " " ."{$persona->getSegundoApellido()}</td>";
        $lista.= "<td>{$persona->getCargo()->getPerfil()->getNombre()}</td>";
        $lista.= "<td>{$persona->getCargo()->getNombre()}</td>";
        $lista.= "<td>{$persona->getEstadoEnLetras()->getNombre()}</td>";
        $lista.= '<td>';
    }

    $lista.= "<a href='principal.php?CONTENIDO=assistControl/empleadosFormulario.php&cedula={$persona->getCedula()}' title='Modificar'><img src='presentacion/imagenes/AssitControl/modificar.png'/></a>";
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/turnos.php&cedula={$persona->getCedula()}' title='Asignaci&oacute;n de Turnos'><img src='presentacion/imagenes/AssitControl/turno.png' width='30' height='30'/></a>&nbsp;";
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/horasExtras.php&cedula={$persona->getCedula()}' title='Asignaci&oacute;n de Horas Extras'><img src='presentacion/imagenes/AssitControl/hora_extra.png' width='30' height='30'/></a>";
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/titulos.php&cedula={$persona->getCedula()}' title='Especialidades'><img src='presentacion/imagenes/AssitControl/Especialidades.png' width='35' height='35'/></a>";
    $lista.= "<a href='principal.php?CONTENIDO=assistControl/detallesEmpleado.php&cedula={$persona->getCedula()}' title='Detalles'><img src='presentacion/imagenes/AssitControl/ficha.png' width='30' height='30'/></a>";
    $lista.= "<img src='presentacion/imagenes/AssitControl/eliminar.png' title='Eliminar' onClick=eliminar('assistControl/empleadosActualizar.php&cedula={$persona->getCedula()}'); />";
    $lista.= '</td>';
    $lista.= '</tr>';
}
$link="<a target='_blank'  href='assistControl/reportes/listado_de_empleados_excel.php?opcion=$OPCION&texto=$TEXTO&cargo=$cargo&estado=$estado'>";
$link2="<a target='_blank'  href='assistControl/reportes/listado_de_empleados_word.php?opcion=$OPCION&texto=$TEXTO&cargo=$cargo&estado=$estado'>";
$link3="<a target='_blank'  href='assistControl/reportes/listado_de_empleados_pdf.php?opcion=$OPCION&texto=$TEXTO&cargo=$cargo&estado=$estado'>";

$contadorregistros=Persona_A::getListaEnObjetos($filtro, null);
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
        document.getElementById('codPerfil').disabled = true;
        document.getElementById('codCargo').disabled = true;
        document.getElementById('codEstado').disabled = true;
        document.getElementById('msg').innerHTML = 'Por favor introduzca la Cedula en la caja Numerica.';
    }else{
        if(opcion_a_buscar==='2'){
            document.getElementById('textoAbuscar').type = 'text';
            document.getElementById('textoAbuscar').disabled = false;
            document.getElementById('codPerfil').disabled = true;
            document.getElementById('codCargo').disabled = true;
            document.getElementById('codEstado').disabled = true;          
            document.getElementById('msg').innerHTML = 'Por favor introduzca el texto que desea buscar en la caja de Texto.';
        }else{
            if (opcion_a_buscar==='3') {
                document.getElementById('textoAbuscar').type = 'text';
                document.getElementById('textoAbuscar').disabled = false;
                document.getElementById('codPerfil').disabled = true;
                document.getElementById('codCargo').disabled = true;
                document.getElementById('codEstado').disabled = true;               
                document.getElementById('msg').innerHTML = 'Por favor introduzca el texto que desea buscar en la caja de Texto.';

            }else{
                if (opcion_a_buscar==='4') {
                    document.getElementById('textoAbuscar').type = 'text';
                    document.getElementById('textoAbuscar').disabled = true;
                 document.getElementById('codPerfil').disabled = false;
                    document.getElementById('codCargo').disabled = false;
                    document.getElementById('codEstado').disabled = true;
                    document.getElementById('msg').innerHTML = 'Por favor Seleccione en el Listado el Perfil y luego el Cargo.';
                    }else{
                        if (opcion_a_buscar==='5') {
                            document.getElementById('textoAbuscar').type = 'text';
                            document.getElementById('textoAbuscar').disabled = true;
                            document.getElementById('codPerfil').disabled = true;
                            document.getElementById('codCargo').disabled = true;
                            document.getElementById('codEstado').disabled = false;
                            document.getElementById('msg').innerHTML = 'Por favor Seleccione en el Listado el Estado.';
                        }else{
                            if (opcion_a_buscar==='6') {
                                document.getElementById('textoAbuscar').type = 'text';
                                document.getElementById('textoAbuscar').disabled = true;
                                document.getElementById('codPerfil').disabled = true;
                                document.getElementById('codCargo').disabled = true;
                                document.getElementById('codEstado').disabled = true;
                                document.getElementById('msg').innerHTML = 'Por favor dar Click en el Boton Buscar.';
                            }
                        }
                    }
                
            }
        }
   }
}


<?= Cargo::getListaEnArregloJS()?>
function cargarCargos(codPerfil){
    window.document.formulario_principal.codCargo.options.length=0;
    for (var i = 0; i < cargos.length; i++) {
        if (cargos[i][2]==codPerfil){
            window.document.formulario_principal.codCargo.options.length=i+1;
            window.document.formulario_principal.codCargo.options[i].value=cargos[i][0];
            window.document.formulario_principal.codCargo.options[i].text=cargos[i][1];            
        }
    }
}
</script>
<h3>LISTADO DE EMPLEADOS</h3><br><br>
<br/>
<form name="formulario_principal"  method="POST">
<!--INICIO DEL BUSCADOR-->
<center><div id="msg" style="color:blue; font-weight:bold;font-size:14px;"></div></center>
<center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje_busqueda?></div></center>
<table>
<td><select name="opciones"  id="opciones" onchange="ShowSelected();">
    <option value="0">Escoja</option>
    <option value="1">C&eacute;dula</option>
    <option value="2">Nombres</option>
    <option value="3">Apellidos</option>
    <option value="4">Cargo</option> 
    <option value="5">Estado</option> 
    <option value="6">Mostrar Todos</option> 
    </select></td>
    <td><input type="number" name="textoAbuscar" id="textoAbuscar" disabled></td>
    <td><b>Perfil:</b>&nbsp;&nbsp;<select name="codPerfil" id="codPerfil" onchange="cargarCargos(this.value);" <?=$disabled?>><option value="0">Escoja</option> <?= Perfil_A::getListaEnOptions(null)?></select></td>
    <td><b>Cargo:</b>&nbsp;&nbsp<select name="codCargo" id="codCargo" <?=$disabled?>></select></td>
    <td><b>Estado:</b>&nbsp;&nbsp<select name="codEstado" id="codEstado"<?=$disabled?>><option value="true" selected>Activo</option><option value="false">Inactivo</option></select></td>
    <td><input type="submit" value="Buscar" name="search" onclick="ShowSelected();"></td>
<!--FIN DEL BUSCADOR-->
</table>
</form>
<center><div  style="color:red; font-weight:bold;font-size:14px;"><?=$mensaje_numerosRegistros?></div></center>
<br><br><br>
    <table border="1">
       <b>Exportar en:</b>&nbsp;&nbsp;&nbsp;<?=$link?><img src="presentacion/imagenes/AssitControl/excel.png " width="40" height="40" title="Documento EXCEL"/></a>&nbsp;&nbsp;&nbsp;<?=$link2?><img src="presentacion/imagenes/AssitControl/word.png " width="40" height="40" title="Documento WORD"/></a>&nbsp;&nbsp;&nbsp;<?=$link3?><img src="presentacion/imagenes/AssitControl/pdf.png " width="40" height="40" title="Documento PDF"/></a>
    <br><br>
    <b>P&aacute;gina <font color="blue"><?=$paginaActual?></font> de <font color="blue"><?=$totalPaginas?></font>. Presentando registros desde <font color="blue"><?=$registroInicial?></font> hasta <font color="blue"><?=$registroFinal?></font> de un total de <font color="blue"><?=$totalRegistros?></font></b>
    <tr>
        <th>C&eacute;dula</th><th>Foto</th><th>Nombres</th><th>Apellidos</th><th>Perfil</th><th>Cargo</th></th><th>Estado</th>
        <th><a href="principal.php?CONTENIDO=assistControl/empleadosFormulario.php" title="Adicionar"><img src="presentacion/imagenes/AssitControl/adicionar.png"></a></th>        
    </tr>
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


