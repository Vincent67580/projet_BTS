<?php

require_once __DIR__ . '/../Helpers/chiffrementHelper.php';

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

         $messages = $stmt->fetchAll();

        foreach ($messages as &$message) {
        $message['contenu'] = cesar_dechiffrer($message['contenu']);
        }

        return $messages;
    }

    public function envoyerMessage(int $idSignalement, string $contenu): void {
        $contenuChiffre = cesar_chiffrer($contenu);
        $stmt = $this->pdo->prepare("
            INSERT INTO Messagerie (idSignalement, origine, contenu)
            VALUES (?, 'SIGNALEUR', ?)
        ");
        $stmt->execute([$idSignalement, $contenuChiffre]);
    }
}