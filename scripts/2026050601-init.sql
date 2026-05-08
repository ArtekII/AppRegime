CREATE DATABASE app_regime_db;
USE app_regime_db;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    genre ENUM('Homme', 'Femme', 'Autre') NOT NULL,
    taille FLOAT NOT NULL,
    poids FLOAT NOT NULL,
    role ENUM('admin', 'utilisateur') NOT NULL DEFAULT 'utilisateur',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde DECIMAL(10,2) NOT NULL DEFAULT 0.00
);

CREATE TABLE statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('Augmenter son poids', 'Réduire son poids', 'Atteindre son IMC idéal') NOT NULL,
    calories_journalieres INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP   
);

CREATE TABLE objectifs_statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objectif_id INT NOT NULL,
    statut_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE CASCADE,
    FOREIGN KEY (statut_id) REFERENCES statut(id) ON DELETE CASCADE
);

CREATE TABLE utilisateurs_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    objectif_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE CASCADE
);

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    variation_poids FLOAT NOT NULL,
    duree INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    pourcentage_viandes FLOAT NOT NULL,
    pourcentage_poissons FLOAT NOT NULL,
    pourcentage_vollailes FLOAT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activite_sportif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    calories_brulees_par_heure FLOAT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE objectifs_regimes_activite(
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    objectif_id INT NOT NULL,
    activite_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE CASCADE,
    FOREIGN KEY (activite_id) REFERENCES activite_sportif(id) ON DELETE CASCADE
);

CREATE TABLE code (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL UNIQUE,
    utilisateur_id INT NOT NULL,
    montant FLOAT NOT NULL,
    utilise BOOLEAN NOT NULL DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE abonnements_gold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    date_activation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);