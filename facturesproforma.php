<?php include("facturesproforma_logic.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Factures Proforma</title>
    <meta name="description" content="<?php echo $settings['store']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DateRangePicker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/facturesproforma.css">
    
    <link rel="shortcut icon" href="favicon.ico">
    <?php include("onesignal.php"); ?>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include('mainmenu.php'); ?>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <!-- Header -->
        <?php include('header.php'); ?>

        <main class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4">Gestion des Factures Proforma</h2>
                <?php if (preg_match("#Ajouter Factures proforma,#", $_SESSION['easybm_roles'])): ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFactureProformaModal">
                        <i class="fas fa-plus"></i> Nouvelle facture proforma
                    </button>
                <?php endif; ?>
            </div>

            <ul class="nav nav-tabs mb-4">
                <?php if(preg_match("#Consulter Factures,#",$_SESSION['easybm_roles'])): ?>
                    <li class="nav-item"><a class="nav-link" href="factures.php">Factures</a></li>
                <?php endif; ?>
                <?php if(preg_match("#Consulter Devis#",$_SESSION['easybm_roles'])): ?>
                    <li class="nav-item"><a class="nav-link" href="devis.php">Devis</a></li>
                <?php endif; ?>
                <?php if(preg_match("#Consulter Factures avoir#",$_SESSION['easybm_roles'])): ?>
                    <li class="nav-item"><a class="nav-link" href="avoirs.php">Factures avoir</a></li>
                <?php endif; ?>
                <?php if(preg_match("#Consulter Bons de retour#",$_SESSION['easybm_roles'])): ?>
                    <li class="nav-item"><a class="nav-link" href="br.php">Bons de retour</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link active" href="facturesproforma.php">Factures proforma</a></li>
                <?php if(preg_match("#Consulter Bons de livraison#",$_SESSION['easybm_roles'])): ?>
                    <li class="nav-item"><a class="nav-link" href="bl.php">Bons de livraison</a></li>
                <?php endif; ?>
                <?php if(preg_match("#Consulter Bons de sortie#",$_SESSION['easybm_roles'])): ?>
                    <li class="nav-item"><a class="nav-link" href="bs.php">Bons de sortie</a></li>
                <?php endif; ?>
            </ul>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filtres</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="keyword" placeholder="Réf facture proforma, client...">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="dateadd" placeholder="Période" value="">
                            <input type="hidden" id="datestart" value="">
                            <input type="hidden" id="dateend" value="">
                        </div>
                        <div class="col-md-4">
                            <select id="company" class="form-select">
                                <option value="">Toutes les sociétés</option>
                                <?php foreach ($companies as $company): ?>
                                    <option value="<?php echo $company['id']; ?>"><?php echo $company['rs']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <div class="lx-table-facturesproforma">
                    <!-- Factures proforma table will be loaded here by JavaScript -->
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="lx-action-bulk">
                     <?php if(preg_match("#Exporter Factures proforma,#",$_SESSION['easybm_roles'])): ?>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exportFactureProformaModal">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                     <?php endif; ?>
                </div>
                <div class="d-flex align-items-center">
                    <label for="nbrows" class="form-label me-2 text-muted">Afficher:</label>
                    <select name="nbrows" id="nbrows" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50" selected>50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-muted small">lignes par page</span>
                </div>
                <div class="lx-pagination">
                    <!-- Pagination will be loaded here -->
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Facture Proforma Modal -->
<div class="modal fade" id="addFactureProformaModal" tabindex="-1" aria-labelledby="addFactureProformaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFactureProformaModalLabel">Ajouter une nouvelle facture proforma</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Add your form here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<!-- Export Facture Proforma Modal -->
<div class="modal fade" id="exportFactureProformaModal" tabindex="-1" aria-labelledby="exportFactureProformaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportFactureProformaModalLabel">Exporter les factures proforma</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Add your export options here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary">Exporter</button>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DateRangePicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Custom JS -->
<script src="js/facturesproforma.js"></script>

</body>
</html>
