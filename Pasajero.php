<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';

class Pasajero extends Persona {

private $IDpasajero;
private $telefonoPasajero;
private $mensaje;

public function __construct(
    $IDpasajero = 0, 
    $telefonoPasajero = ""
    ) {
    parent::__construct("", "");
    $this->IDpasajero = $IDpasajero;
    $this->telefonoPasajero = $telefonoPasajero;
    $this->mensaje = "";
}

public function getIDpasajero() {
    return $this->IDpasajero;
}

public function setIDpasajero($IDpasajero) {
    $this->IDpasajero = $IDpasajero;
} 


public function getTelefonoPasajero() {
    return $this->telefonoPasajero;
}

public function setTelefonoPasajero($telefonoPasajero) {
    $this->telefonoPasajero = $telefonoPasajero;
}

public function setMensaje($mensaje) {
    $this->mensaje = $mensaje;
}

public function getMensaje() {
    return $this->mensaje;
}


public function cargarPasajero($nombrePersona, $apellidoPersona, $IDpasajero, $telefonoPasajero) {
    $this->setNombrePersona($nombrePersona);
    $this->setApellidoPersona($apellidoPersona);
    $this->setIDpasajero($IDpasajero);
    $this->setTelefonoPasajero($telefonoPasajero);
}

public function buscarPasajero($IDpasajero){
    $base=new BaseDatos();
    $consultaPasajero = " SELECT * FROM Pasajero WHERE IDpasajero = " . intval($IDpasajero);
    $resp= false;

        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                if($row2=$base->Registro()){					
                    $this->setIDpasajero($IDpasajero);
                    parent::setNombrePersona($row2['nombrePersona']);
                    parent::setApellidoPersona($row2['apellidoPersona']);
                    $this->setTelefonoPasajero($row2['telefonoPasajero']);
                    $resp= true;
                }
            }
        } else {
            $this->setMensaje($base->getERROR());

        }

        return $resp;
    }

public function listarPasajero($condicion = ""){
    $arregloPasajeros = null;
    $base = new BaseDatos();
    $consultaPasajero = "SELECT * FROM Pasajero";
    if ($condicion != "") {
        $consultaPasajero .= ' WHERE ' . $condicion;
    }
    $consultaPasajero .= " ORDER BY IDpasajero ";
    if ($base->Iniciar()) {
        if ($base->Ejecutar($consultaPasajero)) {
            $arregloPasajeros = array();
            while ($row2 = $base->Registro()) {
                $objPasajero = new Pasajero();
                $objPasajero->cargarPasajero(
                    $row2['nombrePersona'], 
                    $row2['apellidoPersona'],
                    $row2['IDpasajero'], 
                    $row2['telefonoPasajero']
                );
                array_push($arregloPasajeros, $objPasajero);
            }
        } else {
            $this->setMensaje("Pasajero->listar: ".$base->getError());
        }
    } else {
        $this->setMensaje("Pasajero->listar: ".$base->getError());
    }
    return $arregloPasajeros;
}
public function insertarPasajero(){
    $base = new BaseDatos();
    $resp = false;
    $consultaInsertar = "INSERT INTO Pasajero (IDpasajero, nombrePersona, apellidoPersona, telefonoPasajero) 
    VALUES (
    " . $this->getIDpasajero() . ", 
    '" . parent::getNombrePersona() . "', 
    '" . parent::getApellidoPersona() . "', 
    '" . $this->getTelefonoPasajero() . "'
    )";

        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($consultaInsertar)) {
                $resp = true;
            } else {
            $this->setMensaje("Pasajero->insertar: " . $base->getError());
            }
        } else {
            $this->setMensaje("Pasajero->insertar: ".$base->getError());
        }
        return $resp;
    }

public function modificarPasajero(){
    $base = new BaseDatos();
    $resp = false;
    $consultaModificar = "UPDATE pasajero SET 
    nombrePersona='" . parent::getNombrePersona() .
    "', apellidoPersona='" . parent::getApellidoPersona() .
    "', telefonoPasajero='" . $this->getTelefonoPasajero() .
    "' WHERE IDpasajero=" . $this->getIDpasajero();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($consultaModificar)) {
            $resp = true;
        } else {
            $this->setMensaje("Pasajero->modificar: " . $base->getError());
        }
    } else {
        $this->setMensaje("Pasajero->modificar: " . $base->getError());
    }
    return $resp;
}   

public function eliminarPasajero(){
    $base = new BaseDatos();
    $resp = false;
    $consultaEliminar = " DELETE FROM Pasajero WHERE IDpasajero=" . $this->getIDpasajero();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminar)) {
                $resp = true;
        } else {
            setMensaje("Pasajero->eliminar: ".$base->getError());
            }
        } else {
            setMensaje("Pasajero->eliminar: ".$base->getError());
        }
return $resp;

}

public function __toString() {
    return parent::__toString() .
    "ID Pasajero: " . $this->getIDpasajero() . "\n" .
    "Teléfono: " . $this->getTelefonoPasajero() . "\n";

}


}
