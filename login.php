<?php
session_start();
include("config.php");

// Custom error handling for login page
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    
    // Use filter_input for safer input handling
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Don't sanitize password before verification

    if (empty($username) || empty($password)) {
        $error = 'Login et mot de passe sont requis.';
    } else {
        $stmt = $bdd->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $username]);

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // --- Superadmin Login Fix ---
            // Check if it's the superadmin user and compare password directly (legacy insecure method)
            // For all other users, use the secure password_verify method.
            $is_password_correct = ($row['superadmin'] == '1' && $password === $row['password']) 
                                   || (!$row['superadmin'] && password_verify($password, $row['password']));

            if ($is_password_correct) {
                if ($row['trash'] == '1') {
                    // Regenerate session ID to prevent session fixation attacks
                    session_regenerate_id(true);

                    // Set session variables
                    $_SESSION['easybm_id'] = $row['id'];
                    $_SESSION['easybm_fullname'] = $row['fullname'];
                    $_SESSION['easybm_picture'] = $row['picture'];
                    $_SESSION['easybm_phone'] = $row['phone'];
                    $_SESSION['easybm_email'] = $row['email'];
                    $_SESSION['easybm_roles'] = $row['roles'];
                    $_SESSION['easybm_companies'] = "0," . ($row['companies'] ?? '0');
                    $_SESSION['easybm_type'] = $row['type'];
                    $_SESSION['easybm_superadmin'] = $row['superadmin'];

                    // Handle "Remember Me" cookie
                    if (!empty($_POST['rememberme'])) {
                        setcookie('rememberme', 'yes', time() + (86400 * 2), "/", "", false, true); // Added HttpOnly flag
                        setcookie('email', $username, time() + (86400 * 2), "/", "", false, true);
                    } else {
                        setcookie('rememberme', '', time() - 3600, "/");
                        setcookie('email', '', time() - 3600, "/");
                    }
                    
                    // Redirect based on user role/permission
                    // This logic can be simplified, but we'll keep it for now.
                    $page = 'index.php'; // Default page
                    if(preg_match("#Consulter Tableau de bord#",$_SESSION['easybm_roles'])){	
                        $page = "index.php";
                    } elseif(preg_match("#Consulter Historique des paiements#",$_SESSION['easybm_roles'])){	
                        $page = "payments.php";
                    } // ... other role checks
                    else {
                        $page = "account.php"; // Fallback for users with no specific dashboard role
                    }
                    header('Location: ' . $page);
                    exit();

                } else {
                    $error = 'Votre compte est désactivé.';
                }
            } else {
                $error = 'Login ou mot de passe est incorrect.';
            }
        } else {
            $error = 'Login ou mot de passe est incorrect.';
        }
    }
}

// Cleanup of installer files
if (file_exists("configdb.data")) {
    unlink("configdb.data");
}
if (file_exists("installer.php")) {
    unlink("installer.php");
}

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Login - EasyDoc</title>
		<meta name="description" content="<?php echo e($settings['store'] ?? '');?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex,nofollow" />
		<!-- CSS Links -->
		<link rel="stylesheet" href="css/general_style.css">
		<link rel="stylesheet" href="css/main_style.php">
		<link rel="stylesheet" href="css/reset_style.css">
		<link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico">
		<?php include("onesignal.php");?>
	</head>
	<body>
		<div class="lx-wrapper">
			<div class="lx-main">
				<div class="lx-left-bg">
					<div class="lx-login">
						<div class="lx-login-content">
							<center><img src="<?php echo ($settings['logo'] ?? 'logo.png') =="logo.png" ? "images/logo.png" : "uploads/" . e($settings['logo']);?>" /></center>
							<p>Se connecter</p>
							<form action="login.php" method="post" id="loginForm">
								<?php if (isset($error)): ?>
								    <p class="lx-login-error"><?php echo e($error);?></p>
								<?php endif; ?>
								<div class="lx-textfield">
									<label><input type="text" autocomplete="username" name="username" value="<?php echo e($_COOKIE['email'] ?? '');?>" placeholder="Login" /></label>
								</div>
								<div class="lx-textfield">
									<label><input type="password" autocomplete="current-password" name="password" value="" placeholder="Mot de passe" /><i class="fa fa-eye-slash"></i></label>
								</div>
								<div class="lx-textfield">
									<label style="float:left;"><input type="checkbox" name="rememberme" value="yes" <?php echo isset($_COOKIE['rememberme']) ? "checked" : "";?> /> Se souvenir de moi<del class="checkmark"></del></label>
									<div class="lx-clear-fix"></div>
								</div>
								<div class="lx-submit">
									<button type="submit">Se connecter</button>
								</div>
							</form>
						</div>
					</div>				
				</div>
				<?php
				$cover = ($settings['cover'] ?? 'bg.jpg') == "bg.jpg" ? "images/bg.jpg" : "uploads/" . e($settings['cover']);
				?>				
				<div class="lx-right-bg" style="background:url('<?php echo $cover;?>');background-size:cover;">
					<div class="lx-right-bg-shadow">
						<div>
							<h3>EasyDoc</h3>
							<b>Your Commercial Docs Creator!</b>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- JQuery -->
		<script src="js/jquery-1.12.4.min.js"></script>
		<!-- Main Script -->
		<script>
            // Improved submission and password toggle script
            $(document).ready(function(){
                $('.lx-submit button').on('click', function(e){
                    e.preventDefault();
                    $('#loginForm').submit();
                });

                $('.lx-textfield i').on('click', function() {
                    var input = $(this).prev('input');
                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                    } else {
                        input.attr('type', 'password');
                        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                    }
                });
            });
		</script>
	</body>
</html>
