
---------- Base de données Foodly ----------

CREATE DATABASE IF NOT EXISTS foodly;
USE foodly;

---------- Table : recettes ----------

CREATE TABLE recettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    ingredients TEXT NOT NULL,
    temps_preparation INT NOT NULL,
    categorie VARCHAR(50) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---------- Table : planning ----------

CREATE TABLE planning (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jour VARCHAR(20) NOT NULL,
    type_repas VARCHAR(20) NOT NULL,
    id_recette INT NOT NULL,
    FOREIGN KEY (id_recette) REFERENCES recettes(id) ON DELETE CASCADE
);