DROP DATABASE IF EXISTS ProjetBTS;
CREATE DATABASE ProjetBTS;

USE ProjetBTS;

CREATE TABLE roles(
    idRoles INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table des utilisateurs (RH, juriste et admin)
CREATE TABLE utilisateurs(
    idUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    identifiant VARCHAR(255) NOT NULL,
    motDePasse VARCHAR(255) NOT NULL,
    idRoles INT,
    FOREIGN KEY (idRoles) REFERENCES roles(idRoles)
);

-- Tables des signalements
CREATE TABLE signalements(
    idSignalement INT AUTO_INCREMENT PRIMARY KEY,
    typeSignalement VARCHAR(255) NOT NULL,
    description TEXT,
    status VARCHAR(255) NOT NULL,
    dateDepot DATETIME DEFAULT CURRENT_TIMESTAMP,
    dateCloture DATETIME NULL,
    estAnonyme BOOLEAN NOT NULL,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    numeroDossier BIGINT UNIQUE,
    motDePasse VARCHAR(255) NOT NULL,
    idUtilisateur INT DEFAULT NULL, -- Utilisateur (RH) a qui est affecter le signalement 
    FOREIGN KEY (idUtilisateur) REFERENCES utilisateurs(idUtilisateur)
);


-- INSERT INTO roles(nom) VALUES
-- ('admin'),
-- ('RH'),
-- ('Juriste');

-- INSERT into utilisateurs(nom,prenom,login,motDePasse,idRoles) VALUES
-- ('bonnet','vincent','vbonnet','123456',1),
-- ('aaaaa','aa','vbonnet','azazazazazaz',2),
-- ('bbbbb','bb','vbonnet','bnbnbnbnbnbn',3),
-- ('ccccc','cc','vbonnet','cvcvcvcvcvcv',3),
-- ('ddddd','dd','vbonnet','dfdfdfdfdfdf',2),
-- ('eeeee','ee','vbonnet','erererererer',2);

-- INSERT INTO signalements(typeSignalement,description,status,dateCloture,estAnonyme,nom,prenom,numeroDossier,motDePasse) VALUES
-- -- 1. Signalement non anonyme
-- ('Harcèlement moral','Comportement irrespectueux répété d’un supérieur.','En cours',NULL,0,
--  'Martin','Julie',100001,'mdp123'),

-- -- 2. Signalement anonyme
-- ('Discrimination','Traitement inégal dû à l’origine perçue.','Nouveau',NULL,1,
--  NULL,NULL,100002,'azerty'),

-- -- 3. Corruption présumée
-- ('Corruption','Demande d’avantage en échange d’un service professionnel.','Résolu','2025-02-05 14:12:00',0,
--  'Durand','Paul',100003,'secret1'),

-- -- 4. Risque professionnel
-- ('Risque professionnel','Matériel défaillant dans l’atelier.','En cours',NULL,1,
--  NULL,NULL,100004,'xyz789'),

-- -- 5. Harcèlement sexuel (anonyme)
-- ('Harcèlement sexuel','Comportements déplacés et remarques inappropriées.','Nouveau',NULL,1,
--  NULL,NULL,100005,'pass999');


-- INSERT INTO signalements(typeSignalement,description,status,dateCloture,estAnonyme,nom,prenom,numeroDossier,motDePasse,idUtilisateur) VALUES
-- -- 6. Signalement non anonyme pris en charge par un utilisateurs
-- ('Harcèlement moral','Comportement irrespectueux répété d’un supérieur.','En cours',NULL,0,
--  'Martin','Julie',100006,'mdp123',1);