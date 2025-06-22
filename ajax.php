<?php
session_start();
include("config.php");
include('classes/Utilities.class.php');
include('classes/SimpleImage.class.php');
require 'vendor/autoload.php';

// --- Helper Functions ---

function has_role($role) {
    return isset($_SESSION['easybm_roles']) && preg_match("#" . preg_quote($role, '#') . "#", $_SESSION['easybm_roles']);
}

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function delete_image_with_thumbnails($filename) {
    if (empty($filename) || $filename === 'avatar.png') return;
    $prefixes = ['', 'micro_', 'cropped_', 'small_', 'large_'];
    foreach ($prefixes as $prefix) {
        $filepath = "uploads/" . $prefix . $filename;
        if (strpos($filepath, '..') === false && file_exists($filepath) && is_writable($filepath)) {
            unlink($filepath);
        }
    }
}

function getDateNow($date) {
    if (empty($date)) return null;
    return strtotime(str_replace("/", "-", $date) . ' 08:00:00');
}

/**
 * Securely builds and renders the HTML table for a given document type.
 */
function load_document_securely($bdd, $doc_type, $settings) {
    // ... [Function content from previous step] ...
    // This function is already refactored and secure.
}

/**
 * Securely builds and renders the HTML table for clients or suppliers.
 * @param PDO $bdd The PDO database connection.
 * @param string $entity_type 'client' or 'supplier'.
 * @param array $settings The application settings array.
 */
function load_entity_securely($bdd, $entity_type, $settings) {
    $is_client = $entity_type === 'client';
    $role = $is_client ? 'Consulter Clients' : 'Consulter Fournisseurs';
    $table_name = $is_client ? 'clients' : 'suppliers';
    $main_field = $is_client ? 'fullname' : 'title';
    $code_field = $is_client ? 'codecl' : 'codefo';

    if (!has_role($role)) {
        throw new Exception("Accès non autorisé pour consulter " . ($is_client ? "les clients." : "les fournisseurs."));
    }

    // Whitelist for sortable columns
    $sort_whitelist = ['code', $main_field, 'company', 'ice', 'phone', 'address', 'email'];
    $sortby = in_array($_POST['sortby'], $sort_whitelist) ? $_POST['sortby'] : 'id';
    $orderby = in_array(strtoupper($_POST['orderby']), ['ASC', 'DESC']) ? strtoupper($_POST['orderby']) : 'DESC';

    $params = [':state' => $_POST['state']];
    
    // Base query
    $sql = "SELECT e.*, c.rs as company_name 
            FROM `$table_name` e
            LEFT JOIN companies c ON e.company = c.id
            WHERE e.trash = :state";

    // Keyword filter
    if (!empty($_POST['keyword'])) {
        $sql .= " AND (e.code LIKE :keyword OR e.`$code_field` LIKE :keyword OR e.`$main_field` LIKE :keyword OR e.phone LIKE :keyword OR e.email LIKE :keyword OR e.ice LIKE :keyword)";
        $params[':keyword'] = '%' . $_POST['keyword'] . '%';
    }

    // Company filter
    if (!empty($_POST['company'])) {
        $company_ids = explode(',', $_POST['company']);
        $in_placeholders = implode(',', array_fill(0, count($company_ids), '?'));
        $sql .= " AND e.company IN ($in_placeholders)";
        foreach ($company_ids as $id) $params[] = $id;
    }
    
    // --- Execute queries ---
    $count_sql = preg_replace('/SELECT .*? FROM/', 'SELECT COUNT(e.id) FROM', preg_replace('/ORDER BY .*/', '', $sql));
    $stmt_count = $bdd->prepare($count_sql);
    $stmt_count->execute(array_values($params));
    $total_rows = $stmt_count->fetchColumn();

    $sql .= " ORDER BY e.$sortby $orderby LIMIT ?, ?";
    $params[] = (int)$_POST['start'];
    $params[] = (int)$_POST['nbpage'];

    $stmt = $bdd->prepare($sql);
    $stmt->execute(array_values($params));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- Render HTML ---
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr class="lx-first-tr">
            <td><label><input type="checkbox" name="selectall" value="selectall" /><del class="checkmark"></del></label></td>
            <td>Référence</td>
            <td>Nom</td>
            <td>Société</td>
            <td>ICE</td>
            <td>Téléphone</td>
            <td>Email</td>
            <td><i class="fa fa-ellipsis-v"></i></td>
        </tr>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><label><input type="checkbox" name="<?php echo e($entity_type);?>" value="<?php echo e($row['id']);?>" /><del class="checkmark"></del></label></td>
            <td><span><?php echo e($row['code']);?></span><br><span><?php echo e($row[$code_field]);?></span></td>
            <td><span><?php echo e($row[$main_field]);?></span></td>
            <td><span><?php echo e($row['company_name']);?></span></td>
            <td><span><?php echo e($row['ice']);?></span></td>
            <td><span><?php echo e($row['phone']);?></span></td>
            <td><span><?php echo e($row['email']);?></span></td>
            <td style="position:relative;">
                <a href="javascript:;" class="lx-open-edit-menu"><i class="fa fa-ellipsis-v"></i></a>
                <!-- Edit menu here, with all data-* attributes escaped using e() -->
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <input type="hidden" id="posts" value="<?php echo e($total_rows); ?>" />
    <p><?php echo e((int)$_POST['start'] + count($results)); ?> de <?php echo e($total_rows); ?> enregistrement(s)</p>
    <?php
}


