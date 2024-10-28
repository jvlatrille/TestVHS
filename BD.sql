CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    photoProfil VARCHAR(255),
    banniereProfil VARCHAR(255),
    adresseMail VARCHAR(100) NOT NULL UNIQUE,
    motDePasse VARCHAR(255) NOT NULL,
    role ENUM('utilisateur', 'admin') DEFAULT 'utilisateur'
);

CREATE TABLE Watchlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    description TEXT,
    visible BOOLEAN DEFAULT 1,
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);


CREATE TABLE Film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    genre VARCHAR(50),
    dateSortie DATE,
    duree INT, -- Durée en minutes
    note FLOAT DEFAULT 0 -- Note moyenne
);


CREATE TABLE OA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    note FLOAT DEFAULT 0,
    description TEXT,
    dateSortie DATE,
    limiteAge INT,
    duree INT,
    genre VARCHAR(50)
);


CREATE TABLE Saison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nbSaison INT NOT NULL
);

CREATE TABLE Episode (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    duree INT,
    saison_id INT,
    FOREIGN KEY (saison_id) REFERENCES Saison(id) ON DELETE CASCADE
);


CREATE TABLE Personne (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    dateNaiss DATE,
    genre ENUM('homme', 'femme', 'autre')
);

CREATE TABLE Collaborer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50),
    rang INT,
    personne_id INT,
    oa_id INT,
    FOREIGN KEY (personne_id) REFERENCES Personne(id) ON DELETE CASCADE,
    FOREIGN KEY (oa_id) REFERENCES OA(id) ON DELETE CASCADE
);


CREATE TABLE Quizz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    theme VARCHAR(50),
    nbQuestion INT DEFAULT 0,
    difficulte ENUM('facile', 'moyen', 'difficile'),
    meilleurJ INT
);

CREATE TABLE Question (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT,
    numero INT,
    nvDifficulte ENUM('facile', 'moyen', 'difficile'),
    quizz_id INT,
    FOREIGN KEY (quizz_id) REFERENCES Quizz(id) ON DELETE CASCADE
);

CREATE TABLE Repondre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    score INT DEFAULT 0,
    bonneReponse TINYINT(1),
    question_id INT,
    utilisateur_id INT,
    FOREIGN KEY (question_id) REFERENCES Question(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);


