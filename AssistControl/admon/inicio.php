<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$PERFIL=$USUARIO->getPerfil();
$bienvenida='';
if ($PERFIL=="Administrador de SI") {
    $bienvenida="BIENVENIDO AL ADMINISTRADOR DE SISTEMAS DE INFORMACI&Oacute;N";
}else{
    if ($PERFIL=="Directivo Docente") {
        $bienvenida="BIENVENIDO AL ADMINISTRADOR DE SISTEMAS DE INFORMACI&Oacute;N ASSIST CONTROL";
    } else {
         $bienvenida="BIENVENIDO AL SISTEMAS DE INFORMACI&Oacute;N ASSIST CONTROL";
    }
}
?>

<h3><?=$bienvenida?></h3>