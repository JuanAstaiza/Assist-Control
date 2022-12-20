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
        $empresa=new Empresa(null, null);
        $empresa->setNit($nit);
        $empresa->setRazonSocial($razonSocial);
        $empresa->setDireccion($direccion);
        $empresa->setCodCiudad($codCiudad);
        $empresa->setUrl($url);
        $empresa->setEmail($email);
        $empresa->setCss($css);
        $empresa->setBd($bd);
        $empresa->setPrefijo($prefijo);
        $empresa->setNivelAuditoria($nivelAuditoria);
        $empresa->setIdioma($idioma);
        $empresa->grabar();
        break;
    case 'Modificar':
        $empresa=new Empresa(null, null);
        $empresa->setId($id);
        $empresa->setNit($nit);
        $empresa->setRazonSocial($razonSocial);
        $empresa->setDireccion($direccion);
        $empresa->setCodCiudad($codCiudad);
        $empresa->setUrl($url);
        $empresa->setEmail($email);
        $empresa->setCss($css);
        $empresa->setBd($bd);
        $empresa->setPrefijo($prefijo);
        $empresa->setNivelAuditoria($nivelAuditoria);
        $empresa->setIdioma($idioma);
        $empresa->modificar();
        break;
    case 'Eliminar':
        $empresa=new Empresa('id', $id);
        $empresa->eliminar();
        break;
    default:
        break;
}
header("Location: principal.php?CONTENIDO=admon/empresas.php");