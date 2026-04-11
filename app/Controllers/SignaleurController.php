<?php

require_once __DIR__ . '/../Models/SignaleurModel.php';
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Helpers/logHelper.php';

class SignaleurController {

    public function inscription() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require BASE_PATH . '/app/Views/layout/header.php';
            require BASE_PATH . '/app/Views/Signaleur/inscription.php';
            require BASE_PATH . '/app/Views/layout/footer.php';
            return;
        }

        $pdo   = get_pdo();
        $model = new SignaleurModel($pdo);

        $nom       = trim($_POST['nom'] ?? '');
        $prenom    = trim($_POST['prenom'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $mdp       = $_POST['password'] ?? '';
        $mdpConfirm = $_POST['password_confirm'] ?? '';

        $erreurs = [];

        if (empty($nom))       $erreurs[] = 'Le nom est obligatoire.';
        if (empty($prenom))    $erreurs[] = 'Le prénom est obligatoire.';
        if (empty($email))     $erreurs[] = 'L\'email est obligatoire.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = 'Email invalide.';
        if (empty($mdp))       $erreurs[] = 'Le mot de passe est obligatoire.';
        if ($mdp !== $mdpConfirm) $erreurs[] = 'Les mots de passe ne correspondent pas.';
        if ($model->emailExiste($email)) $erreurs[] = 'Cet email est déjà utilisé.';

        if (!empty($erreurs)) {
            $formData = $_POST;
            require BASE_PATH . '/app/Views/layout/header.php';
            require BASE_PATH . '/app/Views/Signaleur/inscription.php';
            require BASE_PATH . '/app/Views/layout/footer.php';
            return;
        }

        $idSignaleur = $model->insererSignaleur([
            'nom'       => $nom,
            'prenom'    => $prenom,
            'email'     => $email,
            'telephone' => $telephone,
            'password'  => password_hash($mdp, PASSWORD_DEFAULT)
        ]);

        writeLog('INSCRIPTION', ['idSignaleur' => $idSignaleur, 'email' => $email]);

        // Connecte directement après inscription
        $_SESSION['user_id']   = $idSignaleur;
        $_SESSION['user_nom']  = $nom;
        $_SESSION['user_prenom'] = $prenom;

        header('Location: ' . BASE_URL . 'index.php?page=home');
        exit;
    }

    public function login() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signaleur/login.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
        return;
    }

    $pdo   = get_pdo();
    $model = new SignaleurModel($pdo);

    $email = trim($_POST['email'] ?? '');
    $mdp   = $_POST['password'] ?? '';

    $signaleur = $model->findByEmail($email);

    if (!$signaleur || !password_verify($mdp, $signaleur['password'])) {
        writeLog('LOGIN_ECHOUE', ['email' => $email]);
        $erreur = 'Email ou mot de passe incorrect.';
        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signaleur/login.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
        return;
    }

    writeLog('LOGIN_REUSSI', ['idSignaleur' => $signaleur['idSignaleur'], 'email' => $email]);

    $_SESSION['user_id']     = $signaleur['idSignaleur'];
    $_SESSION['user_nom']    = $signaleur['Nom'];
    $_SESSION['user_prenom'] = $signaleur['Prenom'];

    header('Location: ' . BASE_URL . 'index.php?page=home');
    exit;
}

public function logout() {
    writeLog('DECONNEXION', ['idSignaleur' => $_SESSION['user_id'] ?? 'inconnu']);
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . 'index.php?page=home');
    exit;
}
}