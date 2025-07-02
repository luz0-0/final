<?php

include_once 'BaseDatos.php';

class Persona {

    private $nombrePersona;
    private $apellidoPersona;
    private $IDpersona;
    private $mensaje;

    public function __construct() {
        $this->nombrePersona = "";
        $this->apellidoPersona = "";
        $this->IDpersona = "";
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

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function cargar($nombrePersona, $apellidoPersona, $IDpersona) {
        $this->setNombrePersona($nombrePersona);
        $this->setApellidoPersona($apellidoPersona);
        $this->setIDpersona($IDpersona);
    }

public function insertar() {
    $baseDatos = new BaseDatos();
    $resp = false;
    $consultaPersona = "INSERT INTO Persona(nombrePersona, apellidoPersona) 
        VALUES ('" . $this->getNombrePersona() . "', '" . $this->getApellidoPersona() . "')";
    if ($baseDatos->IniciarBase()) {
        if ($baseDatos->EjecutarBase($consultaPersona)) {
            $resp = true;
        } else {
            $this->setMensaje($baseDatos->getERROR());
        }
    } else {
        $this->setMensaje($baseDatos->getERROR());
    }
    return $resp;
}

    public function modificar() {
        $baseDatos = new BaseDatos();
        $resp = false;
        $consultaModificar = "UPDATE Persona SET 
            nombrePersona = '" . $this->getNombrePersona() . "', 
            apellidoPersona = '" . $this->getApellidoPersona() . "' 
            WHERE IDpersona = " . intval($this->getIDpersona());
        if ($baseDatos->IniciarBase()) {
            if ($baseDatos->EjecutarBase($consultaModificar)) {
                $resp = true;
            } else {
                $this->setMensaje($baseDatos->getERROR());
            }
        } else {
            $this->setMensaje($baseDatos->getERROR());
        }
        return $resp;
    }

    public function eliminar() {
        $baseDatos = new BaseDatos();
        $resp = false;
        $consultaEliminar = "DELETE FROM Persona WHERE IDpersona = " . intval($this->getIDpersona());
        if ($baseDatos->IniciarBase()) {
            if ($baseDatos->EjecutarBase($consultaEliminar)) {
                $resp = true;
            } else {
                $this->setMensaje($baseDatos->getERROR());
            }
        } else {
            $this->setMensaje($baseDatos->getERROR());
        }
        return $resp;
    }

    public function buscar($IDpersona) {
        $baseDatos = new BaseDatos();
        $resp = false;
        $consultaBuscar = "SELECT * FROM Persona WHERE IDpersona = " . intval($IDpersona);
        if ($baseDatos->IniciarBase()) {
            if ($baseDatos->EjecutarBase($consultaBuscar)) {
                if ($row = $baseDatos->Registro()) {
                    $this->setNombrePersona($row['nombrePersona']);
                    $this->setApellidoPersona($row['apellidoPersona']);
                    $this->setIDpersona($row['IDpersona']);
                    $resp = true;
                }
            } else {
                $this->setMensaje($baseDatos->getERROR());
            }
        } else {
            $this->setMensaje($baseDatos->getERROR());
        }
        return $resp;
    }

    public function listar($condicion = "") {
        $arreglo = [];
        $baseDatos = new BaseDatos();
        $consultaPersona = "SELECT * FROM Persona";
        if ($condicion != "") {
            $consultaPersona .= ' WHERE ' . $condicion;
        }
        $consultaPersona .= " ORDER BY IDpersona ";
        if ($baseDatos->IniciarBase()) {
            if ($baseDatos->EjecutarBase($consultaPersona)) {
                while ($row = $baseDatos->Registro()) {
                    $objPersona = new Persona();
                    $objPersona->cargar($row['nombrePersona'], $row['apellidoPersona'], $row['IDpersona']);
                    array_push($arreglo, $objPersona);
                }
            } else {
                $this->setMensaje($baseDatos->getERROR());
            }
        } else {
            $this->setMensaje($baseDatos->getERROR());
        }
        return $arreglo;
    }

    public function __toString() {
        return
            "Nombre: " . $this->getNombrePersona() . "\n" .
            "Apellido: " . $this->getApellidoPersona() . "\n" .
            "Documento persona: " . $this->getIDpersona() . "\n";
    }
}
