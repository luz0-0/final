<?php

include_once 'BaseDatos.php';

class Persona {

private $nombrePersona;
private $apellidoPersona;


public function __construct(
    $nombrePersona, 
    $apellidoPersona
    ) {
    $this->nombrePersona = $nombrePersona;
    $this->apellidoPersona = $apellidoPersona;
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

public function cargarPersona($nombrePersona, $apellidoPersona) {
    $this->setNombrePersona($nombrePersona);
    $this->setApellidoPersona($apellidoPersona);
}

public function insertarPersona(){
		$base = new BaseDatos();
		$resp = false;
		$consultaPersona = "INSERT INTO Persona(nombrePersona, apellidoPersona) 
		VALUES ('". $this->getNombrePersona() ."', '". $this->getApellidoPersona() ."')";
		if($base->IniciarBase()){
			if($base->EjecutarBase($consultaPersona)){
				$resp = true;
			}   else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
		return $resp;
	}

    





public function __toString() {
    return
    "Nombre: " . $this->getNombrePersona() . "\n" .
    "Apellido: " . $this->getApellidoPersona() . "\n";
}





}
