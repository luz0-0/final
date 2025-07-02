<?php

include_once 'BaseDatos.php';

class ViajePasajeros {
  
    private $objPasajero;
    private $objViaje;
    private $mensaje;

    public function __construct(
    $objPasajero = null,
    $objViaje = null
) {
    $this->objPasajero = $objPasajero;
    $this->objViaje = $objViaje;
    $this->mensaje = "";
}

    public function getObjPasajero() {
        return $this->objPasajero;
    }

    public function setObjPasajero($objPasajero) {
        $this->objPasajero = $objPasajero;
    }

    public function getObjViaje() {
        return $this->objViaje;
    }

    public function setObjViaje($objViaje) {
        $this->objViaje = $objViaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function cargarViajePasajero($objPasajero, $objViaje) {
        $this->setObjPasajero($objPasajero);
        $this->setObjViaje($objViaje);
    }

public function insertar() {
    $base = new BaseDatos();
    $resp = false;
    $consulta = "INSERT INTO ViajePasajeros(IDviaje, docPasajero) 
        VALUES (" . intval($this->getObjViaje()->getIDviaje()) . ", " . intval($this->getObjPasajero()->getdocPasajero()) . ")";
    
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consulta)) {
            $resp = true;
        } else {
            $this->mensaje = "Error al insertar el viaje pasajero: " . $base->getERROR();
        }
    } else {
        $this->mensaje = "Error al iniciar la base de datos: " . $base->getERROR();
    }
    
    return $resp;
}

public function eliminar() {
    $base = new BaseDatos();
    $resp = false;
    $consulta = "DELETE FROM ViajePasajeros WHERE IDviaje = " . intval($this->getObjViaje()->getIDviaje()) . 
                " AND docPasajero = " . intval($this->getObjPasajero()->getdocPasajero());
    
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consulta)) {
            $resp = true;
        } else {
            $this->mensaje = "Error al eliminar el viaje pasajero: " . $base->getERROR();
        }
    } else {
        $this->mensaje = "Error al iniciar la base de datos: " . $base->getERROR();
    }
    
    return $resp;
}

public function listar($condicion = "") {
    $arregloViajePasajeros = null;
    $base = new BaseDatos();
    $consulta = "SELECT * FROM ViajePasajeros";
    if ($condicion != "") {
        $consulta .= ' WHERE ' . $condicion;
    }
    $consulta .= " ORDER BY IDviaje, docPasajero";
    
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consulta)) {
            $arregloViajePasajeros = array();
            while ($row = $base->Registro()) {
                $objViajePasajero = new ViajePasajeros();
                
                $viaje = new Viaje();
                $viaje->buscarViaje($row['IDviaje']);
                
                $pasajero = new Pasajero();
                $pasajero->buscar($row['docPasajero']);
                
                $objViajePasajero->cargarViajePasajero($pasajero, $viaje);
                array_push($arregloViajePasajeros, $objViajePasajero);
            }
        } else {
            $this->mensaje = "Error al listar: " . $base->getERROR();
        }
    } else {
        $this->mensaje = "Error al iniciar la base de datos: " . $base->getERROR();
    }
    
    return $arregloViajePasajeros;
}

public function __toString() {
    return "ID Viaje: " . $this->getObjViaje()->getIDviaje() . "\n" .
           "Doc Pasajero: " . $this->getObjPasajero()->getdocPasajero() . "\n" .
           "Mensaje: " . $this->getMensaje() . "\n";
}

}
