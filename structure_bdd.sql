CREATE DATABASE IF NOT EXISTS structure_bdd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE structure_bdd;

CREATE TABLE client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE hotel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL
);

CREATE TABLE chambre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    hotel_id INT NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id)
);

CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    chambre_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    date_creation DATE NOT NULL,
    FOREIGN KEY (client_id) REFERENCES client(id),
    FOREIGN KEY (chambre_id) REFERENCES chambre(id)
);
-- Insertion de 3 hôtels (exemples)
INSERT INTO hotel (nom, adresse) VALUES
('Hôtel du Centre', '10 rue Principale, Paris'),
('Hôtel des Plages', '5 avenue du Soleil, Nice'),
('Hôtel Montagne', '2 chemin des Cimes, Grenoble');

-- Insertion de 5 chambres par hôtel (exemples)
INSERT INTO chambre (numero, hotel_id) VALUES
(101, 1), (102, 1), (103, 1), (104, 1), (105, 1),
(201, 2), (202, 2), (203, 2), (204, 2), (205, 2),
(301, 3), (302, 3), (303, 3), (304, 3), (305, 3);
