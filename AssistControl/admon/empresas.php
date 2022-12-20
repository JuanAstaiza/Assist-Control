<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'admon/clases/Ciudad.php';
require_once 'admon/clases/NivelAuditoria.php';
require_once 'admon/clases/Idioma.php';
$lista='';
$datos= Empresa::getListaEnObjetos(null);
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
    $lista.='<tr>';
    $lista.="<td>{$objeto->getNit()}</td>";    
    $lista.="<td>{$objeto->getRazonSocial()}</td>";    
    $lista.="<td>{$objeto->getDireccion()}</td>";    
    $lista.="<td>{$objeto->getCiudad()}</td>";    
    //$lista.="<td>{$objeto->getUrl()}</td>";    
    $lista.="<td>{$objeto->getEmail()}</td>";    
    $lista.="<td>{$objeto->getCss()}</td>";    
    $lista.="<td>{$objeto->getBd()}</td>";    
    $lista.="<td>{$objeto->getPrefijo()}</td>";    
    $lista.="<td>{$objeto->getNivelAuditoriaEnLetras()}</td>";    
    $lista.="<td>{$objeto->getIdiomaEnLetras()}</td>";        
    $lista.="<td>";
    $lista.="<a href='principal.php?CONTENIDO=admon/empresasFormulario.php&id={$objeto->getId()}' title='Modificar'><img src='presentacion/imagenes/modificar.png'></a>";
    $lista.="<img src='presentacion/imagenes/eliminar.png' title='Eliminar' onClick=eliminar('admon/empresasActualizar.php&id={$objeto->getId()}')>";
    $lista.="<a href='principal.php?CONTENIDO=admon/contratos.php&idEmpresa={$objeto->getId()}' title='Contratos'><img src='presentacion/imagenes/contratos.png'></a>";
    $lista.="</td>";    
    $lista.='</tr>';
}
?>
<h3>LISTA DE EMPRESAS</h3>
<br/>
<table border="1">
    <tr>
        <th>NIT</th><th>RAZ&Oacute;N SOCIAL</th><th>DIRECCION</th><th>CIUDAD</th><!--<th>P&Aacute;GINA WEB</th>--><th>CORREO ELECTR&Oacute;NICO</th><th>CSS</th><th>BASE DE DATOS</th><th>PREFIJO</th><th>AUDITORIA</th><th>IDIOMA</th>
        <th><a href="principal.php?CONTENIDO=admon/empresasFormulario.php" title="Adicionar"><img src="presentacion/imagenes/adicionar.png"></a></th>        
    </tr>
    <?=$lista?>
</table>