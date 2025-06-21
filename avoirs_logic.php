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
if (!preg_match("#Consulter Factures avoir#", $_SESSION['easybm_roles'])) {
    header('location: 404.php');
    exit();
}

// Set default values for date range
$startdate = "";
$enddate = "";
$rangedate = "";
$rangedateplaceholder = "Date création";

if (preg_match("#Consultation de la journée en cours seulement Factures avoir#", $_SESSION['easybm_roles'])) {
    $startdate = gmdate("d/m/Y");
    $enddate = gmdate("d/m/Y");
    $rangedate = $startdate . " - " . $enddate;
} elseif (isset($_GET['datestart']) && isset($_GET['dateend'])) {
    $startdate = $_GET['datestart'];
    $enddate = $_GET['dateend'];
    $rangedate = $startdate . " - " . $enddate;
}

// Get companies list
$companies = [];
$back = $bdd->query("SELECT id, rs FROM companies WHERE trash='1'" . $companiesid . " ORDER BY rs");
while ($row = $back->fetch()) {
    $companies[] = $row;
}

// Get clients list
$clients = [];
$back = $bdd->query("SELECT id, code, fullname FROM clients WHERE fullname<>''" . $multicompanies . " ORDER BY fullname");
while ($row = $back->fetch()) {
    $clients[] = $row;
}

// Get products list
$products = [];
$back = $bdd->query("SELECT DISTINCT title FROM detailsdocuments WHERE trash='1'" . $multicompanies . " ORDER BY title");
while ($row = $back->fetch()) {
    $products[] = $row;
}

// Get users list
$users = [];
$back = $bdd->query("SELECT id, fullname FROM users WHERE trash='1' ORDER BY fullname");
while ($row = $back->fetch()) {
    $users[] = $row;
}

// Get pagination settings
$nb = 50;
if (isset($parametres['nbrows']) && $parametres['nbrows'] != "" && $parametres['nbrows'] != "0") {
    $nb = $parametres['nbrows'];
}

// Get total number of documents
$back = $bdd->query("SELECT COUNT(*) AS nb FROM documents WHERE category='client' AND type='avoir' AND trash='1'");
$row = $back->fetch();
$total_documents = $row['nb'];
$nbpages = ceil($total_documents / $nb);

// Sanitize database inputs
DB_Sanitize();

?>