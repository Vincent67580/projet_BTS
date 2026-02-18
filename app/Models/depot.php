<!-- Models/depot.php -->
<?php
include __DIR__ . '/../Views/layout/header.php';
require_once __DIR__ . '/../app/Config/db.php';
require_once __DIR__ . '/../app/Models/formatageNom.php';
require_once __DIR__ . '/../app/Models/verifMDP.php';

$pdo = get_pdo();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formData = [
        'idTypeSignalement' => $_POST['idTypeSignalement'] ?? '',
        'contenu'          => $_POST['contenu'] ?? '',
        'nom'              => $_POST['nom'] ?? '',
        'prenom'           => $_POST['prenom'] ?? '',
        'estAnonyme'       => isset($_POST['estAnonyme'])
    ];

    $erreurMdp = null;

    $type = $_POST['idTypeSignalement'];
    $contenu = $_POST['contenu'];
    $estAnonyme = isset($_POST['estAnonyme']) ? 1 : 0;
    
    // Application du formatage côté serveur pour garantir la propreté des données
    $nom = $estAnonyme ? null : formatProperName($_POST['nom']);
    $prenom = $estAnonyme ? null : formatProperName($_POST['prenom']);
    
    $mdp = $_POST['mdp'];
    $resultatMdp = verifierMotDePasse($mdp);

    if (!$resultatMdp['valide']) {
        $erreurMdp = $resultatMdp['messages']; // Tableau de toutes les erreurs
    }

    if ($erreurMdp !== null) {
        include __DIR__ . '/../Views/depot_alerte.php';
        include __DIR__ . '/../Views/layout/footer.php';
        exit;
    }

    if (!isset($erreurMdp)) {
        $hashMdp = password_hash($mdp, PASSWORD_DEFAULT);
        // Génération du numéro de dossier : YYMMDD + 8 chiffres aléatoires
        $numeroDossier = date('ymd') . str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

        // Insertion du signalement
        $stmt = $pdo->prepare("
            INSERT INTO Signalements 
            (contenu, estAnonyme, nom, prenom, numeroDossier, motDePasse, idStatus, idTypeSignalement)
            VALUES 
            (:contenu, :estAnonyme, :nom, :prenom, :numeroDossier, :motDePasse, 1, :typeSignalement)
        ");
        $stmt->execute([
            ':contenu' => $contenu,
            ':estAnonyme' => $estAnonyme,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':numeroDossier' => $numeroDossier,
            ':motDePasse' => $hashMdp,
            ':typeSignalement' => $type
        ]);

        $idSignalement = $pdo->lastInsertId();

        // Gestion des pièces jointes
        if(!empty($_FILES['pj']['name'][0])) {
            foreach($_FILES['pj']['name'] as $index => $name) {
                $tmpName = $_FILES['pj']['tmp_name'][$index];
                $size = $_FILES['pj']['size'][$index];
                $error = $_FILES['pj']['error'][$index];

                if($error === 0) {
                    $uploadDir = __DIR__.'/uploads/';
                    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    // Extensions autorisées (images uniquement)
                    $extensionsAutorisees = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                    if (!in_array($extension, $extensionsAutorisees)) {
                        continue;
                    }

                    // Nom de fichier totalement anonymisé
                    $nomAnonyme = bin2hex(random_bytes(16)) . '.' . $extension;

                    $dest = $uploadDir . $nomAnonyme;
                    $cheminRelatif = 'uploads/' . $nomAnonyme;

                    move_uploaded_file($tmpName, $dest);

                    // Enregistrer dans PieceJointe
                    $stmtPJ = $pdo->prepare("
                        INSERT INTO PieceJointe(nomFichier, cheminFichier, tailleOctet, dateDepot)
                        VALUES (:nom, :chemin, :taille, NOW())
                    ");
                    $stmtPJ->execute([
                        ':nom' => $nomAnonyme,
                        ':chemin' => $cheminRelatif,
                        ':taille' => $size
                    ]);
                    $idPJ = $pdo->lastInsertId();

                    // Lier au signalement
                    $stmtLink = $pdo->prepare("
                        INSERT INTO AjouterPJ(idSignalement, idPJ)
                        VALUES (:idSignalement, :idPJ)
                    ");
                    $stmtLink->execute([
                        ':idSignalement' => $idSignalement,
                        ':idPJ' => $idPJ
                    ]);
                }
            }
        }
    }
?>

<style>
.ajout {
    color: green;
    font-weight: bold;
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 1rem;
}
.card-success {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: white;
    text-align: center;
}
</style>

<?php if (isset($numeroDossier)) : ?>
<div class="card-success">
    <p class="ajout">Alerte enregistrée avec succès !</p>
    <p>Votre numéro de dossier : <strong><?= htmlspecialchars($numeroDossier) ?></strong></p>
    <a class="btn" href="Home/index.php">Retour à l'accueil</a>
    <a class="btn" href="consulter.php">Suivre votre signalement</a>
</div>
<?php endif; ?>

<?php
} else {
    include __DIR__ . '/../Views/Depot/insert.php';
}
?>


<?php include __DIR__.'/../Views/layout/footer.php'; ?>

<script>
// Validation des fichiers (taille et format)
document.getElementById('formAlerte').addEventListener('submit', function(e) {
    let fichiers = document.getElementById('pj').files;
    let errorPJ = document.getElementById('errorPJ');
    if(errorPJ) {
        errorPJ.style.display = 'none';
        errorPJ.textContent = '';
    }

    const maxSize = 2 * 1024 * 1024; // 2 Mo

    for (let i = 0; i < fichiers.length; i++) {
        let f = fichiers[i];
        let ext = f.name.split('.').pop().toLowerCase();
        let allowed = ['png','jpg','jpeg','gif'];
        if (!allowed.includes(ext)) {
            e.preventDefault();
            errorPJ.textContent = "Le fichier " + f.name + " n'est pas un format autorisé.";
            errorPJ.style.display = 'block';
            return false;
        }
        if (f.size > maxSize) {
            e.preventDefault();
            errorPJ.textContent = "Le fichier " + f.name + " dépasse la taille maximale de 2Mo.";
            errorPJ.style.display = 'block';
            return false;
        }
    }
});

// Affichage et suppression dynamique des pièces jointes
const inputPJ = document.getElementById('pj');
const listePJ = document.getElementById('listePJ');
let fichiersSelectionnes = new DataTransfer();

if(inputPJ) {
    inputPJ.addEventListener('change', function () {
        for (const file of this.files) {
            if (!file.type.startsWith('image/')) {
                alert("Seules les images sont autorisées");
                continue;
            }
            fichiersSelectionnes.items.add(file);
            afficherPJ(file);
        }
        inputPJ.files = fichiersSelectionnes.files;
    });
}

function afficherPJ(file) {
    const li = document.createElement('li');
    li.style.marginBottom = '5px';
    li.innerHTML = `
        ${file.name} (${Math.round(file.size / 1024)} Ko)
        <button type="button" style="margin-left:10px;">Supprimer</button>
    `;
    li.querySelector('button').addEventListener('click', function () {
        supprimerPJ(file, li);
    });
    if(listePJ) listePJ.appendChild(li);
}

function supprimerPJ(file, liElement) {
    const nouveauDT = new DataTransfer();
    for (const f of fichiersSelectionnes.files) {
        if (f !== file) {
            nouveauDT.items.add(f);
        }
    }
    fichiersSelectionnes = nouveauDT;
    inputPJ.files = fichiersSelectionnes.files;
    liElement.remove();
}

// Validation du formulaire et des champs obligatoires
const form = document.getElementById("formAlerte");
if(form) {
    const estAnonyme = document.querySelector("input[name='estAnonyme']");
    const nom = document.getElementById("nom");
    const prenom = document.getElementById("prenom");
    const typeSignalement = document.getElementById("idTypeSignalement");
    const description = document.getElementById("contenu");
    const mdp = document.getElementById("mdp");

    const errorNomPrenom = document.getElementById("errorNomPrenom");
    const errorType = document.getElementById("errorType");
    const errorDescription = document.getElementById("errorDescription");
    const errorMdp = document.getElementById("errorMdp");

    const regexMaj = /[A-Z]/;
    const regexMin = /[a-z]/;
    const regexChiffre = /[0-9]/;
    const regexSpecial = /[\W_]/;

    form.addEventListener("submit", function(e) {
        let valid = true;

        if(typeSignalement && typeSignalement.value === "") {
            errorType.textContent = "Veuillez choisir un type de signalement.";
            errorType.style.display = "block";
            valid = false;
        } else if(errorType) {
            errorType.style.display = "none";
        }

        if(description && description.value.trim() === "") {
            errorDescription.textContent = "Veuillez remplir la description.";
            errorDescription.style.display = "block";
            valid = false;
        } else if(errorDescription) {
            errorDescription.style.display = "none";
        }

        if(estAnonyme && !estAnonyme.checked) {
            if(nom.value.trim() === "" || prenom.value.trim() === "") {
                errorNomPrenom.textContent = "Veuillez remplir le nom et le prénom ou cocher 'Déposer anonymement'.";
                errorNomPrenom.style.display = "block";
                valid = false;
            } else if(errorNomPrenom) {
                errorNomPrenom.style.display = "none";
            }
        }

        if(mdp) {
            let mdpVal = mdp.value.trim();
            let msg = [];
            if (mdpVal.length < 12) msg.push("Le mot de passe doit contenir au moins 12 caractères.");
            if (!regexMaj.test(mdpVal)) msg.push("Le mot de passe doit contenir au moins une majuscule.");
            if (!regexMin.test(mdpVal)) msg.push("Le mot de passe doit contenir au moins une minuscule.");
            if (!regexChiffre.test(mdpVal)) msg.push("Le mot de passe doit contenir au moins un chiffre.");
            if (!regexSpecial.test(mdpVal)) msg.push("Le mot de passe doit contenir au moins un caractère spécial.");

            if(msg.length > 0){
                errorMdp.innerHTML = msg.map(m => "<li>" + m + "</li>").join('');
                errorMdp.style.display = "block";
                valid = false;
            } else {
                errorMdp.style.display = "none";
            }
        }

        if(!valid) e.preventDefault();
    });

    if(estAnonyme) {
        estAnonyme.addEventListener("change", function() {
            const infos = document.getElementById("infosPerso");
            if(infos) infos.style.display = this.checked ? "none" : "block";
        });
    }
}
</script>