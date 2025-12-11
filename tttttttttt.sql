DROP DATABASE IF EXISTS tttttttttt;
CREATE DATABASE tttttttttt;

USE tttttttttt;

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

CREATE TABLE Signalement(
   idSignalement INT AUTO_INCREMENT,
   contenu VARCHAR(255),
   dateDepot DATETIME NOT NULL,
   estAnonyme BOOLEAN NOT NULL,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   numeroDossier VARCHAR(50) NOT NULL,
   motDePasse VARCHAR(50) NOT NULL,
   idStatus INT NOT NULL,
   idTypeSignalement INT NOT NULL,
   PRIMARY KEY(idSignalement),
   FOREIGN KEY(idStatus) REFERENCES Status(idStatus),
   FOREIGN KEY(idTypeSignalement) REFERENCES TypeSignalement(idTypeSignalement)
);

CREATE TABLE Utilisateur(
   idUtilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   mail VARCHAR(50),
   identifiant VARCHAR(50),
   motDePasseHash VARCHAR(50),
   idRoles INT NOT NULL,
   PRIMARY KEY(idUtilisateur),
   FOREIGN KEY(idRoles) REFERENCES Roles(idRoles)
);

CREATE TABLE Historique(
   idHistorique INT AUTO_INCREMENT,
   action VARCHAR(50),
   detail VARCHAR(50),
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
   contenu VARCHAR(50),
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
