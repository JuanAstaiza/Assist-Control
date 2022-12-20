<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Permiso.php';
require_once 'assistControl/clases/Persona_A.php';
require_once 'assistControl/clases/Motivo.php';
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;

switch ($accion) {
    case 'Adicionar':
            //ADICIONAR ANEXO AL DIRECTORIO Y DEL SERVIDOR
        // ____________________________________________________________________________________________________
           // Recibo los datos de la anexo
       $nombre_anexo = trim($_FILES['anexo']['name']);
       $tipo = $_FILES['anexo']['type'];
       $tamano = $_FILES['anexo']['size'];
       //Si existe anexo y tiene un tamaño correcto
       if (($nombre_anexo == !NULL) && ($_FILES['anexo']['size'] <= 9900000000000000000000000)) 
       {
          //indicamos los formatos que permitimos subir a nuestro servidor
          if (($_FILES["anexo"]["type"] == "image/jpeg") || ($_FILES["anexo"]["type"] == "image/jpg") || ($_FILES["anexo"]["type"] == "application/pdf" ))   {
             // Ruta donde se guardarán las imágenes que subamos
             $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/archivos/';
             // Muevo la anexo desde el directorio temporal a nuestra ruta indicada anteriormente
             move_uploaded_file($_FILES["anexo"]["tmp_name"], "$directorio" . $cedulapersona ."_". $nombre_anexo);
       //      move_uploaded_file($_FILES['anexo']['tmp_name'],$directorio.$nombre_img);      
             $nombreanexo_final= $cedulapersona ."_". $nombre_anexo;
           }
           else 
           {  //si no cumple con el formato
              echo "No se puede subir una anexo con ese formato ";
           }
       } 
       else 
       {
          //si existe la variable pero se pasa del tamaño permitido
          if($nombre_anexo == !NULL) echo "La anexo es demasiado grande "; 
       }
       //__________________________________________________________________________________________________________________
       $permiso=new Permiso(null, null);
       $permiso->setAnexo($nombreanexo_final);
        $permiso->setCedulaPersona($cedulapersona);
        $permiso->setFechaSolicitud($fechaSolicitud);
        $permiso->setFechaInicio($fechaInicio);
        $permiso->setFechaFin($fechaFin);
        $permiso->setCodMotivo($codMotivo);
        $permiso->setDescripcion($descripcion);
        $permiso->grabar();
        break;
    case 'Modificar':
             //MODIFICAR IMAGEN DEL  DIRECTORIO Y DEL SERVIDOR
        // ____________________________________________________________________________________________________
           // Recibo los datos de la imagen
       $nombre_anexo = trim($_FILES['anexo']['name']);
       $tipo = $_FILES['anexo']['type'];
       $tamano = $_FILES['anexo']['size'];
       //Si existe imagen y tiene un tamaño correcto
       if (($nombre_anexo == !NULL) && ($_FILES['anexo']['size'] <= 900000000000000000000)) 
       {
          //indicamos los formatos que permitimos subir a nuestro servidor
          if (($_FILES["anexo"]["type"] == "image/jpeg") || ($_FILES["anexo"]["type"] == "image/jpg") || ($_FILES["anexo"]["type"] == "application/pdf" ))   {
                    //se define la ruta en donde se encuentra la vieja imagen
                    $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/archivos/'. $anexoanterior;
                    //si el archivo existe, entonces se elimina
                    if (file_exists($archivo)) unlink($archivo);
                    //se mueve el nuevo archivo a la carpeta del servidor
                  $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/archivos/';
                   move_uploaded_file($_FILES["anexo"]["tmp_name"], "$directorio" . $cedulaanterior ."_". $nombre_anexo);
            
            //si el campo archivo esta vació entonces la variable toma el nombre de la imagen que ya estaba en la bd
             $nombreanexo_final= $cedulaanterior ."_". $nombre_anexo;
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
          if($nombre_anexo == !NULL) echo "La imagen es demasiado grande "; 
             $nombreanexo_final= $anexoanterior;

       }    
 
        $permiso=new Permiso('codigo', $codigo);
        $permiso->setAnexo($nombreanexo_final);
        $permiso->setCedulaPersona($cedulapersona);
        $permiso->setFechaSolicitud($fechaSolicitud);
        $permiso->setFechaInicio($fechaInicio);
        $permiso->setFechaFin($fechaFin);
        $permiso->setCodMotivo($codMotivo);
        $permiso->setDescripcion($descripcion);
        $permiso->modificar();
        break;
    case 'Eliminar':
       $permiso=new Permiso('codigo', $codigo);
       $anexo= $permiso->getAnexo();     
                    //ELIMINAR IMAGEN DEL  DIRECTORIO
        // ____________________________________________________________________________________________________
       //Ubico el archivo
       $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/archivos/'. $anexo;
        //si el archivo existe, entonces se elimina
        if (file_exists($archivo)) unlink($archivo);
        $permiso->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=assistControl/permisos.php");
