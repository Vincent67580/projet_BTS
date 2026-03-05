<?php

class SignalementModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('
            SELECT si.idSignalement, si.numeroDossier, ty.libelle AS libelleType,
                   si.contenu, st.libelle AS libelleStatus, si.dateDepot,
                   si.estAnonyme, si.nom, si.prenom
            FROM Signalements si
            JOIN Status st ON st.idStatus = si.idStatus
            JOIN TypeSignalement ty ON ty.idTypeSignalement = si.idTypeSignalement
            WHERE si.idSignalement = ?
        ');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function findByNumeroDossier(string $numero): ?array
    {
        $stmt = $this->pdo->prepare('
            SELECT si.idSignalement, si.numeroDossier, ty.libelle AS libelleType,
                   si.contenu, st.libelle AS libelleStatus, si.dateDepot,
                   si.estAnonyme, si.nom, si.prenom, si.motDePasse
            FROM Signalements si
            JOIN Status st ON st.idStatus = si.idStatus
            JOIN TypeSignalement ty ON ty.idTypeSignalement = si.idTypeSignalement
            WHERE si.numeroDossier = ?
        ');
        $stmt->execute([$numero]);

        return $stmt->fetch() ?: null;
    }
}