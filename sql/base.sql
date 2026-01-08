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
   dateDepot DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   estAnonyme BOOLEAN NOT NULL,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   numeroDossier VARCHAR(16) NOT NULL,
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
   idRoles INT NOT NULL,
   PRIMARY KEY(idUtilisateur),
   FOREIGN KEY(idRoles) REFERENCES Roles(idRoles)
);

CREATE TABLE Historique(
   idHistorique INT AUTO_INCREMENT,
   action VARCHAR(50),
   detail TEXT,
   dateAction DATETIME,
   idUtilisateur INT NOT NULL,
   idSignalement INT NOT NULL,
   PRIMARY KEY(idHistorique),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
   FOREIGN KEY(idSignalement) REFERENCES Signalement(idSignalement)
);

CREATE TABLE AjouterCommentaire(
   idSignalement INT,
   idUtilisateur INT,
   contenu TEXT,
   dateCommentaire DATETIME,
   PRIMARY KEY(idSignalement, idUtilisateur),
   FOREIGN KEY(idSignalement) REFERENCES Signalement(idSignalement),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
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
   origine ENUM('RH', 'SIGNALEUR') NOT NULL,

   contenu TEXT NOT NULL,
   dateMessage DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

   PRIMARY KEY (idMessage),
   FOREIGN KEY(idSignalement) REFERENCES Signalements(idSignalement),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateurs(idUtilisateur)
);



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
('Nouveau'),('En cours'),('Traiter');