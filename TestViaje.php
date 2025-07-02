<?php

include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "Persona.php";
include_once "ResponsableV.php";
include_once "Viaje.php";
include_once "Pasajero.php";
include_once "ViajePasajeros.php";
class TestViaje {

public function Menu() {
    do {
        echo "Menú Principal\n";
        echo "\n 1. Empresa \n";
        echo "\n 2. Pasajero \n";
        echo "\n 3. Responsable \n";
        echo "\n 4. Viaje (Destino, empresa...)\n";
        echo "\n 5. Viaje (asignar, borrar pasajeros...)\n";
        echo "\n 0. Salir\n";
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case 1:
                $this->menuEmpresa();
                break;
            case 2:
                $this->menuPasajero();
                break;
            case 3:
                $this->menuResponsable();
                break;
            case 4:
                $this->menuViaje();
                break;
            case 5:
                $this->menuViajePasajeros();
                break;
            case 0: 
                echo "Saliendo del programa...\n";
                break;
            default:
                echo "Opción no válida. Intente nuevamente.\n";
                break;
        }
    } while ($opcion != 0);

}

public function menuEmpresa() {
        do {
            echo "\nMenú empresa\n";
            echo "\n 1. Insertar Empresa \n";
            echo "\n 2. Buscar Empresa \n";
            echo "\n 3. Modificar Empresa \n";
            echo "\n 4. Eliminar Empresa\n";
            echo "\n 5. Listar Empresas\n";
            echo "\n 0. Volver\n";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
               case 1:
                    echo "\n Insertar Empresa\n";
                    $empresa = new Empresa();
                    echo "\n Ingrese nombre de la empresa: \n";
                    $nombreEmpresa = trim(fgets(STDIN));
                    echo "\n Ingrese dirección de la empresa: \n";
                    $direccionEmpresa = trim(fgets(STDIN));
                    $empresa->cargarEmpresa(0, $nombreEmpresa, $direccionEmpresa);
                    if ($empresa->insertarEmpresa()) {
                        echo "\n Empresa insertada correctamente.\n";
                    } else {
                        echo "\n Error al insertar la empresa: " . $empresa->getMensaje() . "\n";
                    }
                    break;
                case 2:
                echo "\n Buscar Empresa\n";
                echo "\n Ingrese ID de la empresa: ";
                $IDempresa = trim(fgets(STDIN));
                $empresa = new Empresa();
                if ($empresa->buscarEmpresa($IDempresa)) {
                    echo "\n Empresa encontrada: " . $empresa . "\n";
                } else {
                    echo "\n Empresa no encontrada.\n";
                }
                break;
                case 3:
                    echo "\n Modificar Empresa\n";
                    echo "\n Ingrese ID de la empresa a modificar: ";
                    $IDempresa = trim(fgets(STDIN));
                    $empresa = new Empresa();
                    if ($empresa->buscarEmpresa($IDempresa)) {
                        echo "\n Empresa encontrada: " . $empresa . "\n";
                        echo "\n Ingrese nuevo nombre de la empresa: ";
                        $nombreEmpresa = trim(fgets(STDIN));
                        echo "\n Ingrese nueva dirección de la empresa: ";
                        $direccionEmpresa = trim(fgets(STDIN));
                        $empresa->cargarEmpresa($IDempresa, $nombreEmpresa, $direccionEmpresa);
                        if ($empresa->modificarEmpresa()) {
                            echo "\n Empresa modificada.\n";
                        } else {
                            echo "\n Error al modificar: " . $empresa->getMensaje() . "\n";
                        }
                    } else {
                        echo "\n Empresa no encontrada.\n";
                    }
                    break;
                case 4:
                    echo "\n Eliminar Empresa\n";
                    echo "\n Ingrese ID de la empresa a eliminar: ";
                    $IDempresa = trim(fgets(STDIN));
                    $empresa = new Empresa();
                    if ($empresa->buscarEmpresa($IDempresa)) {
                        if ($empresa->eliminarEmpresa()) {
                            echo "\n Empresa eliminada.\n";
                        } else {
                            echo "\n Error al eliminar: " . $empresa->getMensaje() . "\n";
                        }
                    } else {
                        echo "\n Empresa no encontrada.\n";
                    }
                    break;
                case 5:
                    echo "\n Listar Empresas\n";
                    $empresa = new Empresa();
                    $empresas = $empresa->listarEmpresa();
                    if ($empresas && count($empresas) > 0) {
                        foreach ($empresas as $e) {
                            echo $e . "\n";
                        }
                    } else {
                        echo "No hay empresas registradas.\n";
                    }
                    break;
                case 0:
                    echo "Volviendo al menú principal...\n";
                    break;
                default:
                    echo "\n Opción no válida. \n";
                    break;
            }
        } while ($opcion != 0);
    }

