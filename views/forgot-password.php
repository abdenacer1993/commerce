<?php
session_start();

require __DIR__ . './db.php';
require __DIR__ . '/../csrf.php';
require __DIR__ . '/admin/util.php';
require __DIR__ . './sendgrid-php/sendgrid-php.php';

if(isset($_SESSION['name'])) {
    header('Location: ./home.php');
}

$success;

if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $code = rand(10000, 99999);
  $expirationTime = time() + (30 * 60); // Add 30 minutes to the current time
  $statement = $pdo->prepare("SELECT * FROM users WHERE email=?");
  $statement->execute(array($email));
  if($statement->rowCount() > 0) {
    $statement = $pdo->prepare("UPDATE users SET code=?, expiration=? WHERE email=?");
    $statement->execute(array($code, $expirationTime, $email));
    $mail = new \SendGrid\Mail\Mail();
    $mail->setFrom("Abdenacer1993@gmail.com", "AlGiNET");
    $mail->setSubject("Password Reset");
    $mail->addTo($email, $email);
    $mail->addContent("text/plain", "Reset code: ". $code . "\n\nIf you didn't request for a password reset, ignore this message.");
    $sendgrid = new \SendGrid($key);
    try {
      $sendgrid->send($mail);
    } catch (Exception $e) {
      
    }
    header('Location: ./reset?email='. $email);
  } else {
    $success = false;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>AlGiNET | Mot de passe oublié</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Constra HTML Template v1.0">
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.png" />
  
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="./plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="./plugins/bootstrap/css/bootstrap.min.css">
  
  <!-- Animate css -->
  <link rel="stylesheet" href="./plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="./plugins/slick/slick.css">
  <link rel="stylesheet" href="./plugins/slick/slick-theme.css">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="./css/style.css">

</head>

<body id="body">

<section class="forget-password-page account">
  <div class="container">
    <div class="row">
      <?php if(isset($success) && !$success): ?>
        <div class="alert alert-danger alert-common alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="tf-ion-android-checkbox-outline"></i>Le compte n'existe pas. Un code de réinitialisation vous sera envoyé. se connecter
        </div>
      <?php endif ?>
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <form class="text-left clearfix" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
            <p>S'il vous plait entrez l'adresse email pour votre compte. Un code de réinitialisation vous sera envoyé. se connecter</p>
            <?php CSRF::csrfInputField() ?>
            <div class="form-group">
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Adresse e-mail du compte">
            </div>
            <div class="text-center">
              <button type="submit" name="submit" class="btn btn-main text-center">Demander la réinitialisation du mot de passe</button>
            </div>
          </form>
          <p class="mt-20"><a href="./login">Retour connexion</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

   <!-- 
    Essential Scripts
    =====================================-->
    
    <!-- Main jQuery -->
    <script src="./plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.1 -->
    <script src="./plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Bootstrap Touchpin -->
    <script src="./plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- Instagram Feed Js -->
    <script src="./plugins/instafeed/instafeed.min.js"></script>
    <!-- Video Lightbox Plugin -->
    <script src="./plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
    <!-- Count Down Js -->
    <script src="./plugins/syo-timer/build/jquery.syotimer.min.js"></script>

    <!-- slick Carousel -->
    <script src="./plugins/slick/slick.min.js"></script>
    <script src="./plugins/slick/slick-animation.min.js'"></script>

    <!-- Main Js File -->
    <script src="./js/script.js"></script>
    <!-- <script type="module" src="js/index.js"></script> -->
    


  </body>
  </html>