<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Cargo.php';
require_once 'admon/clases/Persona.php';
require_once 'admon/clases/Perfil.php';
header('Content-Type: text/html; charset=UTF-8');
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;

switch ($accion) {
    case 'Adicionar':
       //ADICIONAR IMAGEN AL DIRECTORIO Y DEL SERVIDOR
        // ____________________________________________________________________________________________________
           // Recibo los datos de la imagen
       $nombre_img = trim($_FILES['imagen']['name']);
       $tipo = $_FILES['imagen']['type'];
       $tamano = $_FILES['imagen']['size'];
       //Si existe imagen y tiene un tamaño correcto
       if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 900000000000000000000)) 
       {
          //indicamos los formatos que permitimos subir a nuestro servidor
          if (($_FILES["imagen"]["type"] == "image/jpeg") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/png"))   {
             // Ruta donde se guardarán las imágenes que subamos
             $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/fotos/';
             // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
             move_uploaded_file($_FILES["imagen"]["tmp_name"], "$directorio" . $cedula ."_". $nombre_img);
       //      move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);      
             $nombreimg_final= $cedula ."_". $nombre_img;
           }
           else 
           {
              //si no cumple con el formato
              echo "No se puede subir una imagen con ese formato ";
           }
       } 
       else 
       {
          //si existe la variable pero se pasa del tamaño permitido
          if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
       }

       //__________________________________________________________________________________________________________________

        $Persona=new Persona_A(null, null);
        $Persona->setFoto($nombreimg_final);
        $Persona->setCedula($cedula);
        $Persona->setFechaExpedicion($fechaExpedicion);
        $Persona->setLugarExpedicion($lugarExpedicion);
        $Persona->setFechaNacimiento($fechaNacimiento);
        $Persona->setCodCiudad($codCiudad);
        $Persona->setPrimerNombre($primerNombre);
        $Persona->setSegundoNombre($segundoNombre);
        $Persona->setPrimerApellido($primerApellido);
        $Persona->setSegundoApellido($segundoApellido);
        $Persona->setDireccionResidencia($direccion);
        $Persona->setGenero($genero);
        $Persona->setGrupoSanguineo($grupoSanguineo);
        $Persona->setCodCargo($codCargo);
        $Persona->setCodTipoVinculacion($codTipoVinculacion);
        $Persona->setCodAreaEnsenanza($codAreaEnsenanza);
        $Persona->setEmail($correo);
        $Persona->setProfesion($profesion);
        $Persona->setCodSituacion($codSituacion);
        $Persona->setEstado($estado);
        $Persona->setTelefono($telefono);
        $Persona->setFechaIngreso($fechaIngreso);
        $Persona->setFechaSalida($fechaSalida);
        $Persona->grabar();
        $perfilAdminSys = new Perfil('nombre',$Persona->getCargo()->getPerfil()->getNombre());
        $personaAdminSys = new Usuario(null, null);
        $personaAdminSys->setNombres("$primerNombre $segundoNombre");
        $personaAdminSys->setApellidos("$primerApellido $segundoApellido");
        $personaAdminSys->setTelefono($telefono);
        $personaAdminSys->setEmail($correo);
        $personaAdminSys->setFechaNacimiento($fechaNacimiento);
        $personaAdminSys->setUsuario("$cedula");
        $personaAdminSys->setClave("$cedula");
        $personaAdminSys->setFechaIniciacion($fechaIngreso);
        $personaAdminSys->setFechaFinalizacion($fechaSalida);
        $personaAdminSys->setEstado($estado);
        $personaAdminSys->setIdPerfil($perfilAdminSys->getId());
        $personaAdminSys->setIdEmpresa($EMPRESA->getId());
        $personaAdminSys->grabar();
        break;
    case 'Modificar':
            //MODIFICAR IMAGEN DEL  DIRECTORIO Y DEL SERVIDOR
        // ____________________________________________________________________________________________________
           // Recibo los datos de la imagen
       $nombre_img = trim($_FILES['imagen']['name']);
       $tipo = $_FILES['imagen']['type'];
       $tamano = $_FILES['imagen']['size'];
       //Si existe imagen y tiene un tamaño correcto
       if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 900000000000000000000)) 
       {
          //indicamos los formatos que permitimos subir a nuestro servidor
          if (($_FILES["imagen"]["type"] == "image/jpeg") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/png"))   {
                    //se define la ruta en donde se encuentra la vieja imagen
                    $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/fotos/'. $imagenanterior;
                    //si el archivo existe, entonces se elimina
                    if (file_exists($archivo)) unlink($archivo);
                    //se mueve el nuevo archivo a la carpeta del servidor
                  $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/fotos/';
                   move_uploaded_file($_FILES["imagen"]["tmp_name"], "$directorio" . $cedulaanterior ."_". $nombre_img);
            
            //si el campo archivo esta vació entonces la variable toma el nombre de la imagen que ya estaba en la bd
             $nombreimg_final= $cedulaanterior ."_". $nombre_img;
           }
           else 
           {
              //si no cumple con el formato
              echo "No se puede subir una imagen con ese formato ";
           }
       } 
       else 
       {
          //si existe la variable pero se pasa del tamaño permitido
          if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
             $nombreimg_final= $imagenanterior;

       }
       
        $Persona=new Persona_A('cedula', $cedulaanterior);
        $Persona->setFoto($nombreimg_final);
        $Persona->setCedula($cedulaanterior);
        $Persona->setFechaExpedicion($fechaExpedicion);
        $Persona->setLugarExpedicion($lugarExpedicion);
        $Persona->setFechaNacimiento($fechaNacimiento);
        $Persona->setCodCiudad($codCiudad);
        $Persona->setPrimerNombre($primerNombre);
        $Persona->setSegundoNombre($segundoNombre);
        $Persona->setPrimerApellido($primerApellido);
        $Persona->setSegundoApellido($segundoApellido);
        $Persona->setDireccionResidencia($direccion);
        $Persona->setGenero($genero);
        $Persona->setGrupoSanguineo($grupoSanguineo);
        $Persona->setCodCargo($codCargo);
        $Persona->setCodTipoVinculacion($codTipoVinculacion);
        $Persona->setCodAreaEnsenanza($codAreaEnsenanza);
        $Persona->setEmail($correo);
        $Persona->setProfesion($profesion);
        $Persona->setCodSituacion($codSituacion);
        $Persona->setEstado($estado);
        $Persona->setTelefono($telefono);
        $Persona->setFechaIngreso($fechaIngreso);
        $Persona->setFechaSalida($fechaSalida);
        $Persona->modificar($cedulaanterior);
        break;
    case 'Eliminar':
        $Persona=new Persona_A('cedula', $cedula);        
        $imagen= $Persona->getFoto();     
                    //ELIMINAR IMAGEN DEL  DIRECTORIO
        // ____________________________________________________________________________________________________
       //Ubico el archivo
       $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/fotos/'. $imagen;
        //si el archivo existe, entonces se elimina
        if (file_exists($archivo)) unlink($archivo);
        $Persona->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=assistControl/empleados.php");
