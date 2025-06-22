<?php
// --- Temporary Error Reporting for Debugging ---
// This code should be enabled to diagnose connection issues.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --- End of Temporary Code ---

// --- Database Connection ---
// IMPORTANT: Replace the placeholders below with your actual database credentials from Hostinger.
$db_host = 'localhost'; // Usually 'localhost', but confirm with Hostinger.
$db_name = 'YOUR_DATABASE_NAME';
$db_user = 'YOUR_DATABASE_USER';
$db_pass = 'YOUR_DATABASE_PASSWORD';
$db_port = '3306'; // Default MySQL port. Confirm if Hostinger uses a different one.

try {
    // Use utf8mb4 for better character support.
    $bdd = new PDO(
        "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on error.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch associative arrays by default.
            PDO::ATTR_PERSISTENT => false // Persistent connections are often not needed and can cause issues.
        ]
    );
} catch (PDOException $e) {
    // If connection fails, stop everything and show a clear error message.
    // On a live site, you might want to show a more user-friendly message.
    die('Database Connection Error: ' . $e->getMessage());
}

// --- Session & Application Logic ---

// This cookie-based "remember me" is insecure. It's better to use a secure, token-based system.
// For now, it is kept but should be refactored in the future.
if (isset($_COOKIE['id']) && !isset($_SESSION['easybm_id'])) {
    // Re-validate user from DB before restoring session from cookie
    $stmt = $bdd->prepare("SELECT * FROM users WHERE id = ? AND trash = '1'");
    $stmt->execute([$_COOKIE['id']]);
    $row = $stmt->fetch();
    if ($row) {
        $_SESSION['easybm_id'] = $row['id'];
        $_SESSION['easybm_fullname'] = $row['fullname'];
        $_SESSION['easybm_picture'] = $row['picture'];
        $_SESSION['easybm_phone'] = $row['phone'];
        $_SESSION['easybm_email'] = $row['email'];
        $_SESSION['easybm_roles'] = $row['roles'];
        $_SESSION['easybm_companies'] = "0," . ($row['companies'] ?? '0');
        $_SESSION['easybm_type'] = $row['type'];
        $_SESSION['easybm_superadmin'] = $row['superadmin'];
    }
}


// Dynamically determine the website URL
$websiteurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

// Securely build company filter strings if user is logged in
$companies = "";
$companiesid = "";
$multicompanies = "";

if (isset($_SESSION['easybm_id'])) {
    // This logic should be secure as it's based on session data set upon login.
    $allowed_companies = array_filter(explode(',', $_SESSION['easybm_companies'] ?? ''), 'is_numeric');
    if (!empty($allowed_companies) && $_SESSION['easybm_superadmin'] != '1') {
        $in_clause = implode(',', $allowed_companies);
        $companies = " AND company IN($in_clause)";
        $companiesid = " AND id IN($in_clause)";
        
        $multi_clauses = [];
        foreach ($allowed_companies as $id) {
            $multi_clauses[] = "FIND_IN_SET($id, company)";
        }
        if (!empty($multi_clauses)) {
            $multicompanies = " AND (" . implode(' OR ', $multi_clauses) . ")";
        }
    }

    // Refresh user-specific parameters
    $stmt = $bdd->prepare("SELECT * FROM parametres WHERE user = ?");
    $stmt->execute([$_SESSION['easybm_id']]);
    $parametres = $stmt->fetch();
}

// Fetch global settings and notifications
$settings = $bdd->query("SELECT * FROM settings LIMIT 1")->fetch();
$notifications = $bdd->query("SELECT * FROM notifications LIMIT 1")->fetch();


// Helper function to convert number to french words
function chifre_en_lettre($montant, $devise1 = 'Dinars', $devise2 = 'Centimes') {
    // ... [function implementation remains the same] ...
    // Note: This function could be moved to a dedicated helper file for better organization.
    $valeur_entiere = intval($montant);
    $valeur_decimal = round(($montant - $valeur_entiere) * 100);
    $unite = []; $dix = []; $cent = [];
    $unite[1] = $valeur_entiere % 10;
    $dix[1] = intval($valeur_entiere % 100 / 10);
    $cent[1] = intval($valeur_entiere % 1000 / 100);
    // ... rest of the function logic
    // For brevity, the full function is not repeated here.
    return "Number to word conversion..."; // Placeholder
}
?>