public function menuPasajero() {
    do {
        echo "\n Menú Pasajero\n";
        echo "\n 1. Insertar Pasajero \n";
        echo "\n 2. Buscar Pasajero \n";
        echo "\n 3. Modificar Pasajero \n";
        echo "\n 4. Eliminar Pasajero\n";
        echo "\n 5. Listar Pasajeros\n";
        echo "\n 0. Volver\n";
        $opcion = trim(fgets(STDIN));
    
    switch ($opcion) {
        case 1:
            echo "\n Insertar Pasajero\n";
            $pasajero = new Pasajero();
            echo "\n Ingrese nombre del pasajero: ";
            $nombrePersona = trim(fgets(STDIN));
            echo "\n Ingrese apellido del pasajero: ";
            $apellidoPersona = trim(fgets(STDIN));
            echo "\n Ingrese documento del pasajero: ";
            $docPasajero = trim(fgets(STDIN));
            echo "\n Ingrese teléfono del pasajero: ";
            $telefonoPasajero = trim(fgets(STDIN));
            $pasajero->cargarPasajero($nombrePersona, $apellidoPersona, $docPasajero, $telefonoPasajero);
            if ($pasajero->insertarPasajero()) {
                echo "\n Pasajero insertado correctamente.\n";
            } else {
                echo "\n Error al insertar el pasajero: " . $pasajero->getMensaje() . "\n";
            }
            break;
        case 2:
            echo "\n Buscar Pasajero \n";
            echo "\n Ingrese documento del pasajero: \n";
            $docPasajero = trim(fgets(STDIN));
            $pasajero = new Pasajero();
            if ($pasajero->buscarPasajero($docPasajero)) {
                echo "\n Pasajero encontrado: " . $pasajero->getNombrePersona() . " " . $pasajero->getApellidoPersona() . "\n";
            } else {
                echo "\n Pasajero no encontrado.\n";
            }
            break;
        case 3:
    echo "\n Modificar Pasajero\n";
    echo "\n Ingrese documento del pasajero a modificar: \n";
    $docPasajero = trim(fgets(STDIN));
    $pasajero = new Pasajero();
    if ($pasajero->buscarPasajero($docPasajero)) {
        echo "\n Pasajero encontrado: " . $pasajero->getNombrePersona() . " " . $pasajero->getApellidoPersona() . "\n";
        echo "\n Ingrese nuevo nombre del pasajero: \n";
        $nombrePersona = trim(fgets(STDIN));
        echo "\nIngrese nuevo apellido del pasajero: \n";
        $apellidoPersona = trim(fgets(STDIN));
        echo "\n Ingrese nuevo teléfono del pasajero: \n";
        $telefonoPasajero = trim(fgets(STDIN));
        $pasajero->cargarPasajero($nombrePersona, $apellidoPersona, $docPasajero, $telefonoPasajero, $pasajero->getIDpersona());
        
        if ($pasajero->modificarPasajero()) {
            echo "\n Pasajero modificado.\n";
        } else {
            echo "\n Error al modificar: " . $pasajero->getMensaje() . "\n";
        }
    } else {
        echo "\n Pasajero no encontrado.\n";
    }
    break;
        case 4:
            echo "\n Eliminar Pasajero\n";
            echo "\n Ingrese documento del pasajero a eliminar: \n";
            $docPasajero = trim(fgets(STDIN));
            $pasajero = new Pasajero();
            if ($pasajero->buscarPasajero($docPasajero)) {
                if ($pasajero->eliminarPasajero()) {
                    echo "\n Pasajero eliminado.\n";
                } else {
                    echo "\n Error al eliminar: " . $pasajero->getMensaje() . "\n";
                }
            } else {
                echo "\n Pasajero no encontrado.\n";
            }
            break;
        case 5:
            echo "\n Listar Pasajeros\n";
            $pasajero = new Pasajero();
            $pasajeros = $pasajero->listarPasajero();
            if (count($pasajeros) > 0) {
                foreach ($pasajeros as $p) {
                    echo "Documento: " . $p->getdocPasajero() . ", Nombre: " . $p->getNombrePersona() . " " . $p->getApellidoPersona() . "\n";
                }
            } else {
                echo "\n No hay pasajeros registrados.\n";
            }
            break;
        case 0:
            echo "Volviendo al menú principal...\n";
            break;
        default:
            echo "\n Opción no válida. \n";
            break;
        }
            
    





    } while ($opcion != 0);
}





