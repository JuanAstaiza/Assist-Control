<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;
switch ($accion) {
    case 'Adicionar':
        $Usuario=new Usuario(null, null);
        $Usuario->setNombres($nombres);
        $Usuario->setApellidos($apellidos);
        $Usuario->setTelefono($telefono);
        $Usuario->setEmail($email);
        $Usuario->setFechaNacimiento($fechaNacimiento);
        $Usuario->setUsuario($usuario);
        $Usuario->setClave($clave);
        $Usuario->setFechaIniciacion($fechaIniciacion);
        $Usuario->setFechaFinalizacion($fechaFinalizacion);
        $Usuario->setEstado($estado);
        $Usuario->setIdPerfil($idPerfil);
        $Usuario->setIdEmpresa($idEmpresa);
        $Usuario->grabar();
        break;
    case 'Modificar':
        $Usuario=new Usuario('usuario', $usuario);
        $Usuario->setNombres($nombres);
        $Usuario->setApellidos($apellidos);
        $Usuario->setTelefono($telefono);
        $Usuario->setEmail($email);
        $Usuario->setFechaNacimiento($fechaNacimiento);
        $Usuario->setUsuario($usuario);
        $Usuario->setClave($clave);
        $Usuario->setFechaIniciacion($fechaIniciacion);
        $Usuario->setFechaFinalizacion($fechaFinalizacion);
        $Usuario->setEstado($estado);
        $Usuario->setIdPerfil($idPerfil);
        $Usuario->setIdEmpresa($idEmpresa);
        $Usuario->modificar($usuarioAnterior);
        break;
    case 'Eliminar':
        $Usuario=new Usuario('usuario', $usuario);
        $Usuario->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/usuarios.php");