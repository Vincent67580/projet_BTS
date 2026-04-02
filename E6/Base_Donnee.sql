-- CREATION BASE DONNEE DU PROJET BTS 
DROP DATABASE IF EXISTS ProjetBTS;
CREATE DATABASE ProjetBTS;

USE ProjetBTS;

CREATE TABLE TypeSignalement(
   idTypeSignalement INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(idTypeSignalement)
);

CREATE TABLE Roles(
   idRoles INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(idRoles)
);

CREATE TABLE PieceJointe(
   idPJ INT AUTO_INCREMENT,
   nomFichier VARCHAR(50),
   contenuChiffre VARCHAR(50),
   cheminFichier VARCHAR(255),
   tailleOctet VARCHAR(50),
   dateDepot DATETIME,
   PRIMARY KEY(idPJ)
);

CREATE TABLE Status(
   idStatus INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(idStatus)
);

CREATE TABLE Signalements(
   idSignalement INT AUTO_INCREMENT,
   contenu TEXT,
   estAnonyme BOOLEAN NOT NULL,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   numeroDossier VARCHAR(16) NOT NULL,
   dateDepot DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateCloture DATETIME,
   motDePasse VARCHAR(255) NOT NULL,
   idStatus INT NOT NULL,
   idTypeSignalement INT NOT NULL,
   PRIMARY KEY(idSignalement),
   FOREIGN KEY(idStatus) REFERENCES Status(idStatus),
   FOREIGN KEY(idTypeSignalement) REFERENCES TypeSignalement(idTypeSignalement)
);

CREATE TABLE Utilisateurs(
   idUtilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   mail VARCHAR(255),
   identifiant VARCHAR(50),
   motDePasseHash VARCHAR(255),
   estActif BOOLEAN,
   idRoles INT NOT NULL,
   PRIMARY KEY(idUtilisateur),
   FOREIGN KEY(idRoles) REFERENCES Roles(idRoles)
);


CREATE TABLE AjouterPJ(
   idSignalement INT,
   idPJ INT,
   PRIMARY KEY(idSignalement, idPJ),
   FOREIGN KEY(idSignalement) REFERENCES Signalement(idSignalement),
   FOREIGN KEY(idPJ) REFERENCES PieceJointe(idPJ)
);

CREATE TABLE Messagerie(
   idMessage INT AUTO_INCREMENT,
   idSignalement INT NOT NULL,
   idUtilisateur INT NULL,
   origine ENUM('ADMIN','RH', 'SIGNALEUR') NOT NULL,
   contenu TEXT NOT NULL,
   dateMessage DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (idMessage),
   FOREIGN KEY(idSignalement) REFERENCES Signalements(idSignalement),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateurs(idUtilisateur)
);

CREATE TABLE Log(
   idLog INT AUTO_INCREMENT,
   action varchar(255),
   detail varchar(255),
   date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   utilisateur varchar(255),
   resultat BOOLEAN,
   PRIMARY KEY(idLog)
);

-- Valeurs lors de la création de la DB

INSERT INTO roles(libelle) VALUES
('admin'),
('RH'),
('Juriste');

INSERT INTO TypeSignalement(libelle) VALUES
('Harcèlement'),
('Corruption'),
('Fraude'),
('Sécurité'),
('Autre');

INSERT INTO Status(libelle) VALUES
('Nouveau'),('En cours'),('Traité');

INSERT INTO Utilisateurs(idUtilisateur, nom, prenom,mail, identifiant, motDePasseHash, estActif, idRoles) VALUES 
('0', 'Utilisateur', 'Supprimé', NULL, NULL, 'AUCUN', '0', '0'),
('1', 'Admin', 'Admin','admin@LegalTech.com','admin','DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73',1,1); 
-- mot de passe admin : 123


