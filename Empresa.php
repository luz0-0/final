<?php

include_once 'BaseDatos.php';

class Empresa {

private $IDempresa;
private $nombreEmpresa;
private $direccionEmpresa;
private $mensaje;

public function __construct(
    $IDempresa = 0, 
    $nombreEmpresa = "", 
    $direccionEmpresa = "", 
    $mensaje = ""
) {
    $this->IDempresa = $IDempresa;
    $this->nombreEmpresa = $nombreEmpresa;
    $this->direccionEmpresa = $direccionEmpresa;
    $this->mensaje = $mensaje;
}

public function getIDempresa() {
    return $this->IDempresa;
}

public function setIDEmpresa($IDempresa) {
    $this->IDempresa = $IDempresa;
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

public function cargarEmpresa($IDempresa, $nombreEmpresa, $direccionEmpresa) {
    $this->setIDEmpresa($IDempresa);
    $this->setNombreEmpresa($nombreEmpresa);
    $this->setDireccionEmpresa($direccionEmpresa);
}

public function insertarEmpresa() {
    $base = new BaseDatos();
    $resp = false;
    $consultaEmpresa = "INSERT INTO Empresa(IDempresa, nombreEmpresa, direccionEmpresa) 
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

public function buscarEmpresa($IDempresa) {
    $base = new BaseDatos();
    $consultaEmpresa = "SELECT * FROM Empresa WHERE IDempresa = " . intval($IDempresa);
    $resp = false;

    if($base->IniciarBase()) {
        if($base->EjecutarBase($consultaEmpresa)) {
            if($row2 = $base->Registro()) {
                $this->setIDEmpresa($row2['IDempresa']);
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
    $consultaEmpresa .= " ORDER BY IDempresa";
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consultaEmpresa)) {
            $arregloEmpresas = array();
            while ($row2 = $base->Registro()) {
                $empresa = new Empresa();
                $empresa->cargarEmpresa(
                    $row2['IDempresa'], 
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
    $consultaEmpresa = "DELETE FROM Empresa WHERE IDempresa = " . $this->getIDEmpresa();

    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consultaEmpresa)) {
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
