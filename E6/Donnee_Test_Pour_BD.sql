-- Donnée de test pour la base de donnée
USE ProjetBTS;
-- Mot de passe : AZE123aze123!
INSERT INTO signalements(idSignalement, contenu, dateDepot, estAnonyme, nom, prenom, numeroDossier, motDePasse, idStatus, idTypeSignalement, dateCloture) VALUES 
(NULL, 'Comportement inapproprié et pressions répétées d un manager sur son équipe.', '2026-03-21 11:23:26', '1', NULL, NULL, '26033100000000', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '2', '1', NULL),
(NULL, 'Soupçons de détournement de fonds via des fausses factures de prestataires informatiques.', '2026-03-22 11:23:26', '1', NULL, NULL, '26033100000001', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '2', '3', NULL),
(NULL, 'Non-respect des consignes de sécurité et absence de port d EPI sur le site de production.', '2026-03-22 17:23:26', '1', NULL, NULL, '26033100000002', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '1', '4', NULL),
(NULL, 'Utilisation de la carte carburant de l entreprise à des fins personnelles durant les week-ends.', CURRENT_TIMESTAMP, '1', NULL, NULL, '26033100000003', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '1', '3', NULL),
(NULL, 'Tentative d offre de cadeau hors charte par un fournisseur pour influencer un appel d offre.', '2026-03-23 11:23:26', '1', NULL, NULL, '26033100000004', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '3', '2', '2026-03-28 09:18:58'),
(NULL, 'Propos discriminatoires tenus lors d un entretien de recrutement interne.', '2026-03-24 11:23:26', '1', NULL, NULL, '26033100000005', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '3', '5', '2026-03-30 09:18:58'),
(NULL, 'Mise à l écart systématique d un collaborateur suite à un retour de congé maladie.', CURRENT_TIMESTAMP, '1', NULL, NULL, '26033100000006', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '2', '1', NULL),
(NULL, 'Sortie de secours condamnée par du stockage de palettes en zone A.', '2026-03-25 11:23:26', '1', NULL, NULL, '26033100000007', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '3', '4', '2026-03-30 14:18:58'),
(NULL, 'Soupçon de lien d intérêt non déclaré entre un acheteur et un sous-traitant de maintenance.', CURRENT_TIMESTAMP, '1', NULL, NULL, '26033100000008', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '1', '2', NULL),
(NULL, 'Paiements facilités demandés par un agent local pour accélérer un permis administratif.', CURRENT_TIMESTAMP, '1', NULL, NULL, '26033100000009', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '1', '2', NULL),
(NULL, 'Insultes verbales répétées en open-space devant témoins.', '2026-03-27 11:23:26','', 'Jean-pierre', 'Papier', '26032700000010', '$2y$10$2NuSDqW0JZPSKJarlI5B5.I52PYXre0uMBO2EDJ732ZsG83PHrtAq', '3', '1','2026-03-31 09:18:58')
;

-- mot de passe des utilisateurs : 123
INSERT INTO utilisateurs(idUtilisateur, nom, prenom, mail, identifiant, motDePasseHash, estActif, idRoles) VALUES 
(NULL, 'Bonnet', 'Vincent', 'vbonnet@LegalTech.com', 'vbonnet', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '1', '2'),
(NULL, 'Durand', 'Marie', 'mdurand@LegalTech.com', 'mdurand', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '1', '2'),
(NULL, 'Lefebvre', 'Thomas', 'tlefebvre@LegalTech.com', 'tlefebvre', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '1', '3'),
(NULL, 'Moreau', 'Sophie', 'smoreau@LegalTech.com', 'smoreau', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '1', '2'),
(NULL, 'Petit', 'Lucas', 'lpetit@LegalTech.com', 'lpetit', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '0', '3'),
(NULL, 'Garcia', 'Isabelle', 'igarcia@LegalTech.com', 'igarcia', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '1', '2'),
(NULL, 'Rousseau', 'Antoine', 'arousseau@LegalTech.com', 'arousseau', 'DD ED B0 2F 7A B3 14 CB 57 0C 85 E8 8D EA BD EA\r\n3B C1 65 DC 6B 1C 84 D6 7F DD A0 1F 39 A0 54 73', '1', '3')
;



INSERT INTO messagerie (idMessage, idSignalement, idUtilisateur, origine, contenu, dateMessage) VALUES 
(NULL, '1', NULL, 'SIGNALEUR', 'RXJxbXJ4dS8jbWgjdnJ4a2Rsd2gjdmxqcWRvaHUjeHEjZnJwc3J1d2hwaHF3I2xxZHNzdXJzdWzsI2R4I3ZobHEjZ3gjdmh1eWxmaCNPcmpsdndsdHhoMQ==', '2026-03-21 10:00:00'),
(NULL, '1', 5, 'RH', 'SHF3aHFneDEjU3J4eWh9MHlyeHYjcXJ4diNzdexmbHZodSNvZCNnZHdoI2dodiNpZGx3diNkbHF2bCN0eGgjb2h2I3NodXZycXFodiNscHNvbHR47Gh2I0I=', '2026-03-21 14:30:00'),
(NULL, '1', NULL, 'SIGNALEUR', 'RmhvZCN2Kmh2dyNzZHZ27CNwZHVnbCNnaHVxbGh1I+Mjb2QjZmRp7HfsdWxkMSNTb3h2bGh4dXYjd+xwcmxxdiPsd2RsaHF3I3N17HZocXd2MQ==', '2026-03-22 09:15:00'),
(NULL, '1', 5, 'RH', 'UGh1Zmwjc3J4dSNmaHYjc3XsZmx2bHJxdjEjUXJ4diNyeHl1cnF2I3hxaCNocXR47XdoI2xxd2h1cWgxI1lyeHYjdmh1aH0jbHFpcnVw7CNnaCNvZCN2eGx3aCNsZmwwcO1waDE=', '2026-03-22 11:00:00'),

(NULL, '2', NULL, 'SIGNALEUR', 'TSpkbCN1aHBkdXR47CNnaHYjZHFycGRvbGh2I2dkcXYjb2h2I3Fyd2h2I2doI2l1ZGx2I2d4I3ZodXlsZmgjRGZrZHd2I2doc3hsdiNnaHh7I3BybHYx', '2026-03-23 10:00:00'),
(NULL, '2', 2, 'RH', 'RXJxbXJ4dTEjRHlofTB5cnh2I3N4I2xnaHF3bGlsaHUjZ2h2I3BycXdkcXd2I3N17GZsdiNyeCNnaHYjaXJ4dXFsdnZoeHV2I2ZycWZodXHsdiNC', '2026-03-23 14:30:00'),
(NULL, '2', NULL, 'SIGNALEUR', 'TG8jdipkamx3I2doI2lkZnd4dWh2I2doI3Bkd+x1bGhvI2xxaXJ1cGR3bHR4aCN0eGwjcWgjdnJxdyNtZHBkbHYjZHV1bHnsaHYjZHgjdndyZm4x', '2026-03-24 09:15:00'),
(NULL, '2', 2, 'RH', 'RipodncjcXJ37DEjUXJ3dWgjdmh1eWxmaCNmcnBzd2RlbG9sd+wjeWQjaGlpaGZ3eGh1I3hxI2R4Z2x3I2xxd2h1cWgjZ+t2I2docGRscTE=', '2026-03-24 11:00:00')
;
