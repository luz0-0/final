CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    nombreEmpresa varchar(150),
    direccionEmpresa varchar(150),
    PRIMARY KEY (IDempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsableV (
    rnumeroempleado bigint AUTO_INCREMENT,
    IDempleado bigint,
	nombrePersonna varchar(150), 
    apellidoPersona  varchar(150), 
    PRIMARY KEY (IDempleado)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;;
	
CREATE TABLE viaje (
    IDviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	destinoViaje varchar(150),
    cantMaxPasajeros int,
	IDempresa bigint,
    IDempleado bigint,
    importeViaje float,
    PRIMARY KEY (IDviaje),
    FOREIGN KEY (IDempresa) REFERENCES empresa (IDempresa),
	FOREIGN KEY (IDempleado) REFERENCES responsable (numEmpleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    IDpasajero varchar(15),
    nombrePersona varchar(150), 
    apellidoPersona varchar(150), 
	telefonoPasajero int, 
	IDviaje bigint,
    PRIMARY KEY (pasajero),
	FOREIGN KEY (IDviaje) REFERENCES viaje (IDviaje)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
