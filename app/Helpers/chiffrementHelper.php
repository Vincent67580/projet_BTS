<?php

function cesar_chiffrer($texte, $decalage = 3) { 

    $texte_ansi = mb_convert_encoding($texte, "ISO-8859-1", "UTF-8"); 

    $resultat = ""; 

    for ($i = 0; $i < strlen($texte_ansi); $i++) { 

        $resultat .= chr(ord($texte_ansi[$i]) + $decalage); 

    } 

    return base64_encode($resultat); 

} 

 

function cesar_dechiffrer($texte_chiffre, $decalage = 3) { 

    $texte_chiffre = base64_decode($texte_chiffre); 

     

    $resultat_ansi = ""; 

    for ($i = 0; $i < strlen($texte_chiffre); $i++) { 

        $resultat_ansi .= chr(ord($texte_chiffre[$i]) - $decalage); 

    } 

    return mb_convert_encoding($resultat_ansi, "UTF-8", "ISO-8859-1"); 

} 