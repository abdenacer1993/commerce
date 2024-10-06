<?php

// Démarre la session
session_start();

// Détruit la session
session_destroy();

// Redirige vers la page d'accueil ou une autre page
header('Location: ./home.php');
exit;
?>
