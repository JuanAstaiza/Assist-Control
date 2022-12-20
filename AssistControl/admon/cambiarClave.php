<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $accion='Cambiar';
    $usuario= unserialize($_SESSION['usuario']);
    $clave=$usuario->getClave();
    $mensaje="";
    if (isset($_GET['mensaje'])) {
        $mensaje="Contrase&ntilde;a Actualizada";
    }
    
    ?>
<script type="text/javascript" src="lib/md5.pack.js"></script>
<script type="text/javascript">
   
function validar(){
    var claveIngresada=document.getElementById('claveactual').value;
    var claveIngresadaDesencriptada=md5(claveIngresada);  
    var claveOriginal=document.getElementById('claveoriginal').value;   
    var clavenueva=document.getElementById('clavenueva').value;   
    var claveconf=document.getElementById('claveconf').value;   
    if (claveIngresadaDesencriptada==claveOriginal) {
        if(clavenueva==claveconf){
            return true; 
        }else{
           document.getElementById("msg").innerHTML = "Contrase&ntilde;a de Confirmacion Incorrecta.";
            return  false;
        }
   }else{
        document.getElementById("msg").innerHTML = "Contrase&ntilde;a Actual Incorrecta.";
        return false;
    }
    
}


</script>
    <h3><?= strtoupper($accion)?> CLAVE</h3><br/><br/>
<form name="formulario" method="post" action="principal.php?CONTENIDO=admon/cambiarClaveActualizar.php" onsubmit="return validar(this)">
<center><div  style="color:blue; font-weight:bold;font-size:14px;"><?=$mensaje?></div></center>
<center><div id="msg" style="color:red; font-weight:bold;font-size:14px;"></div></center>
<table>
    <tr><th>Contrase&ntilde;a Actual:</th><td><input type="password" id="claveactual" name="claveactual" value='' required/></td></tr>
    <tr><th>Contrase&ntilde;a Nueva:</th><td><input type="password" id="clavenueva" name="clavenueva" value=''  required/></td></tr>
    <tr><th>Confirmar Contrase&ntilde;a:</th><td><input type="password" id="claveconf" name="claveconf" value='' required/></td></tr>
    
</table><br><br>
    <input type="hidden" name="usuarioAnterior" value="<?=$usuario->getUsuario()?>"/>
    <input type="hidden" id="claveoriginal" name="claveoriginal" value="<?=$clave?>"/>
    <input type="submit" name="accion" value="<?=$accion?>"/>
</form> 
