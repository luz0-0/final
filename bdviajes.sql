CREATE DATABASE IF NOT EXISTS bdviajes;

USE bdviajes;

CREATE TABLE IF NOT EXISTS Persona (
    IDpersona BIGINT AUTO_INCREMENT,
    nombrePersona VARCHAR(150), 
    apellidoPersona VARCHAR(150),
    PRIMARY KEY (IDpersona)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS Empresa (
    IDempresa BIGINT AUTO_INCREMENT,
    nombreEmpresa VARCHAR(150),
    direccionEmpresa VARCHAR(150),
    PRIMARY KEY (IDempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS ResponsableV (
    numEmpleado BIGINT AUTO_INCREMENT,
    IDpersona BIGINT,
    numLicencia BIGINT,
    PRIMARY KEY (numEmpleado),
    FOREIGN KEY (IDpersona) REFERENCES Persona(IDpersona)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS Pasajero (
    docPasajero BIGINT,
    IDpersona BIGINT,
    telefonoPasajero VARCHAR(15),
    PRIMARY KEY (docPasajero),
    FOREIGN KEY (IDpersona) REFERENCES Persona(IDpersona)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Viaje (
    IDviaje BIGINT AUTO_INCREMENT,
    destinoViaje VARCHAR(150),
    cantMaxPasajeros INT,
    IDempresa BIGINT,
    numEmpleado BIGINT,
    importeViaje FLOAT,
    PRIMARY KEY (IDviaje),
    FOREIGN KEY (IDempresa) REFERENCES Empresa (IDempresa)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (numEmpleado) REFERENCES ResponsableV (numEmpleado)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS ViajePasajeros (
    IDviaje BIGINT,
    docPasajero BIGINT,
    PRIMARY KEY (IDviaje, docPasajero),
    FOREIGN KEY (IDviaje) REFERENCES Viaje(IDviaje)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (docPasajero) REFERENCES Pasajero(docPasajero)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
