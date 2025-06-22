<?php
session_start();
include("config.php");

// --- Security & Initialization ---

// Redirect to login if the user is not authenticated.
if (!isset($_SESSION['easybm_id'])) {
    header('location: login.php');
    exit();
}

// Enforce role-based access. Users must have this role to view the page.
if (!has_role('Consulter Clients')) {
    header('location: 404.php');
    exit();
}

// --- Pagination & Data Fetching (Secure) ---

// Get pagination settings from user parameters, with a safe default.
$nb = $parametres['nbrows'] ?? 50;
if (empty($nb) || !is_numeric($nb) || $nb <= 0) {
    $nb = 50;
}

// Get total number of clients for pagination, respecting user permissions.
$count_params = [];
$count_sql = "SELECT COUNT(*) FROM clients WHERE trash='1'";

// Build a secure list of company IDs the user is allowed to see.
$allowed_companies = [];
if (!empty($_SESSION['easybm_companies'])) {
    // Ensure the session string is clean and create an array of IDs
    $company_ids = explode(',', preg_replace('/[^0-9,]/', '', $_SESSION['easybm_companies']));
    $allowed_companies = array_filter($company_ids, function($id) {
        return $id > 0;
    });
}

// If the user is not a superadmin and has specific company assignments, filter the query.
if ($_SESSION['easybm_superadmin'] != '1' && !empty($allowed_companies)) {
    $placeholders = implode(',', array_fill(0, count($allowed_companies), '?'));
    $count_sql .= " AND company IN ($placeholders)";
    $count_params = $allowed_companies;
}

$stmt_total = $bdd->prepare($count_sql);
$stmt_total->execute($count_params);
$total_clients = $stmt_total->fetchColumn();

$nbpages = ceil($total_clients / $nb);

// The vulnerable DB_Sanitize() function is no longer needed and has been removed.
?>
