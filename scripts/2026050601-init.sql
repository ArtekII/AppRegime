CREATE DATABASE IF NOT EXISTS app_regime_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE app_regime_db;

CREATE TABLE IF NOT EXISTS utilisateur (
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

CREATE TABLE IF NOT EXISTS statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

INSERT INTO statut (nom)
SELECT 'En cours'
WHERE NOT EXISTS (SELECT 1 FROM statut WHERE nom = 'En cours');

INSERT INTO statut (nom)
SELECT 'Terminé'
WHERE NOT EXISTS (SELECT 1 FROM statut WHERE nom = 'Terminé');

INSERT INTO statut (nom)
SELECT 'Annulé'
WHERE NOT EXISTS (SELECT 1 FROM statut WHERE nom = 'Annulé');

CREATE TABLE IF NOT EXISTS objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('Augmenter son poids', 'Réduire son poids', 'Atteindre son IMC idéal') NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO objectif (type)
SELECT 'Augmenter son poids'
WHERE NOT EXISTS (SELECT 1 FROM objectif WHERE type = 'Augmenter son poids');

INSERT INTO objectif (type)
SELECT 'Réduire son poids'
WHERE NOT EXISTS (SELECT 1 FROM objectif WHERE type = 'Réduire son poids');

INSERT INTO objectif (type)
SELECT 'Atteindre son IMC idéal'
WHERE NOT EXISTS (SELECT 1 FROM objectif WHERE type = 'Atteindre son IMC idéal');

CREATE TABLE IF NOT EXISTS utilisateur_objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    objectif_id INT NOT NULL,
    statut_id INT NOT NULL,
    imc_cible DECIMAL(4,1) NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (objectif_id) REFERENCES objectif(id) ON DELETE CASCADE,
    FOREIGN KEY (statut_id) REFERENCES statut(id)
);

CREATE TABLE IF NOT EXISTS regime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    pourcentage_viandes FLOAT NOT NULL,
    pourcentage_poissons FLOAT NOT NULL,
    pourcentage_volailles FLOAT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS prix_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    duree_jours INT NOT NULL,
    regime_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (regime_id) REFERENCES regime(id)
);

CREATE TABLE IF NOT EXISTS activite_sportive (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    calories_brulees_par_heure FLOAT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS regime_objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    objectif_id INT NOT NULL,
    poids_min FLOAT NOT NULL,
    poids_max FLOAT NOT NULL,
    duree_jours INT NOT NULL,
    FOREIGN KEY (regime_id) REFERENCES regime(id),
    FOREIGN KEY (objectif_id) REFERENCES objectif(id)
);

CREATE TABLE IF NOT EXISTS activite_objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activite_id INT NOT NULL,
    objectif_id INT NOT NULL,
    duree_jours INT NOT NULL,
    frequence_par_semaine INT NOT NULL,
    duree_minutes_par_seance INT NOT NULL,
    FOREIGN KEY (activite_id) REFERENCES activite_sportive(id),
    FOREIGN KEY (objectif_id) REFERENCES objectif(id)
);

CREATE TABLE IF NOT EXISTS code_montant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    montant FLOAT NOT NULL,
    utilise BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS code_historique (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    utilise BOOLEAN NOT NULL DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_code_per_user (code_id, utilisateur_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (code_id) REFERENCES code_montant(id)
);

CREATE TABLE IF NOT EXISTS abonnements_gold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    date_activation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
);
