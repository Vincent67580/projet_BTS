<?php

class SignaleurModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function emailExiste(string $email): bool {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM signaleur WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function insererSignaleur(array $data): int {
        $stmt = $this->pdo->prepare('
            INSERT INTO signaleur (Nom, Prenom, email, telephone, password)
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['password']
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function findByEmail(string $email): ?array {
    $stmt = $this->pdo->prepare('SELECT * FROM signaleur WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch() ?: null;
}
}