<?php

class SignalementModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    //Connexions au signalement
    public function findDossier(string $numeroDossier){
    $stmt = $this->pdo->prepare('SELECT * FROM Signalements WHERE numeroDossier = :numeroDossier');
    $stmt->execute([
        'numeroDossier' => $numeroDossier
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
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

   public function findPiecesJointes(int $idSignalement): array
{
    $stmt = $this->pdo->prepare('
        SELECT pj.nomFichier, pj.cheminFichier
        FROM PieceJointe pj
        JOIN AjouterPJ ap ON ap.idPJ = pj.idPJ
        WHERE ap.idSignalement = ?
    ');
    $stmt->execute([$idSignalement]);
    return $stmt->fetchAll();
}
}