public function menuResponsable() {
    do {
        echo "Menú Responsable\n";
        echo "\n 1. Insertar Responsable \n";
        echo "\n 2. Buscar Responsable \n";
        echo "\n 3. Modificar Responsable \n";
        echo "\n 4. Eliminar Responsable\n";
        echo "\n 5. Listar Responsables\n";
        echo "\n 0. Volver\n";
        $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            echo "\n Insertar Responsable\n";
            $responsable = new ResponsableV();
            echo "\n Ingrese nombre del responsable: ";
            $nombrePersona = trim(fgets(STDIN));
            echo "\n Ingrese apellido del responsable: ";
            $apellidoPersona = trim(fgets(STDIN));
            echo "\n Ingrese número de licencia: ";
            $numLicencia = trim(fgets(STDIN));
            $responsable->cargarResponsableV($nombrePersona, $apellidoPersona, $responsable->getIDpersona(), $numLicencia);
            if ($responsable->insertarResponsableV()) {
                echo "\n Responsable insertado correctamente.\n";
            } else {
                echo "Error al insertar el responsable: " . $responsable->getMensaje() . "\n";
            }
            break;
        case 2:
            echo "\n Buscar Responsable\n";
            echo "\n Ingrese ID del responsable: ";
            $numLicencia = trim(fgets(STDIN));
            $responsable = new ResponsableV();
            if ($responsable->buscarResponsableV($numLicencia)) {
                echo "\n Responsable encontrado: " . $responsable->getNombrePersona() . " " . $responsable->getApellidoPersona() . "\n";
            } else {
                echo "\n Responsable no encontrado.\n";
            }
            break;
        case 3:
            echo "\n Modificar Responsable\n";
            echo "\n Ingrese ID del responsable a modificar: ";
            $numLicencia = trim(fgets(STDIN));
            $responsable = new ResponsableV();
            if ($responsable->buscarResponsableV($numLicencia)) {
                echo "\n Responsable encontrado: " . $responsable->getNombrePersona() . " " . $responsable->getApellidoPersona() . "\n";
                echo "\n Ingrese nuevo nombre del responsable: ";
                $nombrePersona = trim(fgets(STDIN));
                echo "\n Ingrese nuevo apellido del responsable: ";
                $apellidoPersona = trim(fgets(STDIN));
                $responsable->cargarResponsableV($nombrePersona, $apellidoPersona, $responsable->getIDpersona(), $numLicencia);
                if ($responsable->modificarResponsableV()) {
                    echo "\n Responsable modificado.\n";
                } else {
                    echo "\n Error al modificar: " . $responsable->getMensaje() . "\n";
                }
            } else {
                echo "\n Responsable no encontrado.\n";
            }
            break;
        case 4:
            echo "\n Eliminar Responsable\n";
            echo "Ingrese ID del responsable a eliminar: ";
            $numLicencia = trim(fgets(STDIN));
            $responsable = new ResponsableV();
            if ($responsable->buscarResponsableV($numLicencia)) {
                if ($responsable->eliminarResponsableV()) {
                    echo "\n Responsable eliminado.\n";
                } else {
                    echo "\n Error al eliminar: " . $responsable->getMensaje() . "\n";
                }
            } else {
                echo "\n Responsable no encontrado.\n";
            }
            break;
        case 5:
            echo "\n Listar Responsables\n";
            $responsable = new ResponsableV();
            $responsables = $responsable->listarResponsableV();
            if (count($responsables) > 0) {
                foreach ($responsables as $resp) {
                    echo "ID: " . $resp->getnumEmpleado() . ", Nombre: " . $resp->getNombrePersona() . " " . $resp->getApellidoPersona() . "\n";
                }
            } else {
                echo "No hay responsables registrados.\n";
            }
            break;
        case 0:
            echo "Volviendo al menú principal...\n";
            break;
        default:
            echo "\n Opción no válida. \n";
            break;
}
    } while ($opcion != 0);
}


