<!-- views/layout/header.php -->


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRCompliance - Signalement Interne</title>
    <link rel="stylesheet" href="/projet_BTS/public/assets/css/main.css">
    <!-- ajout d'une police plus moderne -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<style>
    header{
        background: white; 
        border-bottom: 1px solid var(--border-color); 
        padding: 1rem 0;
    }

    .header-div{
        max-width: 1000px; 
        margin: 0 auto; 
        padding: 0 1rem; 
        display: flex; 
        justify-content: space-between; 
        align-items: center;
    }
    .logo-entreprise{
        text-decoration: none; 
        color: var(--primary-color); 
        font-weight: 800; 
        font-size: 1.25rem;
    }
    .nav-lien{
        color: var(--text-muted); 
        text-decoration: none; 
        font-size: 0.9rem;
    }
        .nav-lien:hover{
            color: var(--primary-color);
        }   

</style>

<body>
    <header>
        <div class="header-div">
            <a class="logo-entreprise" href="<?= BASE_URL ?>index.php?page=home" >
                HRCompliance
            </a>
            <nav>
                <a class="nav-lien " href="<?= BASE_URL ?>index.php?page=home">Accueil</a>
            </nav>
        </div>
    </header>
    <main>