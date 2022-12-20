<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set('America/Bogota');
require_once '../clases/Conector.php';
require_once 'clases/Empresa.php';
require_once 'clases/Perfil.php';
require_once 'clases/Persona.php';
require_once 'clases/Usuario.php';
require_once 'clases/BitacoraAuditoria.php';
require_once 'clases/SucesoAuditoria.php';
$P='';
$BD='adminsys';
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];

if (Usuario::validar($usuario, $clave)){
    session_start();//definición o mantención de sesión
    $usuario=new Usuario('usuario', $usuario);
    $_SESSION['usuario']= serialize($usuario);//definición de una variable de sesión
    if($usuario->getEmpresa()->getNivelAuditoria()>0)  BitacoraAuditoria::registrar($usuario->getUsuario(),'I',null,null);
    header('Location: ../principal.php?CONTENIDO=admon/inicio.php');
} else {
    BitacoraAuditoria::registrar($usuario, 'F', null, null);
    header("Location: ../index.php?mensaje");
}
