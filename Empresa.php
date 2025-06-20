<?php

include_once 'BaseDatos.php';

class Empresa {

private $IDEmpresa;
private $nombreEmpresa;
private $direccionEmpresa;
private $mensaje;

public function __construct(
    $IDEmpresa = 0, 
    $nombreEmpresa = "", 
    $direccionEmpresa = "", 
    $mensaje = ""
) {
    $this->IDEmpresa = $IDEmpresa;
    $this->nombreEmpresa = $nombreEmpresa;
    $this->direccionEmpresa = $direccionEmpresa;
    $this->mensaje = $mensaje;
}

public function getIDEmpresa() {
    return $this->IDEmpresa;
}

public function setIDEmpresa($IDEmpresa) {
    $this->IDEmpresa = $IDEmpresa;
}

public function getNombreEmpresa() {
    return $this->nombreEmpresa;
}

public function setNombreEmpresa($nombreEmpresa) {
    $this->nombreEmpresa = $nombreEmpresa;
}

public function getDireccionEmpresa() {
    return $this->direccionEmpresa;
}

public function setDireccionEmpresa($direccionEmpresa) {
    $this->direccionEmpresa = $direccionEmpresa;
}

public function getMensaje() {
    return $this->mensaje;
}

public function setMensaje($mensaje) {
    $this->mensaje = $mensaje;
}

public function cargarEmpresa($IDEmpresa, $nombreEmpresa, $direccionEmpresa) {
    $this->setIDEmpresa($IDEmpresa);
    $this->setNombreEmpresa($nombreEmpresa);
    $this->setDireccionEmpresa($direccionEmpresa);
}

public function insertarEmpresa() {
    $base = new BaseDatos();
    $resp = false;
    $consultaEmpresa = "INSERT INTO Empresa(IDEmpresa, nombreEmpresa, direccionEmpresa) 
    VALUES ('". $this->getIDEmpresa() ."', '". $this->getNombreEmpresa() ."', '". $this->getDireccionEmpresa() ."')";
    
    if($base->IniciarBase()) {
        if($base->EjecutarBase($consultaEmpresa)) {
            $resp = true;
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }
    
    return $resp;
}

public function buscarEmpresa($IDEmpresa) {
    $base = new BaseDatos();
    $consultaEmpresa = "SELECT * FROM Empresa WHERE IDEmpresa = " . intval($IDEmpresa);
    $resp = false;

    if($base->Iniciar()) {
        if($base->Ejecutar($consultaEmpresa)) {
            if($row2 = $base->Registro()) {
                $this->setIDEmpresa($row2['IDEmpresa']);
                $this->setNombreEmpresa($row2['nombreEmpresa']);
                $this->setDireccionEmpresa($row2['direccionEmpresa']);
                $resp = true;
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }

    return $resp;
}

public function listarEmpresa($condicion = "") {
    $arregloEmpresas = null;
    $base = new BaseDatos();
    $consultaEmpresa = "SELECT * FROM Empresa";

    if ($condicion != "") {
        $consultaEmpresa .= ' WHERE ' . $condicion;
    }
    $consultaEmpresa .= " ORDER BY IDEmpresa";

    if ($base->Iniciar()) {
        if ($base->Ejecutar($consultaEmpresa)) {
            $arregloEmpresas = array();
            while ($row2 = $base->Registro()) {
                $empresa = new Empresa();
                $empresa->cargarEmpresa(
                    $row2['IDEmpresa'], 
                    $row2['nombreEmpresa'], 
                    $row2['direccionEmpresa']
                );
                array_push($arregloEmpresas, $empresa);
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }

    return $arregloEmpresas;
}

public function eliminarEmpresa() {
    $base = new BaseDatos();
    $resp = false;
    $consultaEmpresa = "DELETE FROM Empresa WHERE IDEmpresa = " . $this->getIDEmpresa();

    if ($base->Iniciar()) {
        if ($base->Ejecutar($consultaEmpresa)) {
            $resp = true;
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }

    return $resp;
}

public function __toString() {
    return "ID Empresa: " . $this->getIDEmpresa() . 
           ", Nombre: " . $this->getNombreEmpresa() . 
           ", Dirección: " . $this->getDireccionEmpresa();
}


}
