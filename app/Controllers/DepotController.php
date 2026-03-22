<?php

require_once __DIR__.'/../Config/db.php';
require_once __DIR__.'/../Models/DepotModel.php';
require_once __DIR__.'/../Models/verifMDP.php';

// Controller pour la page de dépôt de signalement

class DepotController {
    public function index() {

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Depot/insert.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
        
    }

    public function depot()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->index();
        }

        $pdo = get_pdo();
        $model = new DepotModel($pdo);

        $estAnonyme = isset($_POST['estAnonyme']);
        $mdp = $_POST['mdp'];
        
        $mdpModel= new verifMDP();



        $checkMdp =  $mdpModel->verifierMotDePasse($mdp);
        if (!$checkMdp['valide']) {
            $erreurMdp = $checkMdp['messages'];
            $formData = $_POST;
            return $this->index();
        }

        $numeroDossier = date('ymd') . str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

        $idSignalement = $model->insererSignalement([
            'contenu' => $_POST['contenu'],
            'estAnonyme' => $estAnonyme ? 1 : 0,
            'nom' => $estAnonyme ? null : formatProperName($_POST['nom']),
            'prenom' => $estAnonyme ? null : formatProperName($_POST['prenom']),
            'numeroDossier' => $numeroDossier,
            'motDePasse' => password_hash($mdp, PASSWORD_DEFAULT),
            'type' => $_POST['idTypeSignalement']
        ]);

        // Upload PJ
        if (!empty($_FILES['pj']['name'][0])) {
            foreach ($_FILES['pj']['name'] as $i => $name) {
                if ($_FILES['pj']['error'][$i] !== 0) continue;

                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;

                $nomFichier = bin2hex(random_bytes(16)) . '.' . $ext;
                $chemin =$nomFichier;

                move_uploaded_file($_FILES['pj']['tmp_name'][$i], __DIR__ . '/../../storage/uploads/' . $chemin);

                $idPJ = $model->ajouterPieceJointe([
                    'nom' => $nomFichier,
                    'chemin' => $chemin,
                    'taille' => $_FILES['pj']['size'][$i]
                ]);

                $model->lierPieceJointe($idSignalement, $idPJ);
            }
        }

        $_SESSION['numeroDossier_nouveau'] = $numeroDossier;

        header("Location: ".BASE_URL."index.php?page=confirmation&numero=".$numeroDossier);
        exit();

    }

        public function confirmationDepot(){

        $numero = $_GET['numero'];

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Depot/confirmations.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
    }

   
}