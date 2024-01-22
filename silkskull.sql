CREATE DATABASE IF NOT EXISTS silkskull;
use silkskull;

CREATE TABLE IF NOT EXISTS kunde(
    kunde_id INT PRIMARY KEY AUTO_INCREMENT,
    vorname VARCHAR(50),
    nachname VARCHAR(50),
    straße VARCHAR(50),
    ort VARCHAR(50),
    plz VARCHAR(50),
    email VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS bestellung(
    bestellung_id INT PRIMARY KEY AUTO_INCREMENT,
    kunde_id INT,
    bestelldatum DATETIME NOT NULL,
    FOREIGN KEY (kunde_id) REFERENCES kunde(kunde_id)
);

CREATE TABLE IF NOT EXISTS artikel(
    artikel_id INT PRIMARY KEY AUTO_INCREMENT,
    name     VARCHAR(50),
    groesse  VARCHAR(50),
    farbe    VARCHAR(50),
    preis    DECIMAL(10, 2),
    bestand  int
);

CREATE TABLE IF NOT EXISTS bestellunglieferadresse(
    lieferadresse_id INT PRIMARY KEY AUTO_INCREMENT,
    bestellung_id INT,
    strasse VARCHAR(50),
    ort VARCHAR(50),
    plz VARCHAR(50),
    FOREIGN KEY (bestellung_id) REFERENCES bestellung(bestellung_id)
);

CREATE TABLE IF NOT EXISTS bestellungrechnungsadresse(
    lieferadresse_id INT PRIMARY KEY AUTO_INCREMENT,
    bestellung_id INT,
    strasse VARCHAR(50),
    ort VARCHAR(50),
    plz VARCHAR(50),
    FOREIGN KEY (bestellung_id) REFERENCES bestellung(bestellung_id)
);

CREATE TABLE IF NOT EXISTS bestellungpositionen(
    position_id INT PRIMARY KEY AUTO_INCREMENT,
    bestellung_id INT,
    tshirt_id INT,
    menge INT NOT NULL,
    gesamtpreis DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (bestellung_id) REFERENCES bestellung(bestellung_id),
    FOREIGN KEY (tshirt_id) REFERENCES tshirt(tshirt_id)
);