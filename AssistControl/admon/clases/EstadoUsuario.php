<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadoUsuario
 *
 *  @author AssistControl
 */
class EstadoUsuario {
    private $codigo;
    
    function __construct($codigo) {
        $this->codigo = $codigo;
    }
    
    function getCodigo() {
        return $this->codigo;
    }
    
    public function getNombre(){
        if ($this->codigo) return 'Activo';
        else return 'Inactivo';
    }
    
    public function __toString() {
        return $this->getNombre();
    }
}
