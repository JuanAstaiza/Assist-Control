<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'assistControl/clases/Reporte_pdf.php';
header('Content-Type: text/html; charset=UTF-8');
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;

switch ($accion) {
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
                    $archivo = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/reportes/img/'. $imagenanterior;
                    //si el archivo existe, entonces se elimina
                    if (file_exists($archivo)) unlink($archivo);
                    //se mueve el nuevo archivo a la carpeta del servidor
                  $directorio = $_SERVER['DOCUMENT_ROOT'].'/AssistControl/assistControl/reportes/img/';
                   move_uploaded_file($_FILES["imagen"]["tmp_name"], "$directorio" . $nombre_img);
            
            //si el campo archivo esta vació entonces la variable toma el nombre de la imagen que ya estaba en la bd
             $nombreimg_final=  $nombre_img;
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
             $nombreimg_final = $imagenanterior;

       }

       //__________________________________________________________________________________________________________________

        $reporte=new Reporte_pdf(null, null);
        $reporte->setImg_banner($nombreimg_final);
        $reporte->setDireccion_sede($direccion);
        $reporte->setPagina_web($paginaweb);
        $reporte->setTelefono($telefono);
        $reporte->setEmail($correo);
        $reporte->modificar($codigoAnterior);
        break;
}

header("Location: principal.php?CONTENIDO=assistControl/gestionreporte_pdf.php");
?>
