<?php
session_start();
include("config.php");

// Initialize error message
$_SESSION['easybm_errorimport'] = "";

// Check if user is logged in
if (!isset($_SESSION['easybm_id'])) {
    header('location: login.php');
    exit();
}

// Check if user has the required role
if (!preg_match("#Consulter Fournisseurs#", $_SESSION['easybm_roles'])) {
    header('location: 404.php');
    exit();
}

// Get pagination settings
$nb = 50;
if (isset($parametres['nbrows']) && $parametres['nbrows'] != "" && $parametres['nbrows'] != "0") {
    $nb = $parametres['nbrows'];
}

// Get total number of suppliers
$back = $bdd->query("SELECT COUNT(*) AS nb FROM suppliers WHERE trash='1'");
$row = $back->fetch();
$total_suppliers = $row['nb'];
$nbpages = ceil($total_suppliers / $nb);

// Sanitize database inputs
DB_Sanitize();

?>