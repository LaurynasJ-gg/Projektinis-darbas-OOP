CREATE DATABASE IF NOT EXISTS php_projektas
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE php_projektas;

CREATE TABLE IF NOT EXISTS vartotojai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vardas VARCHAR(100) NOT NULL UNIQUE,
    slap_hash VARCHAR(255) NOT NULL,
    koduotas_raktas TEXT NOT NULL,
    sukurta TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS slaptazodziai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vartotojo_id INT NOT NULL,
    pavadinimas VARCHAR(150) NOT NULL,
    koduotas_slaptazodis TEXT NOT NULL,
    sukurta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vartotojo_id) REFERENCES vartotojai(id)
);