public function menuViaje() {
    do {
        echo "Menú Viaje\n";
        echo "\n 1. Insertar Viaje \n";
        echo " 2. Buscar Viaje \n";
        echo " 3. Modificar Viaje \n";
        echo " 4. Eliminar Viaje\n";
        echo " 5. Listar Viajes\n";
        echo " 0. Volver. \n";
        echo "Ingrese su opción: ";
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case 1:
    echo "Insertar Viaje\n";
    $viaje = new Viaje();
    echo "Ingrese destino del viaje: ";
    $destinoViaje = trim(fgets(STDIN));
    echo "Ingrese cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));
    echo "Ingrese ID de la empresa: ";
    $IDempresa = trim(fgets(STDIN));
    echo "Ingrese ID del responsable: ";
    $numEmpleado = trim(fgets(STDIN));
    echo "Ingrese importe del viaje: ";
    $importeViaje = trim(fgets(STDIN));
    
    $empresa = new Empresa();
    $responsable = new ResponsableV();

    if ($empresa->buscarEmpresa($IDempresa) && $responsable->buscarResponsableV($numEmpleado)) {
        $viaje->cargarViaje(0, $destinoViaje, $cantMaxPasajeros, $empresa, $responsable, $importeViaje);
        if ($viaje->insertarViaje()) {
            echo "Viaje insertado correctamente.\n";
        } else {
            echo "Error al insertar el viaje: " . $viaje->getMensaje() . "\n";
        }
    } else {
        echo "Empresa o responsable no encontrados.\n";
    }
    break;
            case 2:
                echo "Buscar Viaje\n";
                echo "Ingrese ID del viaje: ";
                $IDviaje = trim(fgets(STDIN));
                $viaje = new Viaje();
                if ($viaje->buscarViaje($IDviaje)) {
                    echo "Viaje encontrado: " . $viaje->getDestinoViaje() . "\n";
                } else {
                    echo "Viaje no encontrado.\n";
                }
                break;
case 3:
    echo "\n Modificar Viaje\n";
    echo "\n Ingrese ID del viaje a modificar: \n";
    $IDviaje = trim(fgets(STDIN));
    $viaje = new Viaje();
    
    if ($viaje->buscarViaje($IDviaje)) {
        echo "\n Viaje encontrado: " . $viaje->getDestinoViaje() . "\n";
        
        echo "\n Ingrese nuevo destino del viaje: \n";
        $destinoViaje = trim(fgets(STDIN));
        
        echo "\n Ingrese nueva cantidad máxima de pasajeros: \n";
        $cantMaxPasajeros = trim(fgets(STDIN));
        
        echo "\n Ingrese nuevo importe del viaje: \n";
        $importeViaje = trim(fgets(STDIN));
        
        $viaje->setDestinoViaje($destinoViaje);
        $viaje->setCantMaxPasajeros($cantMaxPasajeros);
        $viaje->setImporteViaje($importeViaje);
        
        if ($viaje->modificarViaje()) {
            echo "\n Viaje modificado exitosamente.\n";
        } else {
            echo "\n Error al modificar viaje: " . $viaje->getMensaje() . "\n";
        }
    } else {
        echo "\n Viaje no encontrado: " . $viaje->getMensaje() . "\n";
    }
    break;
            case 4:
                echo "\n Eliminar Viaje\n";
                echo "Ingrese ID del viaje a eliminar: ";
                $IDviaje = trim(fgets(STDIN));
                $viaje = new Viaje();
                if ($viaje->buscarViaje($IDviaje)) {
                    if ($viaje->eliminarViaje()) {
                        echo "\n Viaje eliminado.\n";
                    } else {
                        echo "\n Error al eliminar: " . $viaje->getMensaje() . "\n";
                    }
                } else {
                    echo "\n Viaje no encontrado.\n";
                }
                break;
            case 5:
                echo "\n Listar Viajes\n";
                $viaje = new Viaje();
                $viajes = $viaje->listarViaje();
                if (count($viajes) > 0) {
                    foreach ($viajes as $v) {
                        echo "ID: " . $v->getIDviaje() . ", Destino: " . $v->getDestinoViaje() . ", Importe: " . $v->getImporteViaje() . "\n";
                    }
                } else {
                    echo "No hay viajes registrados.\n";
                }
                break;
            default:
                echo "\n Opción no válida. \n";
                break;
        }

    } while ($opcion != 0);
}

