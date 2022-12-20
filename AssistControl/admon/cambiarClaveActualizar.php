<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Usuario.php';

foreach ($_POST as $Variable => $Valor) ${$Variable}=$Valor;
foreach ($_GET as $Variable => $Valor) ${$Variable}=$Valor;

switch ($accion) {
    case 'Cambiar':
        $Usuario=new Usuario('usuario', $usuarioAnterior);
        $Usuario->setClave($claveconf);
        $Usuario->modificarClave($usuarioAnterior);
}
header("Location: principal.php?CONTENIDO=admon/cambiarClave.php&mensaje");
