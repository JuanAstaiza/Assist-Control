<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Listado_de_Empleados.doc");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../clases/Conector.php';
date_default_timezone_set('America/Bogota');


$TEXTO=null;
$cargo=null;
$estado=null;

 $OPCION=$_GET['opcion'];
    if ($OPCION==4 || $OPCION==5 || $OPCION==6) {
        if ($OPCION==4) {
           $cargo= $_GET['cargo'];
           if ($cargo!=null) {
                $filtro= "codCargo='$cargo'";
           }else{
                $mensaje_busqueda="Por favor Seleccione en el Listado un Cargo de acuerdo con el Perfil.";
           }
        }else{
            if ($OPCION==5) {
                $estado= $_GET['estado'];
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
        $TEXTO=$_GET['texto'];
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
                                    $filtro=null;
                                }
                            }
                        }
                    }
                }
            }
        }else {
           $filtro=null;
        }
    }
    
       
    function getListaPersona($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
            . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
            . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona $filtro";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
        
    }
    
        function getListaCargo($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codPerfil from {$P}cargo $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    } 
    
    function getListaPerfil($filtro) {
        $BD='assistcontrol'; $P='lemo_';
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, descripcion from {$P}perfil $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    function Estado($estado){
        switch ($estado) {
            case '1': return 'Activo'; break;
            case '0': return 'Inactivo'; break;
            default: return 'Desconocido'; break;
        }
    }

$lista = '';
$personas = getListaPersona($filtro);
for ($i = 0; $i < count($personas); $i++) {
    $persona = $personas[$i];
    $lista.= '<tr>';
    $lista.= "<td>{$persona['cedula']}</td>";
    $lista.= "<td>{$persona['primernombre']} {$persona['segundonombre']}</td>";
    $lista.= "<td>{$persona['primerapellido']} {$persona['segundoapellido']}</td>";
   $fechaingreso=date("d-m-Y",strtotime($persona['fechaingreso'])); 
    $lista.= "<td>{$fechaingreso}</td>";
    $fechasalida=date("d-m-Y",strtotime($persona['fechasalida'])); 
    $lista.= "<td>{$fechasalida}</td>";
    $lista.= "<td>{$persona['telefono']}</td>";
    $estado=Estado($persona['estado']);
    $lista.= "<td>{$estado}</td>";
    $lista.= '</tr>';
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css"> 
body{
    justify-content: center;
    font-family: Arial;
}
    
#border{
    padding-left: 1px;
}
table {
    border-collapse: collapse;
    border-color: black;
}
th {
    background: #151445;
    border: 4px solid;
    padding-left: 10px;
    padding-right: 10px;
    font-family: Arial;
    font-size: 90%;
    color: white;
    border-color: #121140;
}

td {
    border: 2.5px solid;
    padding-left: 10px;
    padding-right: 10px;
    font-family: Arial;
    font-size: 80%;
}
</style> 
</head>
<body>
<center>
<h3>LISTADO DE EMPLEADOS</h3><br><br>
<br>
    <table border="1">
    <tr>
        <th>C&Eacute;ULA</th><th>NOMBRES</th><th>APELLIDOS</th><th>FECHA INGRESO</th><th>FECHA SALIDA</th></th><th>CONTACTO</th><th>ESTADO</th>
    </tr>
    <?=$lista?>
</table>
</center>
</body>