public function menuViajePasajeros() {
    do {
        echo "Menú Viaje Pasajeros\n";
        echo "\n 1. Asignar pasajero a un viaje\n";
        echo "\n 2. Eliminar pasajero de un viaje\n";
        echo "\n 3. Mostrar pasajeros de un viaje\n";
        echo "\n 4. Mostrar viajes de un pasajero\n";
        echo "\n 0. Volver \n";
        $opcion = trim(fgets(STDIN));

            switch ($opcion) {
            case 1: 
        echo "\n Agregar Pasajero a Viaje\n";
        echo "Ingrese ID del viaje: ";
        $IDviaje = trim(fgets(STDIN));
        echo "Ingrese documento del pasajero: ";
        $docPasajero = trim(fgets(STDIN));
        
        
        $viaje = new Viaje();
        if ($viaje->buscarViaje($IDviaje)) {
            
            $pasajero = new Pasajero();
            if ($pasajero->buscarPasajero($docPasajero)) {
                
                $viajePasajero = new ViajePasajeros();
                $viajePasajero->cargarViajePasajero($pasajero, $viaje);
                
                if ($viajePasajero->insertar()) {
                    echo "\n Pasajero agregado al viaje.\n";
                } else {
                    echo "\n Error al agregar pasajero al viaje: " . $viajePasajero->getMensaje() . "\n";
                }
            } else {
                echo "\n Pasajero no encontrado.\n";
            }
        } else {
            echo "\n Viaje no encontrado.\n";
        }
        break;
            case 2:
                echo "\n Eliminar pasajero\n";
                echo "Ingrese ID del viaje: ";
                $IDviaje = trim(fgets(STDIN));
                echo "Ingrese documento del pasajero: ";
                $docPasajero = trim(fgets(STDIN));
                
                $viajePasajero = new ViajePasajeros();
                $viajePasajero->cargarViajePasajero($IDviaje, $docPasajero);
                
                if ($viajePasajero->eliminar()) {
                    echo "Pasajero eliminado.\n";
                } else {
                    echo "Error al eliminar pasajero: " . $viajePasajero->getMensaje() . "\n";
                }
                break;
case 3:
    echo "\n Mostrar pasajeros de un viaje\n";
    echo "Ingrese ID del viaje: ";
    $IDviaje = trim(fgets(STDIN));
    $viajePasajeros = new ViajePasajeros();
    $relaciones = $viajePasajeros->listar("IDviaje = " . intval($IDviaje));
    
    if ($relaciones && count($relaciones) > 0) {
        echo "Pasajeros en el viaje ID $IDviaje:\n";
        foreach ($relaciones as $relacion) {
            $pasajero = $relacion->getObjPasajero();
            echo "Documento: " . $pasajero->getdocPasajero() . ", Nombre: " . 
                $pasajero->getNombrePersona() . " " . $pasajero->getApellidoPersona() . 
                ", Teléfono: " . $pasajero->getTelefonoPasajero() . "\n";
        }
    } else {
        echo "No hay pasajeros en este viaje.\n";
    }
    break;
           case 4:
    echo "\n Mostrar viajes de un pasajero\n";
    echo "Ingrese documento del pasajero: ";
    $docPasajero = trim(fgets(STDIN));
    $pasajero = new Pasajero();
    if ($pasajero->buscarPasajero($docPasajero)) {
        echo "Pasajero: " . $pasajero->getNombrePersona() . " " . $pasajero->getApellidoPersona() . "\n";
        $viajePasajeros = new ViajePasajeros();
        $relaciones = $viajePasajeros->listar("docPasajero = " . intval($docPasajero));
        
        if ($relaciones && count($relaciones) > 0) {
            echo "Viajes del pasajero:\n";
            foreach ($relaciones as $relacion) {
                $viaje = $relacion->getObjViaje();
                echo "ID: " . $viaje->getIDviaje() . ", Destino: " . $viaje->getDestinoViaje() . 
                    ", Importe: " . $viaje->getImporteViaje() . "\n";
            }
        } else {
            echo "No hay viajes asignados a este pasajero.\n";
        }
    } else {
        echo "Pasajero no encontrado.\n";
    }
    break;

            case 0:
                echo "Volviendo al menú principal...\n";
                break;
            default:
                echo "Opción no válida. Intente nuevamente.\n";
                break;
        }
    } while ($opcion != 0);

}
}

$test = new TestViaje();
$test->Menu();

