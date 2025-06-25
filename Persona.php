<?php

include_once 'BaseDatos.php';

class Persona {

    private $nombrePersona;
    private $apellidoPersona;
    private $IDpersona;
    private $mensaje;

    public function __construct(
        $nombrePersona = "", 
        $apellidoPersona = "",
        $IDpersona = 0
    ) {
        $this->nombrePersona = $nombrePersona;
        $this->apellidoPersona = $apellidoPersona;
        $this->IDpersona = $IDpersona;
        $this->mensaje = "";
    }

    public function getNombrePersona() {
        return $this->nombrePersona;
    }

    public function setNombrePersona($nombrePersona) {
        $this->nombrePersona = $nombrePersona;
    }

    public function getApellidoPersona() {
        return $this->apellidoPersona;
    }

    public function setApellidoPersona($apellidoPersona) {
        $this->apellidoPersona = $apellidoPersona;
    }

    public function getIDpersona() {
        return $this->IDpersona;
    }

    public function setIDpersona($IDpersona) {
        $this->IDpersona = $IDpersona;
    }

    public function cargarPersona($nombrePersona, $apellidoPersona, $IDpersona) {
        $this->setNombrePersona($nombrePersona);
        $this->setApellidoPersona($apellidoPersona);
        $this->setIDpersona($IDpersona);
    }

    public function insertarPersona() {
        $base = new BaseDatos();
        $resp = false;
        $consultaPersona = "INSERT INTO Persona(nombrePersona, apellidoPersona, IDpersona) 
            VALUES ('" . $this->getNombrePersona() . "', '" . $this->getApellidoPersona() . "', '" . $this->getIDpersona() . "')";
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaPersona)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function __toString() {
        return
            "Nombre: " . $this->getNombrePersona() . "\n" .
            "Apellido: " . $this->getApellidoPersona() . "\n" .
            "Documento persona: " . $this->getIDpersona() . "\n";
    }

}
