<?php

session_start();
require __DIR__ . '/../csrf.php';
require __DIR__ . '/db.php';

if (isset($_SESSION['name'])) {
  header('Location: ./home.php');
}

$error = false;

if (isset($_POST['login']) && CSRF::validateToken($_POST['token'])) {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);//hadha ihez contenu mta3 input ili hiya email
  $password = filter_input(INPUT_POST, 'password');//hadha ihez contenu mta3 input pass 
  $statement = $pdo->prepare("SELECT * FROM personnes WHERE email=? and role !='admin'");//hadhi yimchi lil bas o ijib les 
  $statement->execute(array($email));// itest mail ili ktbtou fil input m3ta ili ijbnah mil baz
  if ($statement->rowCount() > 0) { //kan lgha lmail mawjoud rouCount traj3lk 1
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (password_verify($password, $result[0]['mot_passe'])) {
      $_SESSION['id'] = $result[0]["id"];
      $_SESSION['name'] = $result[0]['nom'] . ' ' . $result[0]['prenom'];
      $_SESSION['email'] = $result[0]['email'];
      $_SESSION['phone'] = $result[0]['telephone'];
      $_SESSION['address'] = $result[0]['addresse'];
      $_SESSION['created-time'] = $result[0]['date_creation'];
      $_SESSION['role'] = $result[0]['role'];
      header('Location: ./home.php');
    }
    $error = true; //hadhi kif rj3lk 0 m3naha moch mawjoud traj3lk error
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
                <div class="alert alert-danger alert-common" role="alert"><i class="tf-ion-close-circled"></i><span>Login
                    Failed!</span> Invalid username/password</div>
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
            <p class="mt-20">Vous n'avez pas de compte ?<a href="./register.php"> Créer un nouveau compte client</a></p>
            <p class="mt-20">Vous n'avez pas de compte ?<a href="./register_inv.php"> Créer un nouveau compte investisseur</a></p>
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