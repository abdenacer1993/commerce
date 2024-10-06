<?php

session_start();
require __DIR__ . '/../csrf.php';
require __DIR__ . '/db.php';

if (isset($_SESSION['name'])) {
  header('Location: /');
}

$error = false;

if (isset($_POST['register']) && CSRF::validateToken($_POST['token'])) {
  $lastname = filter_input(INPUT_POST, 'lastname');
  $firstname = filter_input(INPUT_POST, 'firstname');
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $phone = filter_input(INPUT_POST, 'phone');
  $address = filter_input(INPUT_POST, 'address');
  $password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
  $createdTime = time();
  $role = 'client';

  $statement = $pdo->prepare("SELECT * FROM personnes WHERE email=?");
  $statement->execute(array($email));
  if ($statement->rowCount() > 0) {
    $error = true;
  } else {
    $statement = $pdo->prepare("INSERT INTO personnes (nom, prenom, email, telephone, addresse, mot_passe, role, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->execute(array($firstname, $lastname, $email, $phone, $address, $password, $role, $createdTime));
    session_start();
    $_SESSION['name'] = $lastname . ' ' . $firstname;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;
    $_SESSION['created-time'] = $createdTime;
    $_SESSION['role'] = $role;
    header('Location: ./home.php');
  }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>AlGiNET</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="AlGiNET">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="AlGiNET">
  <meta name="generator" content="AlGiNET">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

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
                <div class="alert alert-danger alert-common" role="alert"><i class="tf-ion-close-circled"></i><span>Échec
                    de l'enregistrement!</span> Email déjà enregistré</div>
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
            <form class="text-left clearfix" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
              <?php CSRF::csrfInputField() ?>
              <div class="form-group">
                <input type="text" name="firstname" class="form-control" placeholder="Nom">
              </div>
              <div class="form-group">
                <input type="text" name="lastname" class="form-control" placeholder="Prenom">
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="tel" name="phone" class="form-control" placeholder="Telephone">
              </div>
              <div class="form-group">
                <input type="text" name="address" class="form-control" placeholder="Addresse">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
              </div>
              <div class="text-center">
                <button name="register" type="submit" class="btn btn-main text-center">S'inscrire</button>
              </div>
            </form>
            <p class="mt-20">Vous avez de compte ?<a href="./login.php"> Se connecter</a></p>
            <!-- <p class="mt-20"><a href="./forgot-password">Mot de passe oublié ?</a></p> -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 
    Essential Scripts
    =====================================-->

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