// --- Main Action Router ---
try {
    $is_write_action = !in_array($action, ['loadusers', 'loadcompanies', 'loadcaisse', 'loadfactures', 'loaddevis', 'loadavoirs', 'loadbl', 'loadbs', 'loadbr', 'loadbc', 'loadbre', 'loadclients', 'loadsuppliers', 'loadkpi', 'loaddocuments', 'loadtop']);
    if ($is_write_action) {
        $bdd->beginTransaction();
    }

    switch ($action) {
        // ... [User, Settings, Company, Document creation cases] ...
        
        case 'loadfactures':        load_document_securely($bdd, 'facture', $settings); break;
        case 'loaddevis':           load_document_securely($bdd, 'devis', $settings); break;
        case 'loadavoirs':          load_document_securely($bdd, 'avoir', $settings); break;
        case 'loadbl':              load_document_securely($bdd, 'bl', $settings); break;
        case 'loadbs':              load_document_securely($bdd, 'bs', $settings); break;
        case 'loadbr':              load_document_securely($bdd, 'br', $settings); break;
        case 'loadfacturesproforma':load_document_securely($bdd, 'factureproforma', $settings); break;
        case 'loadbc':              load_document_securely($bdd, 'bc', $settings); break;
        case 'loadbre':             load_document_securely($bdd, 'bre', $settings); break;
        
        case 'loadclients':
            load_entity_securely($bdd, 'client', $settings);
            break;
        case 'loadsuppliers':
            load_entity_securely($bdd, 'supplier', $settings);
            break;

        // ... [loadcaisse and other complex load functions still need refactoring] ...

        default:
            if (!empty($action)) {
                 echo json_encode(["error" => "L'action '$action' n'est pas reconnue ou n'a pas encore été entièrement modernisée."]);
            }
            break;
    }

    if ($is_write_action && $bdd->inTransaction()) {
        $bdd->commit();
    }

} catch (PDOException $e) {
    if (isset($is_write_action) && $is_write_action && $bdd->inTransaction()) $bdd->rollBack();
    error_log("Database Error in ajax.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Une erreur de base de données est survenue."]);
} catch (Exception $e) {
    if (isset($is_write_action) && $is_write_action && $bdd->inTransaction()) $bdd->rollBack();
    http_response_code(403);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
