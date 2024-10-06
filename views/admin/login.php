<?php
session_start();
// Disable error reporting in production
// error_reporting(0);
// ini_set('display_errors', 0);

require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';

$error = false;

if(isset($_POST['login']) && CSRF::validateToken($_POST['token'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // Validate email format
    $password = $_POST['password']; // No need for filtering as we're using password_verify

    if($email && $password) { // Check if email and password are provided
        $statement = $pdo->prepare("SELECT * FROM personnes WHERE email=? AND role='admin'");
        $statement->execute(array($email));

        if($statement->rowCount() > 0) {
            $result = $statement->fetch(PDO::FETCH_ASSOC); // Fetch only one row
            
            if(password_verify($password, $result['mot_passe'])) {
                // Generate a new session ID and delete the old one to mitigate session fixation attacks
                session_regenerate_id(true);
                // Set session variables securely
                
                $_SESSION['name'] =  $result['nom']. " " . $result['prenom'];
                $_SESSION['role'] = $result['role'];
                // Regenerate CSRF token
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                // Redirect to home page
                header('Location: ./home.php');
                exit(); // Ensure script stops execution after redirection
            }
        }
    }
    $error = true; // Set error if login fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <title>AlGiNET | Admin</title>
    <!-- Include CSS files -->
    <link rel="stylesheet" href="plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">

  <!-- Animate css -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body id="body">

  <section class="signin-page account">
    <div class="container">
      <div class="row">

        <?php if ($error): ?>
          <div class="row mt-30">
            <div class="col-xs-12">
              <div class="alertPart">
                <div class="alert alert-danger alert-common" role="alert"><i class="tf-ion-close-circled"></i><span>Login
                    Echec!</span> Verifier email/mot de passe</div>
              </div>
            </div>
          </div>
        <?php endif ?>

        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center">
            <a href="/">
            <svg width="250px" height="29px" viewBox="0 0 200 29" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40"
                  font-family="AustinBold, Austin" font-weight="bold">
                  <g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
                    <a href="home.php">
                      <text id="AVIATO">
                        <tspan x="108.94" y="325">AlGiNET</tspan>
                      </text>
                    </a>

                  </g>
                </g>
              </svg>
            </a>
            <h2 class="text-center">Bienvenue</h2>
            <h4 class="text-center">Login Administrateur</h4>
            <form class="text-left clearfix" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
              <?php CSRF::csrfInputField() ?>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
              </div>
              <div class="text-center">
                <button name="login" type="submit" class="btn btn-main text-center">Se connecter</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Include JavaScript files -->
  <!-- Main jQuery -->
  <script src="plugins/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.1 -->
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap Touchpin -->
  <script src="plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
  <!-- Video Lightbox Plugin -->
  <script src="plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
  <!-- Count Down Js -->
  <script src="plugins/syo-timer/build/jquery.syotimer.min.js"></script>

  <!-- slick Carousel -->
  <script src="plugins/slick/slick.min.js"></script>
  <script src="plugins/slick/slick-animation.min.js'"></script>

  <!-- Main Js File -->
  <script src="js/script.js"></script>

</body>
</html>
