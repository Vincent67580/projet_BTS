<!-- public/depot.php -->
<?php
include __DIR__ . '/../views/layout/header.php';
require_once __DIR__ . '/../src/db.php';

$pdo = get_pdo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $type = $_POST['idTypeSignalement'];
    $contenu = $_POST['contenu'];
    $estAnonyme = isset($_POST['estAnonyme']) ? 1 : 0;
    $nom = $estAnonyme ? null : $_POST['nom'];
    $prenom = $estAnonyme ? null : $_POST['prenom'];
    $mdp = $_POST['mdp'];
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
?>

<style>
.ajout{
    color:green;
}

.btn {
    padding: 5px 12px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
</style>


<p class = "ajout" >Alerte enregistrée avec succès !</p>
<p>Votre numéro de dossier : <strong><?=$numeroDossier?></strong></p>
<a class = "btn" href="index.php">Retour à l'accueil</a>


    <?php
} else {
    include __DIR__ . '/../views/depot_alerte.php';
}
?>

<?php include __DIR__.'/../views/layout/footer.php'; ?>



<script>
// Script qui signal que le fichier est trop volumineux ou pas autoriser
document.getElementById('formAlerte').addEventListener('submit', function(e) {
    let fichiers = document.getElementById('pj').files;
    let errorPJ = document.getElementById('errorPJ');
    errorPJ.style.display = 'none';
    errorPJ.textContent = '';

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



// Script qui affiche et permet de supprimer les fichiers
const inputPJ = document.getElementById('pj');
const listePJ = document.getElementById('listePJ');

// Objet qui va stocker les fichiers sélectionnés
let fichiersSelectionnes = new DataTransfer();

inputPJ.addEventListener('change', function () {
    for (const file of this.files) {
        // Sécurité : uniquement images
        if (!file.type.startsWith('image/')) {
            alert("Seules les images sont autorisées");
            continue;
        }
        fichiersSelectionnes.items.add(file);
        afficherPJ(file);
    }
    // Mise à jour réelle de l'input file
    inputPJ.files = fichiersSelectionnes.files;
});

// Affichage dans la liste
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

    listePJ.appendChild(li);
}

// Suppression d’un fichier
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


// script infomrant les donnée a saisir manquante 
const form = document.getElementById("formAlerte");
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

// Mot de passe (robustesse)
const regexMaj = /[A-Z]/;
const regexMin = /[a-z]/;
const regexChiffre = /[0-9]/;
const regexSpecial = /[\W_]/;

form.addEventListener("submit", function(e) {
    let valid = true;

    // Type de signalement
    if(typeSignalement.value === "") {
        errorType.textContent = "Veuillez choisir un type de signalement.";
        errorType.style.display = "block";
        valid = false;
    } else {
        errorType.style.display = "none";
    }

    // Description
    if(description.value.trim() === "") {
        errorDescription.textContent = "Veuillez remplir la description.";
        errorDescription.style.display = "block";
        valid = false;
    } else {
        errorDescription.style.display = "none";
    }

    // Nom et prénom si non anonyme
    if(!estAnonyme.checked) {
        if(nom.value.trim() === "" || prenom.value.trim() === "") {
            errorNomPrenom.textContent = "Veuillez remplir le nom et le prénom ou cocher 'Déposer anonymement'.";
            errorNomPrenom.style.display = "block";
            valid = false;
        } else {
            errorNomPrenom.style.display = "none";
        }
    } else {
        errorNomPrenom.style.display = "none";
    }

    // Mot de passe
    if (mdp.value.trim() === "") {
        errorMdp.textContent = "Veuillez saisir un mot de passe pour consulter l'alerte.";
        errorMdp.style.display = "block";
        valid = false;
    }
    else if (mdp.value.length < 12) {
        errorMdp.textContent = "Le mot de passe doit contenir au moins 12 caractères.";
        errorMdp.style.display = "block";
        valid = false;
    }
    else if (!regexMaj.test(mdp.value)) {
        errorMdp.textContent = "Le mot de passe doit contenir au moins une majuscule.";
        errorMdp.style.display = "block";
        valid = false;
    }
    else if (!regexMin.test(mdp.value)) {
        errorMdp.textContent = "Le mot de passe doit contenir au moins une minuscule.";
        errorMdp.style.display = "block";
        valid = false;
    }
    else if (!regexChiffre.test(mdp.value)) {
        errorMdp.textContent = "Le mot de passe doit contenir au moins un chiffre.";
        errorMdp.style.display = "block";
        valid = false;
    }
    else if (!regexSpecial.test(mdp.value)) {
        errorMdp.textContent = "Le mot de passe doit contenir au moins un caractère spécial.";
        errorMdp.style.display = "block";
        valid = false;
    }
    else {
        errorMdp.style.display = "none";
    }

    if(!valid) {
        e.preventDefault(); // empêche l'envoi si un champ est invalide
    }
});


// Si la case anonymat est cochée, cacher nom/prénom
document.querySelector("input[name='estAnonyme']").addEventListener("change", function() {
    document.getElementById("infosPerso").style.display = this.checked ? "none" : "block";
});
</script>