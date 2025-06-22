<?php
session_start();
include("config.php");

// --- Security & Initialization ---

// Redirect to login if the user is not authenticated.
if (!isset($_SESSION['easybm_id'])) {
    header('location: login.php');
    exit();
}

// Enforce role-based access. Users must have this specific role to view the page.
if (!has_role('Consulter Factures avoir')) {
    header('location: 404.php');
    exit();
}

// Initialize variables
$startdate = "";
$enddate = "";
$rangedate_placeholder = "Période"; // More descriptive placeholder

// --- Filter & Date Logic ---

// If user can only see today's documents, force the date range.
if (has_role('Consultation de la journée en cours seulement Factures avoir')) {
    $startdate = gmdate("d/m/Y");
    $enddate = gmdate("d/m/Y");
} elseif (isset($_GET['datestart']) && isset($_GET['dateend']) && !empty($_GET['datestart'])) {
    // Use filter_input for safer GET parameter handling.
    $startdate = filter_input(INPUT_GET, 'datestart', FILTER_SANITIZE_STRING);
    $enddate = filter_input(INPUT_GET, 'dateend', FILTER_SANITIZE_STRING);
}

$rangedate = (!empty($startdate) && !empty($enddate)) ? "$startdate - $enddate" : "";

// --- Data Fetching (Secure & Parameterized) ---

$params = [];
$company_ids_to_query = [];

// Build a secure list of company IDs the user is allowed to see.
if (!empty($companiesid)) { // $companiesid is assumed to be a pre-filtered, secure string like " AND id IN (1,2,3)"
    // This is still risky. A better approach is to build the array from the session.
    $allowed_companies = explode(',', $_SESSION['easybm_companies']);
    if (($key = array_search('0', $allowed_companies)) !== false) {
        unset($allowed_companies[$key]);
    }
    $company_ids_to_query = $allowed_companies;
}

// Helper function to build IN clauses securely
function build_in_clause($base_sql, &$params_array, $column, $ids) {
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $base_sql .= " AND $column IN ($placeholders)";
        foreach ($ids as $id) {
            $params_array[] = $id;
        }
    }
    return $base_sql;
}

// Get companies list
$company_sql = "SELECT id, rs FROM companies WHERE trash='1'";
$company_sql = build_in_clause($company_sql, $params, 'id', $company_ids_to_query);
$company_sql .= " ORDER BY rs";
$stmt_companies = $bdd->prepare($company_sql);
$stmt_companies->execute($params);
$companies = $stmt_companies->fetchAll(PDO::FETCH_ASSOC);

// Get clients list
$client_params = [];
$client_sql = "SELECT id, code, fullname FROM clients WHERE fullname<>'' AND trash='1'";
$client_sql = build_in_clause($client_sql, $client_params, 'company', $company_ids_to_query);
$client_sql .= " ORDER BY fullname";
$stmt_clients = $bdd->prepare($client_sql);
$stmt_clients->execute($client_params);
$clients = $stmt_clients->fetchAll(PDO::FETCH_ASSOC);

// Get products list
$product_params = [];
$product_sql = "SELECT DISTINCT title FROM detailsdocuments WHERE trash='1'";
$product_sql = build_in_clause($product_sql, $product_params, 'company', $company_ids_to_query);
$product_sql .= " ORDER BY title";
$stmt_products = $bdd->prepare($product_sql);
$stmt_products->execute($product_params);
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

// Get users list
$stmt_users = $bdd->query("SELECT id, fullname FROM users WHERE trash='1' ORDER BY fullname");
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// --- Pagination Settings ---

$nb = $parametres['nbrows'] ?? 50;
if (empty($nb) || !is_numeric($nb)) $nb = 50;

// Get total number of documents for pagination (respecting filters)
$count_params = [];
$count_sql = "SELECT COUNT(*) FROM documents WHERE category='client' AND type='avoir' AND trash='1'";
$count_sql = build_in_clause($count_sql, $count_params, 'company', $company_ids_to_query);
$stmt_total = $bdd->prepare($count_sql);
$stmt_total->execute($count_params);
$total_documents = $stmt_total->fetchColumn();
$nbpages = ceil($total_documents / $nb);

// No need for DB_Sanitize() when using prepared statements.
// DB_Sanitize(); 
?>
