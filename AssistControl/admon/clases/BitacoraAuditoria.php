<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BitacoraAuditoria
 *
 * @author adsi
 */
class BitacoraAuditoria {
    private $id;
    private $fecha;
    private $usuario;
    private $suceso;
    private $ip;
    private $detalle;
    private $registroAnterior;
    private $archivo;
    private $sesion;
    
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, fecha, usuario, suceso, ip, detalle, registroAnterior, archivo, sesion from {$P}bitacoraauditoria where $campo=$valor;";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }
    }
    
    
    private function cargarAtributosConMayusculas($arreglo){
        $this->registroAnterior=$arreglo['registroanterior'];
    }
    
    function getId() {
        return $this->id;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getUsuario() {
        return new Usuario('usuario', $this->usuario);
    }

    function getSuceso() {
        return new SucesoAuditoria($this->suceso);
    }

    function getIp() {
        return $this->ip;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getRegistroAnterior() {
        return $this->registroAnterior;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function getSesion() {
        return $this->sesion;
    }
    
    function getFinSesion() {
        $datos= BitacoraAuditoria::getListaEnObjetos(" sesion=$this->id and suceso='S' ", null);
        if (count($datos)>0) return $datos[0];
        else return new BitacoraAuditoria(null,null);    
    }
    
    function getDuracionSesion(){
        $fechaInicio=new DateTime($this->fecha);
        $fechaFin=$this->getFinSesion()->getFecha();
        if ($fechaFin!=null){
        $fechaFin=new DateTime($fechaFin);
        $diferencia=$fechaInicio->diff($fechaFin);
        return $diferencia->format('%H:%I:%S');
        }else return null;
    }
 
    function setId($id) {
        $this->id = $id;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSuceso($suceso) {
        $this->suceso = $suceso;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    function setRegistroAnterior($registroAnterior) {
        $this->registroAnterior = $registroAnterior;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function setSesion($sesion) {
        $this->sesion = $sesion;
    }
    
    
    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}bitacoraauditoria (fecha, usuario, suceso, ip, detalle,registroAnterior, archivo,sesion) values ('$this->fecha','$this->usuario','$this->suceso','$this->ip','$this->detalle','$this->registroAnterior','$this->archivo',$this->sesion);";
        $cadenaSQL= str_replace(';','', $cadenaSQL);
        Conector::ejecutarQueryMultiple($cadenaSQL, null);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}bitacoraauditoria set  fecha='$this->fecha', usuario='$this->usuario',suceso='$this->suceso',ip='$this->ip',detalle='$this->detalle',registroAnterior='$this->registroAnterior',archivo='$this->archivo',sesion=$this->sesion where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}bitacoraauditoria where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    
    public static function getLista($filtro,  $orden){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, fecha, usuario, suceso, ip, detalle,registroAnterior, archivo,sesion from {$P}bitacoraauditoria $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos = BitacoraAuditoria::getLista($filtro,  $orden);
        $bitacora=array();
        for ($i = 0; $i < count($datos); $i++) {
            $bitacora[$i]=new BitacoraAuditoria($datos[$i], null);
        }
        return $bitacora;
    }
    
  private static function getDatosAnteriores($detalle){
        $BD=null;$P='';                
        if (substr($detalle,0, strpos($detalle, ' '))=='update') $fin=6;
        else $fin=11;
        $tabla= trim(substr(trim($detalle), $fin, strpos($detalle, ' ', $fin)+1));
        $where= substr($detalle, strpos($detalle, 'where'));
        $cadenaSQL="select * from $tabla $where";
        $resultado= Conector::ejecutarQuery($cadenaSQL, $BD);
        //return join('|', $resultado[0]);        
    }


    public static function  registrar($usuario, $suceso, $detalle, $archivo){
       $BD=null;$P='';
        $bitacora=new BitacoraAuditoria(null, null);
        $bitacora->setSesion('null');
        $bitacora->setFecha(date('Y-m-d H:i:s'));
        $bitacora->setUsuario($usuario);
        $bitacora->setSuceso($suceso);
        $bitacora->setIp($_SERVER['REMOTE_ADDR']);
        switch ($suceso) {
            case 'insert': $bitacora->setSuceso('A');break;                
            case 'update':    
                $bitacora->setSuceso('M');     
                $bitacora->setRegistroAnterior(BitacoraAuditoria::getDatosAnteriores($detalle));
                break;
            case 'delete':
                $bitacora->setSuceso('E');    
                $bitacora->setRegistroAnterior(BitacoraAuditoria::getDatosAnteriores($detalle));
                break;  
        }
        //if ($bitacora->getSuceso()=='A' || $bitacora->getSuceso()=='M' || $bitacora->getSuceso()=='E' || $bitacora->getSuceso()=='S') {
        if ($bitacora->getSuceso()->getCodigo()!='I') {
                $bitacora->setSesion($_SESSION['sesion']);
            if ($bitacora->getSuceso()!='S'){
                $bitacora->setDetalle(str_replace("'", '|', $detalle));
                $bitacora->setArchivo($archivo);
            }
        }    
        //}
        $bitacora->grabar();
        if($suceso='I'){
            $cadenaSQL="select max(id) as id from {$P}bitacoraAuditoria;";
            $id=Conector::ejecutarQuery($cadenaSQL, $BD)[0]['id'];
            $_SESSION['sesion']=$id;    
        }
    }
}
