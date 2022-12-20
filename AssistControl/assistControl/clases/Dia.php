<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dia
 *
 * @author JUAN CARLOS ASTAIZA
 */
class Dia {
    
    
    
    public static function getListaEnOptions($accion,$predeterminado) {        
        if ($accion=="Adicionar") {            
            switch ($predeterminado) {            
                case '1': return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '2': return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4" >Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '3': return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '4': return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4" >Jueves</option><option value="5">Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '5': return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6">Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '6': return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7">Domingo</option>';
                    break;
                case '7': return 
                    '<option value="1" >Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                default: return 
                    '<option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
            }
        }else{
            switch ($predeterminado) {            
                case '1': return 
                    '<option value="1" selected>Lunes</option><option value="2" >Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '2': return 
                    '<option value="1" >Lunes</option><option value="2" selected>Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '3': return 
                    '<option value="1" >Lunes</option><option value="2" >Martes</option><option value="3" selected>Miercoles</option><option value="4" >Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '4': return 
                    '<option value="1" >Lunes</option><option value="2" >Martes</option><option value="3" >Miercoles</option><option value="4" selected>Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '5': return 
                    '<option value="1" >Lunes</option><option value="2"  >Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option><option value="5" selected>Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '6': return 
                    '<option value="1" >Lunes</option><option value="2" >Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option><option value="5" >Viernes</option><option value="6" selected>Sabado</option><option value="7" >Domingo</option>';
                    break;
                case '7': return 
                    '<option value="1" >Lunes</option><option value="2" >Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" selected>Domingo</option>';
                    break;
                default: return 
                    '<option value="1">Lunes</option><option value="2" >Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option><option value="5" >Viernes</option><option value="6" >Sabado</option><option value="7" >Domingo</option>';
                    break;
            }
        }   
    }
}

