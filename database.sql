DROP DATABASE if exists car_rental;
CREATE DATABASE car_rental;
USE car_rental;

CREATE TABLE customers (
	social_security_number CHAR(10) NOT NULL PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	address VARCHAR(256) NOT NULL,
	postal_address VARCHAR(100) NOT NULL,
	phone_number VARCHAR(13) NOT NULL,
	PRIMARY KEY (social_security_number)
);

CREATE TABLE cars (
	registration_plate VARCHAR(6) NOT NULL PRIMARY KEY,
	brand VARCHAR(10) NOT NULL,
	colour VARCHAR(7) NOT NULL,
	year VARCHAR(4) NOT NULL,
	price FLOAT NOT NULL,
	PRIMARY KEY (registration_plate),
    FOREIGN KEY colour REFERENCES colours(colour),
    FOREIGN KEY brand REFERENCES brands(brand)
);

CREATE TABLE brands (
    brand VARCHAR(10)
);

INSERT INTO brands(brand) VALUES
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

CREATE TABLE colours (
    colour VARCHAR(10)
);

INSERT INTO colours(colour) VALUES
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



INSERT INTO cars(registration_plate) VALUES
    ('ABC123'),
    ('BCD234'),
    ('CDE345'),
    ('EFG456'),
    ('FGH567'),
    ('GHI678'),
    ('HIJ789'),
    ('IJK890'),
    ('JKL901'),
    ('KLM012');


CREATE TABLE booking (
    social_security_number CHAR(10) NOT NULL,
    registration_plate CHAR(6),
    checked_out_by CHAR(10) NOT NULL,
    checked_in_time DATETIME NOT NULL,
    checked_out_time DATETIME DEFAULT NOT NULL,
    FOREIGN KEY social_security_number REFERENCES customers(social_security_number),
    FOREIGN KEY registration_plate REFERENCES cars(registration_plate)

);
/* then column days = echo(checked_out_time - checked_in_time)
if (!isset(days < 1)) {
    disable delete & edit button 
} else {
    enable delete  edit buutton
}
This should be created with JS*/

SELECT * FROM colours;


//datum när boken lånades ut (start) - start DATETIME NOT NOLL
//datum när boken lämnades tillbaka (end) - end DATETIME DEFAULT NULL
