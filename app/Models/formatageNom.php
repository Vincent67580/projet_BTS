<!--app/Models/formatageNom.php  -->
<!-- permet de formater le nom et prenom meme si javascript est désactivé sur la page -->
<?php

function mb_ucfirst(string $str, string $encoding = 'UTF-8'): string
{
    if ($str === '') return '';
    return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding)
         . mb_substr($str, 1, null, $encoding);
}


// Fonction pour formater un nom propre (ex: jean-pierre -> Jean-Pierre)

function formatProperName($name) {
    if (empty($name)) return null;
    
    // On convertit tout en minuscule pour commencer (UTF-8)
    $name = mb_strtolower(trim($name), 'UTF-8');
    
    // Formater après les espaces
    $parts = explode(' ', $name);
    foreach ($parts as &$part) {
        // Formater après les tirets
        $subparts = explode('-', $part);
        foreach ($subparts as &$subpart) {
            $subpart = mb_ucfirst($subpart);
        }
        $part = implode('-', $subparts);
    }
    return implode(' ', $parts);
}
