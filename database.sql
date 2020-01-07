DROP DATABASE if exists Carrental;
CREATE DATABASE Carrental;
USE Carrental;

CREATE TABLE Customers (
	customerNumber CHAR(10) NOT NULL,
	customerName VARCHAR(100) NOT NULL,
	customerAddress VARCHAR(256) NOT NULL,
	postalAddress VARCHAR(100) NOT NULL,
	phoneNumber VARCHAR(13) NOT NULL,
	PRIMARY KEY (customerNumber)
);

INSERT INTO `Customers` (`customerNumber`, `customerName`, `customerAddress`, `postalAddress`, `phoneNumber`) VALUES
(8308184160,	'Jack Sparrow',	'Skeppargatan 54 A',	'11458 Stockholm',	'0733310104'),
(1507303731,	'Mr Darcy',	'Ordenstrappan 1',	'11430 Stockholm',	'0707778800'),
(4604279796,	'Hannibal Lecter',	'Grindsgatan 35',	'11857 Stockholm',	'0733464649'),
(8807280030,	'Tyler Durdan',	'Hornsgatan 4',	'11820 Stockholm',	'0707888470');



CREATE TABLE Brands (
    brand VARCHAR(10),
    PRIMARY KEY (brand)
);

INSERT INTO Brands(brand) VALUES
    ('Peugeot'),
    ('Suzuki'),
    ('Fiat'),
    ('Honda'),
    ('Ford'),
    ('Hyundai'),
    ('Renault'),
    ('Toyota'),
    ('Volkswagen'),
    ('Chrystler')
;

CREATE TABLE Colours (
    colour VARCHAR(10),
    PRIMARY KEY (colour)
);

INSERT INTO Colours(colour) VALUES
	('Blue'),
	('Red'),
	('Green'),
	('Yellow'),
	('Black'),
	('White'),
	('Magenta'),
	('Orange'),
	('Grey'),
	('Brown');



CREATE TABLE Cars (
	licensePlate VARCHAR(6) NOT NULL,
	brand VARCHAR(10) NOT NULL,
	colour VARCHAR(10) NOT NULL,
	year VARCHAR(4) NOT NULL,
	price FLOAT NOT NULL,
    customerNumber CHAR(10) NOT NULL,
    PRIMARY KEY (licensePlate),
    start DATETIME,
    FOREIGN KEY (colour) REFERENCES Colours(colour),
    FOREIGN KEY (brand) REFERENCES Brands(brand),
    FOREIGN KEY (customerNumber) REFERENCES Customers(customerNumber)
);

INSERT INTO Cars(licensePlate, brand) VALUES
    ('ABC123', 'Fiat'),
    ('BCD234', 'Suzuki'),
    ('CDE345', 'Peugeot'),
    ('EFG456', 'Honda'),
    ('FGH567', 'Ford'),
    ('GHI678', 'Hyundai'),
    ('HIJ789', 'Volkswagen'),
    ('IJK890', 'Toyota'),
    ('JKL901', 'Renault'),
    ('KLM012', 'Chrystler');


CREATE TABLE History (
    customerNumber CHAR(10) NOT NULL,
    licensePlate CHAR(6),
    start DATETIME NOT NULL,
    end TIMESTAMP NULL,
    FOREIGN KEY (customerNumber) REFERENCES Customers(customerNumber),
    FOREIGN KEY (licensePlate) REFERENCES Cars (licensePlate)

);


