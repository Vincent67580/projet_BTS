<?php

class DepotModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insererSignalement(array $data): int
    {
    
        $sql = "
            INSERT INTO Signalements
            (contenu, estAnonyme, nom, prenom, numeroDossier, motDePasse, idStatus, idTypeSignalement)
            VALUES
            (:contenu, :estAnonyme, :nom, :prenom, :numeroDossier, :motDePasse, 1, :type)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':contenu' => $data['contenu'],
            ':estAnonyme' => $data['estAnonyme'],
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':numeroDossier' => $data['numeroDossier'],
            ':motDePasse' => $data['motDePasse'],
            ':type' => $data['type']
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function ajouterPieceJointe(array $pj): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO PieceJointe (nomFichier, cheminFichier, tailleOctet, dateDepot)
            VALUES (:nom, :chemin, :taille, NOW())
        ");

        $stmt->execute([
            ':nom' => $pj['nom'],
            ':chemin' => $pj['chemin'],
            ':taille' => $pj['taille']
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function lierPieceJointe(int $idSignalement, int $idPJ): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO AjouterPJ (idSignalement, idPJ)
            VALUES (:signalement, :pj)
        ");

        $stmt->execute([
            ':signalement' => $idSignalement,
            ':pj' => $idPJ
        ]);
    }

}