<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-Type: text/html; charset=UTF-8');
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
       //ADICIONAR ARCHIVO BD AL DIRECTORIO Y DEL SERVIDOR
        // ____________________________________________________________________________________________________
           // Recibo los datos de la imagen
       $nombre_bd = trim($_FILES['scriptBD']['name']);
       $tipo = $_FILES['scriptBD']['type'];
       $tamano = $_FILES['scriptBD']['size'];
       //Si existe imagen y tiene un tamaño correcto
       if (($nombre_bd == !NULL) && ($_FILES['scriptBD']['size'] <= 90000000000000000000000000000000)) 
       {
          //indicamos los formatos que permitimos subir a nuestro servidor
             // Ruta donde se guardarán las imágenes que subamos
             $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/datos/';
             // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
             move_uploaded_file($_FILES["scriptBD"]["tmp_name"], "$directorio" .$nombre_bd);
             $nombrebd_final= $nombre_bd;

       }else 
       {
          //si existe la variable pero se pasa del tamaño permitido
          if($nombre_bd == !NULL) echo "La imagen es demasiado grande "; 
       }
        $si=new SI(null, null);
        $si->setNombre($nombre);
        $si->setDescripcion($descripcion);
        $si->setVersion($version);
        $si->setAutor($autor);
        $si->setScriptBD($nombrebd_final);
        $si->grabar();
        break;
    case 'Modificar':
            //MODIFICAR BD  DEL  DIRECTORIO Y DEL SERVIDOR
        // ____________________________________________________________________________________________________
           // Recibo los datos de la imagen
       $nombre_bd = trim($_FILES['scriptBD']['name']);
       $tipo = $_FILES['scriptBD']['type'];
       $tamano = $_FILES['scriptBD']['size'];
       //Si existe imagen y tiene un tamaño correcto
       if (($nombre_bd == !NULL) && ($_FILES['scriptBD']['size'] <= 900000000000000000000)) 
       {
          //indicamos los formatos que permitimos subir a nuestro servidor
         $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/datos/'. $bdanterior;
                    //si el archivo existe, entonces se elimina
                    if (file_exists($archivo)) unlink($archivo);
                    //se mueve el nuevo archivo a la carpeta del servidor
                  $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/datos/';
                   move_uploaded_file($_FILES["scriptBD"]["tmp_name"], "$directorio" . $nombre_bd);
            
            //si el campo archivo esta vació entonces la variable toma el nombre de la imagen que ya estaba en la bd
             $nombrebd_final= $nombre_bd;
      
       }else 
       {
          //si existe la variable pero se pasa del tamaño permitido
          if($nombre_bd == !NULL) echo "La imagen es demasiado grande "; 
             $nombrebd_final= $bdanterior;

       }
        $si=new SI(null, null);
        $si->setId($id);
        $si->setNombre($nombre);
        $si->setDescripcion($descripcion);
        $si->setVersion($version);
        $si->setAutor($autor);
        $si->setScriptBD($nombrebd_final);
        $si->modificar();
        break;
    case 'Eliminar':
        $si=new SI('id', $id);
        $bd= $si->getScriptBD();     
                    //ELIMINAR BD DEL  DIRECTORIO
        // ____________________________________________________________________________________________________
       //Ubico el archivo
       $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/datos/'. $bd;
        //si el archivo existe, entonces se elimina
        if (file_exists($archivo)) unlink($archivo);
        $si->eliminar();
        break;
    default:
        break;
}
header('Location: principal.php?CONTENIDO=admon/si.php');