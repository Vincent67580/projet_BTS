<?php

class MessagerieModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getMessages(int $idSignalement): array {
        $stmt = $this->pdo->prepare("
            SELECT origine, contenu, dateMessage
            FROM Messagerie
            WHERE idSignalement = ?
            ORDER BY dateMessage ASC
        ");
        $stmt->execute([$idSignalement]);
        return $stmt->fetchAll();
    }

    public function envoyerMessage(int $idSignalement, string $contenu): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO Messagerie (idSignalement, origine, contenu)
            VALUES (?, 'SIGNALEUR', ?)
        ");
        $stmt->execute([$idSignalement, $contenu]);
    }
}