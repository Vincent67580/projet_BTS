<?php 
require_once __DIR__ . '/../config/db.php';

class AllSignalementsModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSignalementsByUser($userId)
    {
        $sql = "SELECT 
                    s.numeroDossier,
                    t.libelle AS typeSignalement,
                    s.dateDepot
                FROM Signalements s
                JOIN TypeSignalement t ON s.idTypeSignalement = t.idTypeSignalement
                WHERE s.idSignaleur = :user_id
                ORDER BY s.dateDepot DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}