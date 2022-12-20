<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Archivo
 *
 *  @author AssistControl
 */
class Archivo {
    public static function getListaArchivos($ruta,$formato){
        $datos=array();
        $formatos=explode(',', $formato);
        $archivos=scandir($ruta);
        for ($i = 0; $i < count($archivos); $i++) {
            $archivo=$archivos[$i];
            $extension=substr($archivo,strpos($archivo,'.')+1);//jpg en mariposa.jpg            
            if (in_array($extension, $formatos)) $datos[]=$archivo;
        }
        return $datos;
    }
    public static function getListaArchivosEnOptions($ruta,$formato,$predeterminado){
        $archivos= Archivo::getListaArchivos($ruta, $formato);
        $lista='';
        for ($i = 0; $i < count($archivos); $i++) {
            if ($archivos[$i]==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option $auxiliar>{$archivos[$i]}</option>";        
        }
        return $lista;
    }
}
